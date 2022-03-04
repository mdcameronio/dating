<?php

//  328/my-diner/controller/controller.php

class Controller
{
    private $_f3; //F3 object

    function __construct($f3)
    {
        $this->_f3 = $f3;
    }
    //define default route
    function home()
    {
        $view = new Template();
        echo $view->render('views/home.html');
    }

    function personal()
    {
        //initialize input varibles
        $fname="";
        $lname="";
        $age="";
        $phone="";

//if form has been posted
        if($_SERVER['REQUEST_METHOD']=='POST') {
            //get data
            $_SESSION['gen'] = $_POST['gen'];
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $age = $_POST['age'];
            $phone = $_POST['phone'];

            //instatiate a member object
            $member = new Member();
            $_SESSION['member'] = $member;
            //or could use
            //$_SESSION['member'] = new Member();

            if (Validator::validateName($fname)) {
                $_SESSION['member']->setFname($fname)  ;
            } else {
                //set error
                $this->_f3->set('errors["fname"]', 'Please enter a valid name');
            }
            if (Validator::validateName($lname)) {
                $_SESSION['member']->setLname($lname)  ;
            } else {
                //set error
                $this->_f3->set('errors["lname"]', 'Please enter a valid name');
            }
            if (Validator::validateAge($age)){
                $_SESSION['member']->setAge($age)  ;
            }else{
                $this->_f3->set('errors["age"]','Please enter a valid age');
            }
            if (Validator::validPhone($phone)){
                $_SESSION['member']->setPhone($phone)  ;
            }else{
                $this->_f3->set('errors["phone"]','Please enter a valid phone 000-000-0000');
            }

            //if form valid reroute to next page
            if (empty($this->_f3->get('errors'))) {
                $this->_f3->reroute('profile');
            }
        }

        //stiky varibles f3 hive
        $this->_f3->set('fname',$fname);
        $this->_f3->set('lname',$lname);
        $this->_f3->set('age',$age);
        $this->_f3->set('phone',$phone);

        //if form invalid repost page with errors
        $view = new Template();
        echo $view->render('views/personal.html');
    }

    function profile()
    {
        $email="";



        if($_SERVER['REQUEST_METHOD']=='POST'){

            $_SESSION['state']=$_POST['state'];
            $_SESSION['seek']=$_POST['seek'];
            $_SESSION['bio']=$_POST['bio'];
            $_SESSION['email']=$_POST['email'];
            if(Validator::validateEmail($_POST['email'])){
                $_SESSION['email']=$_POST['email'];
            }else{
                $this->_f3->set('errors["email"]','Please enter a valid email');
            }
            //redirect user to next page
            if (empty($this->_f3->get('errors'))) {
                $this->_f3->reroute('intrest');
            }
//        $f3->reroute('intrest');
        }

        $this->_f3->set('email',$email);
        $view = new Template();
        echo $view->render('views/profile.html');
    }

    function intrest()
    {
        //get indoor interest
        $this->_f3->set('indoor',DataLayer::getIndoor());
        $this->_f3->set('outdoor',DataLayer::getOutdoor());
        //if form has been posted
        if($_SERVER['REQUEST_METHOD']=='POST'){

            //add data to session verible
            if(isset($_POST['indoor'])){

                $indoor=$_POST['indoor'];

                if(Validator::validIndoor($indoor)){
                    $indoor = implode(", ", $_POST['indoor']);
                }else{
                    $this->_f3->set('errors["indoor"]','invalid selection');
                }
            }
            else{
                $_SESSION['indoor']='none selected';
            }

            if(isset($_POST['outdoor'])){
//            $_SESSION['outdoor']= implode(", ", $_POST['outdoor']);
                $outdoor = $_POST['outdoor'];
                if(Validator::validOutdoor($outdoor)){
                    $outdoor =implode(", ", $_POST['outdoor']);
                }else{
                    $this->_f3->set('errors["outdoor"]','invalid selection');
                }
            }
            else{
                $_SESSION['outdoor']='none selected';
            }
            //redirect user to next page
            if (empty($this->_f3->get('errors'))) {
                $_SESSION['indoor'] = $indoor;
                $_SESSION['outdoor']=$outdoor;
                $this->_f3->reroute('summary');
            }
        }

        $view = new Template();
        echo $view->render('views/intrest.html');
    }

    function summary()
    {
        $view = new Template();
        echo $view->render('views/summary.html');
        //clear session data
        session_destroy();
    }

}
