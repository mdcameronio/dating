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
require ('model/data-layer.php');
require ('model/data-Validation.php');
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

    //initialize input varibles
    $fname="";
    $lname="";
    $age="";
    $phone="";

//if form has been posted
    if($_SERVER['REQUEST_METHOD']=='POST') {
       $_SESSION['gen'] = $_POST['gen'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $age = $_POST['age'];
        $phone = $_POST['phone'];

        if (validateName($fname)) {
            $_SESSION['fname'] = $_POST['fname'];
        } else {
            //set error
            $f3->set('errors["fname"]', 'Please enter a valid name');
        }
        if (validateName($lname)) {
            $_SESSION['lname'] = $_POST['lname'];
        } else {
            //set error
            $f3->set('errors["lname"]', 'Please enter a valid name');
        }
        if (validateAge($age)){
            $_SESSION['age']=$_POST['age'];
        }else{
            $f3->set('errors["age"]','Please enter a valid age');
        }
        if (validPhone($phone)){
            $_SESSION['phone']=$_POST['phone'];
        }else{
            $f3->set('errors["phone"]','Please enter a valid phone 000-000-0000');
        }

        //if form valid reroute to next page
        if (empty($f3->get('errors'))) {
            $f3->reroute('profile');
        }
    }

    //stiky varibles f3 hive
    $f3->set('fname',$fname);
    $f3->set('lname',$lname);
    $f3->set('age',$age);
    $f3->set('phone',$phone);

    //if form invalid repost page with errors
    $view = new Template();
    echo $view->render('views/personal.html');

});

//profile route
$f3->route('GET|POST /profile' ,function ($f3) {
    //echo "<h1>hello world</h1>";

    $email="";



    if($_SERVER['REQUEST_METHOD']=='POST'){

        $_SESSION['state']=$_POST['state'];
        $_SESSION['seek']=$_POST['seek'];
        $_SESSION['bio']=$_POST['bio'];

        if(validEmail($_POST['email'])){
            $_SESSION['email']=$_POST['email'];
        }else{
            $f3->set('errors["email"]','Please enter a valid email');
        }
        //redirect user to next page
        if (empty($f3->get('errors'))) {
            $f3->reroute('intrest');
        }
//        $f3->reroute('intrest');
    }

    $f3->set('email',$email);
    $view = new Template();
    echo $view->render('views/profile.html');

});

//intrest route
$f3->route('GET|POST /intrest' ,function ($f3) {
    //echo "<h1>hello world</h1>";

    //get indoor interest
    $f3->set('indoor',getIndoor());
    $f3->set('outdoor',getOutdoor());
    //if form has been posted
    if($_SERVER['REQUEST_METHOD']=='POST'){

        //add data to session verible
        if(isset($_POST['indoor'])){

            $indoor=$_POST['indoor'];

            if(validIndoor($indoor)){
                $indoor = implode(", ", $_POST['indoor']);
            }else{
                $f3->set('errors["indoor"]','invalid selection');
            }
        }
        else{
            $_SESSION['indoor']='none selected';
        }

        if(isset($_POST['outdoor'])){
//            $_SESSION['outdoor']= implode(", ", $_POST['outdoor']);
            $outdoor = $_POST['outdoor'];
            if(validOutdoor($outdoor)){
                $outdoor =implode(", ", $_POST['outdoor']);
            }else{
                $f3->set('errors["outdoor"]','invalid selection');
            }
        }
        else{
            $_SESSION['outdoor']='none selected';
        }
        //redirect user to next page
        if (empty($f3->get('errors'))) {
            $_SESSION['indoor'] = $indoor;
            $_SESSION['outdoor']=$outdoor;
            $f3->reroute('summary');
        }
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
