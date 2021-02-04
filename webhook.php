<?php
header("HTTP/1.1 200 OK");
echo "HTTP/1.1 200 OK";

$json = file_get_contents('php://input');

$fp = fopen(__DIR__ . "/ipn/" . date('Y-m-d_H-i-s') . "-request.json", "w");
fwrite($fp, $json);
fclose($fp);
?>