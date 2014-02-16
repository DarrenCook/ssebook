<?php
include_once("fxpair.structured.php");

header("Content-Type: text/event-stream");

sendData( array('retry' => 21000) );

$symbols = array(
  new FXPair('EUR/USD', 1.3030, 0.0001, 5, 360, 47),
  new FXPair('EUR/USD', 1.3030, 0.0001, 5, 360, 47),
  new FXPair('USD/JPY', 95.10, 0.01, 3, 341, 55),
  new FXPair('AUD/GBP', 1.455, 0.0002, 5, 319, 39),
  );

function sendData($data){
echo "data:";
echo json_encode($data)."\n";
echo "\n";
@flush();@ob_flush();
}

$clock = microtime(true);
if(isset($argc) && $argc>=2)
    $t = $argv[1];
elseif(array_key_exists('seed',$_REQUEST))
    $t = $_REQUEST['seed'];
else{
    $t = $clock;
    sendData( array('seed' => $t) );
    }
mt_srand($t*1000);

while(true){
  $sleepSecs = mt_rand(250,500)/1000.0;
  $now = microtime(true);
  $adjustment = $now - $clock;

  usleep( ($sleepSecs - $adjustment) * 1000000 );
  $t += $sleepSecs;
  $clock += $sleepSecs;

  if(time()%23 == 0)break;
  $ix = mt_rand(0,count($symbols)-1);
  sendData($symbols[$ix]->generate($t));
  }
