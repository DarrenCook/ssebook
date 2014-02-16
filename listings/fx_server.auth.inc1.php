<?php
switch($_SERVER['REQUEST_METHOD']){
  case 'GET':case 'POST':break;
  case 'OPTIONS':
    header("Access-Control-Allow-Origin: ".@$_SERVER['HTTP_ORIGIN']);
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Headers: Last-Event-ID, Origin, X-Requested-With, Content-Type, Accept, Authorization");
    exit;
  default:
    header("HTTP/1.0 405 Method Not Allowed");
    header("Allow: GET,POST,OPTIONS");
    exit;
  }

$GLOBALS['is_longpoll'] = array_key_exists('longpoll',$_POST)
  || array_key_exists('longpoll',$_GET);
$GLOBALS['is_xhr'] = array_key_exists('xhr',$_POST)
  || array_key_exists('xhr',$_GET);
$GLOBALS['is_sse'] = !($GLOBALS['is_longpoll'] || $GLOBALS['is_xhr']);

date_default_timezone_set('UTC');
set_time_limit(0);

include_once("fxpair.id.php");

$symbols = array(
  new FXPair('EUR/USD', 1.3030, 0.0001, 5, 360, 47),
  new FXPair('EUR/USD', 1.3030, 0.0001, 5, 360, 47),
  new FXPair('USD/JPY', 95.10, 0.01, 3, 341, 55),
  new FXPair('AUD/GBP', 1.455, 0.0002, 5, 319, 39),
  );


if (!defined('PASSWORD_DEFAULT')) { //For 5.4.x and earlier
  function password_verify($password, $hash) {
  return crypt($password,$hash) === $hash;
  }
}   //End of if (!defined('PASSWORD_DEFAULT'))


function sendData($data){
if($GLOBALS['is_sse'])echo "data:";
echo json_encode($data)."\n";
if($GLOBALS['is_sse'])echo "\n";  //Extra blank line
@flush();@ob_flush();
}

function sendIdAndData($data){
if($GLOBALS['is_sse']){
    $id = $data['rows'][0]['id'];
    echo "id:".json_encode($id)."\n";
    }
sendData($data);
}

function sendHeaders(){
if($GLOBALS['is_sse'])header("Content-Type: text/event-stream");
else header("Content-Type: text/plain");

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

header("Access-Control-Allow-Origin: ".@$_SERVER['HTTP_ORIGIN']);
header("Access-Control-Allow-Credentials: true");
}
