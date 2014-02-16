<?php
$SSE = (@$_SERVER['HTTP_ACCEPT'] == 'text/event-stream');
if($SSE)header("Content-Type: text/event-stream");
else header("Content-Type: text/plain");

file_put_contents("tmp.log",
  print_r($_SERVER,true));
?>