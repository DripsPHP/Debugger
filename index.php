<?php

require_once __DIR__."/vendor/autoload.php";

use Drips\Debugger\Debugger;
use Drips\Debugger\Handler;

$debugger = Debugger::getInstance();

// var_dump vs dump
//var_dump($_SERVER);
//dump($_SERVER);
//die();

echo "Test";
echo ASDF;

// eigene Fehlerbehandlung
/*
Handler::on("Exception", function(){
    echo "Es ist ein Fehler aufgetreten";
    return true;
});
*/

throw new Exception("This is an exception!");
