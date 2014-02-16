<?php
include_once("fx_server.auth.inc1.php");

sendHeaders();

if(array_key_exists("login",$_COOKIE))$d = $_COOKIE["login"];
elseif(array_key_exists("login",$_POST))$d = $_POST["login"];
else{
  sendData(array(
    "action"=>"auth",
    "msg"=>"The login data is missing. Exiting."
    ));
  exit;
  }
if(strpos($d,",")===false){
  sendData(array(
    "action"=>"auth",
    "msg"=>"The login data is invalid. Exiting."
    ));
  exit;
  }
list($user,$pw) = explode(",",$d);

$fromDB = '$2a$10$4LLeBta770Y0Z7795j.8'.
  'He/ZCQonnvImXIX0egalzE1MuWiEa6PQa';
if(!password_verify($pw,$fromDB)){
  sendData(array(
    "action"=>"auth",
    "msg"=>"The login is bad. Exiting."
    ));
  exit;
  }

include_once("fx_server.auth.inc2.php");
