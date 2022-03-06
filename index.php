<?php
//author Mat Cameron
//date 1/21/22
//
// this is my controler

//turn on buffering
ob_start();

// turnon error reporting
ini_set('display_errors',1);
error_reporting(E_ALL);

require_once ('vendor/autoload.php');
//require ('model/data-layer.php');
//require ('model/data-Validation.php');
//start session
session_start();

//var_dump($_SESSION);

//Create an instance of the Base class
$f3 = Base::instance();
$con = new Controller($f3);
//$dataLayer = new DataLayer();



//require autoload file


//create instance of the base class
$f3 = Base::instance();


//define a default root
$f3->route('GET /' ,function () {
    //echo "<h1>hello world</h1>";

    $GLOBALS['con']->home();

//    $view = new Template();
//    echo $view->render('views/home.html');

});

//personal route
$f3->route('GET|POST /personal' ,function ($f3) {
    //echo "<h1>hello world</h1>";

  $GLOBALS['con']->personal();

});

//profile route
$f3->route('GET|POST /profile' ,function ($f3) {
    //echo "<h1>hello world</h1>";

  $GLOBALS['con']->profile();

});

//intrest route
$f3->route('GET|POST /intrest' ,function ($f3) {
    //echo "<h1>hello world</h1>";

   $GLOBALS['con']->intrest();

});

//route for summary
$f3->route('GET /summary' ,function () {
    //echo "<h1>hello world</h1>";

   $GLOBALS['con']->summary();
});

//run fat free
$f3->run();

//ob flush
ob_flush();
