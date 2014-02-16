<?php
$SSE=(@$_SERVER["HTTP_ACCEPT"] == "text/event-stream");

header("Access-Control-Allow-Origin: ".
  @$_SERVER["HTTP_ORIGIN"]);
header("Access-Control-Allow-Credentials: true");

if($SSE)header("Content-Type: text/event-stream");
else header("Content-Type: text/plain");

ob_start();                                                                                                       
phpinfo();                                                                                                        
$info = ob_get_contents();                                                                                        
ob_end_clean();

if($SSE)echo "data:";
echo json_encode($info);
echo "\n\n";
@ob_flush();@flush();

if($SSE)sleep(60);  //This just stops EventSource reconnecting every few seconds!
?>