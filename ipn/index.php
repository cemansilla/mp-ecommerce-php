<?php
$config = require(__DIR__ . '/../server/config.php');

$files = glob(__DIR__ . "/*.json");

foreach($files as $file){
  $filename = basename($file);
  echo sprintf("<a href='%s' target='_blank'>%s</a>", $config['base_url'] . $filename, $filename);
  echo "<br>";
}
?>