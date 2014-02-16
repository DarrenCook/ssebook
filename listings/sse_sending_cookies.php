<?php
header("Content-Type: text/event-stream");

$accessCount = (int)@$_COOKIE["accessCount"] + 1;
header("Set-Cookie: accessCount=".$accessCount);

while(true){
  echo "data:".$accessCount.":".date("Y-m-d H:i:s")."\n\n";
  @ob_flush();@flush();
  sleep(1);
  }
