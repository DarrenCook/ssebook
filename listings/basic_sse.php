<?php
header("Content-Type: text/event-stream");
while(true){
  echo "data:".date("Y-m-d H:i:s")."\n\n";
  @ob_flush();@flush();
  sleep(1);
  }
