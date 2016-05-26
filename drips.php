<?php

use Drips\App;
use Drips\Debugger\Debugger;

if(class_exists('Drips\App')){
	App::on("create", function(App $app){
		$app->debugger = new Debugger;
	});
}
