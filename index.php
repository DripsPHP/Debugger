<?php

require_once __DIR__ . "/vendor/autoload.php";

use Drips\Debugger\Debugger;

$debugger = Debugger::getInstance();
$debugger->enableErrors();
$debugger->enable();

// var_dump vs dump
//var_dump($_SERVER);
//dump($_SERVER);
//die();
echo dump($debugger);

echo "Test";

// eigene Fehlerbehandlung
/*
Handler::on("Exception", function(){
    echo "Es ist ein Fehler aufgetreten";
    return true;
});
*/


//throw new Exception("This is an exception!");
