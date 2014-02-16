<?php
if (!defined("PASSWORD_DEFAULT")) { //For 5.4.x and earlier
  function password_verify($password, $hash) {
  return crypt($password,$hash) === $hash;
  }
}   //End of if (!defined("PASSWORD_DEFAULT"))

$SSE = (@$_SERVER["HTTP_ACCEPT"] == "text/event-stream");
if($SSE)header("Content-Type: text/event-stream");
else header("Content-Type: text/plain");

if(!array_key_exists("login", $_COOKIE)){
    echo "data: The login cookie is missing. Exiting.\n\n";
    exit;
    }
list($user, $pw) = explode(",", $_COOKIE["login"]);

$fromDB = '$2a$10$4LLeBta770Y0Z7795j.8'.
  'He/ZCQonnvImXIX0egalzE1MuWiEa6PQa';

if(!password_verify($pw, $fromDB)){
  echo "data: The login cookie is bad. Exiting.\n\n";
  exit;
  }

while(true){
  echo "data:".date("Y-m-d H:i:s")."\n\n";
  @ob_flush();@flush();
  sleep(1);
  }
