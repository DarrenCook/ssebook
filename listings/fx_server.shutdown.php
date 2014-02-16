<?php
date_default_timezone_set('UTC');

include_once("fxpair.structured.php");

header("Content-Type: text/event-stream");

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

$nextKeepalive = time() + 15;

while(true){
  $sleepSecs = mt_rand(250,500)/1000.0;
  $now = microtime(true);
  $adjustment = $now - $clock;

  usleep( ($sleepSecs - $adjustment) * 1000000 );
  $t += $sleepSecs;
  $clock += $sleepSecs;

  $s = @file_get_contents("shutdown.txt");
  if($s){
    $when = strtotime($s);
    $untilSecs = $when - time();
    if($when > 0 && $untilSecs > 0){
      $until = date("Y-m-d H:i:s T",$when);
      sendData( array(
        'action' => 'scheduled_shutdown',
        'until' => $until,
        'until_secs' => $untilSecs
        ) );
      break;
      }
    //else ignore: either a bad timestamp or time has already passed
    }

  if(time()>$nextKeepalive){
    sendData( array(
      'action' => 'keep-alive',
      'timestamp' => gmdate("Y-m-d H:i:s")
      ) );
    $nextKeepalive = time() + 15;
    }
  $ix = mt_rand(0,count($symbols)-1);
  sendData($symbols[$ix]->generate($t));
  }
