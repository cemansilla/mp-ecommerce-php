<?php
$fp = fopen(__DIR__ . "/ipn/" . date('Y-m-d_H-i-s') . "-request.json", "w");
fwrite($fp, $_REQUEST);
fclose($fp);

header("HTTP/1.1 200 OK");
echo "HTTP/1.1 200 OK";
?>