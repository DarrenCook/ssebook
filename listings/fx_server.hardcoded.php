<?php
header("Content-Type: text/event-stream");

while(true){
  $sleepSecs = mt_rand(250,500)/1000.0;
  usleep( $sleepSecs * 1000000 );

  $d=array(
    "timestamp" => gmdate("Y-m-d H:i:s"),
    "symbol" => "EUR/USD",
    "bid" => 1.303,
    "ask" => 1.304,
    );
  echo "data:".json_encode($d)."\n\n";
  @ob_flush();@flush();
  }
