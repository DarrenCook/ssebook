<?php
include_once("fx_server.auth.inc1.php");

sendHeaders();

if(!@$_SERVER['REMOTE_USER']){
  sendData(array(
    'action'=>"auth",
    'msg'=>"System problem. Exiting."
    ));
  exit;
  }

include_once("fx_server.auth.inc2.php");
