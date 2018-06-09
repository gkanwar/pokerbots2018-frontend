<?php
  include 'common.php.inc';

  echoHeader('Leaderboard');
?>

<body> <? echoHeading('Leaderboard'); ?>
<div class="main">
<? echoTitleBar(); ?>
<br/>
<?
  $timestamp = (isset($_GET['t']) && is_numeric($_GET['t']) ? (int)$_GET['t'] : 0);
  $rid = (isset($_GET['rid']) && is_numeric($_GET['rid'])) ? (int)$_GET['rid'] : -1;
  $tid = (isset($_GET['tid']) && is_numeric($_GET['tid'])) ? (int)$_GET['tid'] : -1;
  $req = (isset($_GET['req']) ? $_GET['req'] : 'leaderboard');
  $possibleDir = TOURNAMENTS_DIR . $timestamp;
  if (is_dir($possibleDir)) {
    if ($req === 'leaderboard') {
      $possibleFile = TOURNAMENTS_DIR . $timestamp . '/' . LEADERBOARD_FILE;
      maybeEchoFile($possibleFile, false);
    }
    else if ($req === 'stdout' && $rid > 0 && $tid > 0) {
      $possibleFile = TOURNAMENTS_DIR . $timestamp . '/round' . $rid . '/table' . $tid . '/' .STDOUT_FILE;
      maybeEchoFile($possibleFile, true);
    }
    else if ($req === 'all_messages') {
      echo "<p> all_messages.log.gz download not supported yet. </p>";
    }
    else if ($req === 'player0' && $rid > 0 && $tid > 0) {
      $possibleFile = TOURNAMENTS_DIR . $timestamp . '/round' . $rid . '/table' . $tid . '/player0.log';
      maybeEchoFile($possibleFile, true);
    }
    else if ($req === 'player1' && $rid > 0 && $tid > 0) {
      $possibleFile = TOURNAMENTS_DIR . $timestamp . '/round' . $rid . '/table' . $tid . '/player1.log';
      maybeEchoFile($possibleFile, true);
    }
    else if ($req === 'player2' && $rid > 0 && $tid > 0) {
      $possibleFile = TOURNAMENTS_DIR . $timestamp . '/round' . $rid . '/table' . $tid . '/player2.log';
      maybeEchoFile($possibleFile, true);
    }
  }
  else {
    echo file_get_contents(POKERBOTS_DIR . LEADERBOARD_FILE);
  }
?>

</div>
</body>

<?
  echoFooter();
?>