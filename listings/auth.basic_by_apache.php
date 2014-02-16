<?php

$SSE = (@$_SERVER['HTTP_ACCEPT'] == 'text/event-stream');
if($SSE)header("Content-Type: text/event-stream");
else header("Content-Type: text/plain");

if(!@$_SERVER['REMOTE_USER']){
    echo "data: System problem. Exiting.\n\n";
    exit;
    }

while(true){
  echo "data:".date("Y-m-d H:i:s")."\n\n";
  @ob_flush();@flush();
  sleep(1);
  }
?>