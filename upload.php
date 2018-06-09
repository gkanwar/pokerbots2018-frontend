<?php
  include 'common.php.inc';

  function checkBotName($name) {
    if (strlen($name) > 32) {
      die('Bot name cannot be longer than 32 chars.');
    }
    if (!filter_var($name, FILTER_VALIDATE_REGEXP,
         array("options" => array("regexp" => "/^[a-z0-9]+$/")))) {
      die('Bot name must match [a-z0-9].');
    }
  }
  function checkBotAuthor($name) {
    if (strlen($name) > 32) {
      die('Author name cannot be longer than 32 chars.');
    }
    if (!filter_var($name, FILTER_VALIDATE_REGEXP,
         array("options" => array("regexp" => "/^[a-zA-Z0-9]+$/")))) {
      die('Author name must match /[a-zA-Z0-9]+/.');
    }
  }
  function checkAndMoveBotFile($file, $name, $author) {
    if (!isset($file['error']) || is_array($file['error'])) {
      die('Bad file err param.');
    }
    switch($file['error']) {
      case UPLOAD_ERR_OK: break;
      case UPLOAD_ERR_NO_FILE: die('Must upload a file.');
      case UPLOAD_ERR_INI_SIZE:
      case UPLOAD_ERR_FORM_SIZE: die('Exceeded filesize limit.');
      default: die('Unknown file error.');
    }
    if ($file['size'] > FILE_LIMIT) {
      die('Exceeded filesize limit ' . FILE_LIMIT . '.');
    }
    $dirName = UPLOAD_DIR . $name;
    if (!is_dir($dirName) && !mkdir($dirName, 0770)) {
      die('Could not create bot directory ' . $dirName . '.');
    }
    $targetName = $dirName . '/bot';
    $backupName = $targetName . '_' . time() . '.bak';
    if (is_file($targetName)) {
      echo "<p> Backing up old bot to: $backupName </p>";
    }
    if (is_file($targetName) &&
        !(chmod($targetName, 0660) &&
          rename($targetName, $backupName))) {
      die('Could not safely back up old bot.');
    }
    if (!move_uploaded_file($file['tmp_name'], $targetName)) {
      die('Could not move bot to directory.');
    }
    if (!chmod($targetName, 0770)) {
      die('Could not make bot executable.');
    }
    $authorFile = $dirName . '/author';
    if (!file_put_contents($authorFile, $author)) {
      die('Could not write author name to bot directory.');
    }
  }

  echoHeader('Upload');?>
<body> <? echoHeading('Upload'); ?>
<div class="main">
<?
  echoTitleBar();

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $botName = $_POST['bot_name'];
    $botAuthor = $_POST['bot_author'];
    checkBotName($botName);
    checkBotAuthor($botAuthor);
    checkAndMoveBotFile($_FILES['bot_file'], $botName, $botAuthor);
    ?>
Successfully accepted bot <?echo $botName;?>. Thank you <?echo $botAuthor;?>.
<?
  }
  else {
?>
<p>
Upload a bot below. If there is a bot name collision, the old
bot is simply backed up and replaced. Since we're all friends here
we can be careful about this. Max file size is <? echo FILE_LIMIT; ?> bytes for now.
</p>

<form action="upload.php" enctype="multipart/form-data" method="post">
  Bot name (lowercase a-z and 0-9 only): <br/>
  <input type="text" name="bot_name" /> <br/>
  Author (a-z, A-Z, and 0-9 only)    : <br/>
  <input type="text" name="bot_author" /> <br/>
  <input type="file" name="bot_file" /> <br/><br/>
  <input type="submit" name="bot_submit" value="Upload!"/>
</form>

<?
  }
  echo '</div>';
  echo '</body>';
  echoFooter();
?>