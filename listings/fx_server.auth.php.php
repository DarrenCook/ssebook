<?php
include_once("fx_server.auth.inc1.php");

$user = @$_SERVER["PHP_AUTH_USER"];
$pw = @$_SERVER["PHP_AUTH_PW"];

$fromDB = '$2a$10$4LLeBta770Y0Z7795j.8'.
  'He/ZCQonnvImXIX0egalzE1MuWiEa6PQa';
if(!password_verify($pw, $fromDB)){
  header('WWW-Authenticate: Basic realm="SSE Book"');
  header("HTTP/1.0 401 Unauthorized");
  echo "Please authenticate.\n";
  exit;
  }

sendHeaders();

include_once("fx_server.auth.inc2.php");
