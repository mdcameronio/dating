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
        session_destroy();
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
            $gen = $_POST['gen'];
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $age = $_POST['age'];
            $phone = $_POST['phone'];

            if(isset($_POST['premium'])){
                $pmember = new PremiumMember();
                $_SESSION['pmember'] = $pmember;
                $_SESSION['pmember']->setGender($gen);
                if (Validator::validateName($fname)) {
                    $_SESSION['pmember']->setFname($fname)  ;
                } else {
                    //set error
                    $this->_f3->set('errors["fname"]', 'Please enter a valid name');
                }
                if (Validator::validateName($lname)) {
                    $_SESSION['pmember']->setLname($lname)  ;
                } else {
                    //set error
                    $this->_f3->set('errors["lname"]', 'Please enter a valid name');
                }
                if (Validator::validateAge($age)){
                    $_SESSION['pmember']->setAge($age)  ;
                }else{
                    $this->_f3->set('errors["age"]','Please enter a valid age');
                }
                if (Validator::validPhone($phone)){
                    $_SESSION['pmember']->setPhone($phone)  ;
                }else{
                    $this->_f3->set('errors["phone"]','Please enter a valid phone 000-000-0000');
                }
                if (empty($this->_f3->get('errors'))) {
                    $_SESSION['pmember']->setPremium(1);
                    $this->_f3->reroute('profile');
                }
            }else {
                $member = new Member();

                $_SESSION['member'] = $member;
                $_SESSION['member']->setGender($gen);
                if (Validator::validateName($fname)) {
                    $_SESSION['member']->setFname($fname);
                } else {
                    //set error
                    $this->_f3->set('errors["fname"]', 'Please enter a valid name');
                }
                if (Validator::validateName($lname)) {
                    $_SESSION['member']->setLname($lname);
                } else {
                    //set error
                    $this->_f3->set('errors["lname"]', 'Please enter a valid name');
                }
                if (Validator::validateAge($age)) {
                    $_SESSION['member']->setAge($age);
                } else {
                    $this->_f3->set('errors["age"]', 'Please enter a valid age');
                }
                if (Validator::validPhone($phone)) {
                    $_SESSION['member']->setPhone($phone);
                } else {
                    $this->_f3->set('errors["phone"]', 'Please enter a valid phone 000-000-0000');
                }
            }

            //if form valid reroute to next page
            if (empty($this->_f3->get('errors'))) {
                $_SESSION['member']->setPremium(0);
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

           $state=$_POST['state'];
            $seek=$_POST['seek'];
            $bio=$_POST['bio'];
            $email=$_POST['email'];

            if(Validator::validateEmail($_POST['email'])){
                $_SESSION['email']=$email;

            }else{
                $this->_f3->set('errors["email"]','Please enter a valid email');
            }
            //redirect user to next page
            if (empty($this->_f3->get('errors'))&&isset($_SESSION['pmember'])) {
                $_SESSION['pmember']->setEmail($_SESSION['email']);
                $_SESSION['pmember']->setState($state);
                $_SESSION['pmember']->setSeeking($seek);
                $_SESSION['pmember']->setBio($bio);
                $this->_f3->reroute('intrest');
            }
            if(empty($this->_f3->get('errors'))){

                $_SESSION['member']->setEmail($_SESSION['email']);
                $_SESSION['member']->setState($state);
                $_SESSION['member']->setSeeking($seek);
                $_SESSION['member']->setBio($bio);
                $this->_f3->reroute('summary');
            }

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

                    $_SESSION['pmember']->setInDoorInterests($indoor);
                }else{
                    $this->_f3->set('errors["indoor"]','invalid selection');
                }
            }
            else{

                $_SESSION['pmember']->setIndoor("none selected");
            }

            if(isset($_POST['outdoor'])){

                $outdoor = $_POST['outdoor'];
                if(Validator::validOutdoor($outdoor)){
                    $_SESSION['pmember']->setOutDoorInterests($outdoor);

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

//        echo "here";
        if(isset($_SESSION['pmember']))
        {
            global $dataLayer;
            $mem = $_SESSION['pmember'];
            var_dump($mem);
            $dataLayer->saveMember($mem);

            echo"wtf mate";
        }else
        {
            global $dataLayer;
            $dataLayer->saveMember($_SESSION['member']);
            echo"wtf reg";
//            $GLOBALS['dataLayer']->saveMember($_SESSION['member']);
        }

        $view = new Template();
        echo $view->render('views/summary.html');
        //clear session data
//        session_destroy();
    }

    function admin()
    {
        //Get the data from the model
        global $dataLayer;
       $order= $dataLayer->getMember();
       $this->_f3->set('orders',$order);
//        $GLOBALS['dataLayer']->getMembers();
//        $this->_f3->set('orders', $orders);

        //Display the view page
        $view = new Template();
        echo $view->render('views/admin.html');
    }

}
