<?php
if (!defined('PASSWORD_DEFAULT')) { //For 5.4.x and earlier
  function password_verify($password, $hash) {
  return crypt($password,$hash) === $hash;
  }
}   //End of if (!defined('PASSWORD_DEFAULT'))

$user = @$_SERVER['PHP_AUTH_USER'];
$pw = @$_SERVER['PHP_AUTH_PW'];

$fromDB = '$2a$10$4LLeBta770Y0Z7795j.8'.
  'He/ZCQonnvImXIX0egalzE1MuWiEa6PQa';
if(!password_verify($pw,$fromDB)){
  header('WWW-Authenticate: Basic realm="SSE Book"');
  header('HTTP/1.0 401 Unauthorized');
  echo "Please authenticate.\n";
  exit;
  }

$SSE = (@$_SERVER['HTTP_ACCEPT'] == 'text/event-stream');
if($SSE)header("Content-Type: text/event-stream");
else header("Content-Type: text/plain");

while(true){
  echo "data:".date("Y-m-d H:i:s")."\n\n";
  @ob_flush();@flush();
  sleep(1);
  }
?>