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

//require autoload file
require_once ('vendor/autoload.php');

//start session
session_start();

//var_dump($_SESSION);

//Create an instance of the Base class
$f3 = Base::instance();
$con = new Controller($f3);
$dataLayer = new DataLayer();


//$result = $dataLayer->getMember();
//var_dump($result);
//$test = new Member();
//
//$test->setFname("bary");
//$test->setLname("hary");
//$test->setAge(22);
//$test->setBio("long walks on the beach");
//$test->setGender("male");
//$test->setEmail("hip@home.com");
//$test->setPremium(1);
//$test->setPhone(222-2222);
//$test->setSeeking("female");
//$test->setState("wa");
//
//$dataLayer->saveMember($test);

//create instance of the base class
$f3 = Base::instance();


//define a default root
$f3->route('GET /' ,function () {

    $GLOBALS['con']->home();

});

//personal route
$f3->route('GET|POST /personal' ,function ($f3) {

  $GLOBALS['con']->personal();

});

//profile route
$f3->route('GET|POST /profile' ,function ($f3) {

  $GLOBALS['con']->profile();

});

//intrest route
$f3->route('GET|POST /intrest' ,function ($f3) {

   $GLOBALS['con']->intrest();

});

//route for summary
$f3->route('GET /summary' ,function () {

   $GLOBALS['con']->summary();
});

$f3->route('GET /admin' ,function () {

    $GLOBALS['con']->admin();
});

//run fat free
$f3->run();

//ob flush
ob_flush();
