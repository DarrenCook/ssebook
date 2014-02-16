<?php
header("Content-Type: text/plain");

if(array_key_exists("HTTP_USER_AGENT",$_SERVER)
  && strpos($_SERVER["HTTP_USER_AGENT"],"Chrome/") !== false)
  echo str_repeat(" ",1023)."\n"; 
@ob_flush();@flush();

$ch = "A";
while(true){
  echo json_encode($ch.$ch)."\n";
  @ob_flush();@flush();
  if($ch == "Z")break;
  ++$ch;
  sleep(1);
  }
?>