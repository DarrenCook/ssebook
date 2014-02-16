<?php
header("Content-Type: text/event-stream");

function sendData($data){
echo "data:";
echo json_encode($data)."\n";
echo "\n";  //Extra blank line
@flush();@ob_flush();
}

//--------------------------------------
while(true){
  switch(rand(1,10)){
    case 1:
      sendData( array("comeBackIn10s" => true) );
      exit;
    case 2:
      sendData( array("msg" => "About to sleep 10s") );
      sleep(10);  //Force a keep-alive timeout
      break;
    default:
      sendData( array("t" => date("Y-m-d H:i:s")) );
      sleep(1);
      break;
    }
  }
