<?php
  /** Constants **/
  define("POKERBOTS_DIR", "/pokerbots/");
  define("TOURNAMENTS_DIR", "/pokerbots/tournaments/");
  define("UPLOAD_DIR", "/pokerbots/allbots/");
  define("PID_FILE", "poker_serv.pid");
  define("LEADERBOARD_FILE", "leaderboard.html");
  define("STDOUT_FILE", "gameserver.stdout");
  define("ALL_MSGS_FILE", "all_messages.log.gz");
  define("FILE_LIMIT", "500000");

  function maybeEchoFile($fname, $pre) {
    if (is_file($fname)) {
      if ($pre === true) echo "<pre>";
      echo file_get_contents($fname);
      if ($pre === true) echo "</pre>";
    }
    else {
      echo "<p> File not found. </p>";
    }
  }

  function echoStatus() {
    if (is_file(POKERBOTS_DIR . PID_FILE)) {
      echo '<span class="good">LIVE</span>';
    }
    else {
      echo '<span class="bad">DEAD</span>';
    }
  }

  function echoHeader($title) {?>

<html>
<head>
<title>PokerBots <?echo $title;?></title>
<link rel="stylesheet" type="text/css" href="default.css" />
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<script type="text/javascript" src="plot.js"></script>
</head>

<?
  }

  function echoFooter() {?>
</html>
<?
  }

  function echoHeading($name) {?>
<div class="heading">
  <h1><? echo $name; ?></h1>
  <div class="status">Gameserver is <? echoStatus(); ?></div>
</div>
<?
  }

  function echoTitleBar() {?>
<div id="titlebar">
<a href="index.php">Home</a> |
<a href="upload.php">Upload</a> |
<a href="leaderboard.php">Leaderboard</a>
</div>
<?
  }
?>