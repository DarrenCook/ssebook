<?php
header("Content-Type: text/plain");
for($n=0;;++$n){
    sleep(2);
    if($n>=5){
        echo date("Y-m-d H:i:s")."\n";
        break;
        }
    echo "(keep-alive)".date("Y-m-d H:i:s")."\n";
    @ob_flush();@flush();
    }
