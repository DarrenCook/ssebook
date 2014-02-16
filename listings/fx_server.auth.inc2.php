<?php

//file_put_contents("tmp.".microtime(true).".log",  print_r($_SERVER,true));  //TEMP

$clock = microtime(true);
if(isset($argc) && $argc>=2 && $argv[1]!='')
    $t = $argv[1];
elseif(array_key_exists('seed',$_REQUEST))
    $t = $_REQUEST['seed'];
else{
    $t = $clock;
    sendData( array('seed' => $t) );
    }

if(array_key_exists('HTTP_LAST_EVENT_ID',$_SERVER)){
    $lastId = $_SERVER['HTTP_LAST_EVENT_ID'];
    }
elseif(array_key_exists('last_id',$_POST)){
    $lastId = $_POST['last_id'];
    }
elseif(array_key_exists('last_id',$_GET)){
    $lastId = $_GET['last_id'];
    }
elseif(isset($argc) && $argc>=3)$lastId = $argv[2];  //commandline control
else $lastId = null;

if($lastId)$t = $lastId / 1000.0;

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
  sendIdAndData($symbols[$ix]->generate($t));

  if($GLOBALS['is_longpoll'])break;
  }
