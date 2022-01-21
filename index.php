<?php
//author Mat Cameron
//date 1/21/22
//
// this is my controler

// turnon error reporting
ini_set('display_errors',1);
error_reporting(E_ALL);


//require autoload file
require_once ('vendor/autoload.php');

//create instance of the base class
$f3 = Base::instance();


//define a default root
$f3->route('GET /' ,function () {
    //echo "<h1>hello world</h1>";

    $view = new Template();
    echo $view->render('views/home.html');

});


//run fat free
$f3->run();
