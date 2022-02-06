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

//start session
session_start();

//var_dump($_SESSION);

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

//personal route
$f3->route('GET|POST /personal' ,function ($f3) {
    //echo "<h1>hello world</h1>";
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $_SESSION['fname']=$_POST['fname'];
        $_SESSION['lname']=$_POST['lname'];
        $_SESSION['age']=$_POST['age'];
        $_SESSION['gen']=$_POST['gen'];
        $_SESSION['phone']=$_POST['phone'];
        //redirect user to next page
        $f3->reroute('profile');
    }
    $view = new Template();
    echo $view->render('views/personal.html');

});
//profile route
$f3->route('GET|POST /profile' ,function ($f3) {
    //echo "<h1>hello world</h1>";

    if($_SERVER['REQUEST_METHOD']=='POST'){
        $_SESSION['email']=$_POST['email'];
        $_SESSION['state']=$_POST['state'];
        $_SESSION['seek']=$_POST['seek'];
        $_SESSION['bio']=$_POST['bio'];

        //redirect user to next page
        $f3->reroute('intrest');
    }

    $view = new Template();
    echo $view->render('views/profile.html');

});
//intrest route
$f3->route('GET|POST /intrest' ,function ($f3) {
    //echo "<h1>hello world</h1>";

    if($_SERVER['REQUEST_METHOD']=='POST'){

        //add data to session verible
        if(isset($_POST['indoor'])){
            $_SESSION['indoor']= implode(", ", $_POST['indoor']);
        }
        else{
            $_SESSION['indoor']='none selected';
        }

        if(isset($_POST['outdoor'])){
            $_SESSION['outdoor']= implode(", ", $_POST['outdoor']);
        }
        else{
            $_SESSION['outdoor']='none selected';
        }

        //redirect user to next page
        $f3->reroute('summary');
    }

    $view = new Template();
    echo $view->render('views/intrest.html');

});

//route for summary
$f3->route('GET /summary' ,function () {
    //echo "<h1>hello world</h1>";

    $view = new Template();
    echo $view->render('views/summary.html');
    //clear session data
    session_destroy();
});

//run fat free
$f3->run();

//ob flush
ob_flush();
