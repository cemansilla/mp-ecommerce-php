<?php
header("HTTP/1.1 200 OK");
echo "HTTP/1.1 200 OK";

$fp = fopen(__DIR__ . "/ipn/" . date('Y-m-d_H-i-s') . ".json", "w");
fwrite($fp, $_POST);
fclose($fp);
?>