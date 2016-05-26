<?php

use Drips\App;

if(class_exists('Drips\App')){
	App::on("create", function(App $app){
		$app->debugger = new Debugger;
	});
}
