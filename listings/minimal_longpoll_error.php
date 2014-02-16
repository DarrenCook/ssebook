<?php
usleep(2500000); //2.5s
$cat = (rand(1,2) == 1) ? "dead" : "alive";
if($cat == "dead"){
    header("HTTP/1.0 404 Not Found");
    echo "Something bad happened. Sorry.";
    }else{
    header("Content-Type: text/plain");
    echo date("Y-m-d H:i:s")."\n";
    }
