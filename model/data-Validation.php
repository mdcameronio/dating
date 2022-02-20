<?php

//validate name
//checks to see that a string is all alphabetic
function validateName($name){

    $name = test_input($name);

return ctype_alpha($name);
}

//validate age
//checks to see that an age is numeric and
//between 18 and 118
function validateAge($age){
    $age = test_input($age);
    if(is_numeric($age)&& $age>18 && $age <=118){
        return true;
    }else{
        return false;
    }
}

//validate phone nuber
//checks to see that a phone number is valid
//(you can decide what constitutes a “valid” phone number)
function validPhone($phone){
    $phone = test_input($phone);
    return preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phone);
}


//valid Email ()
//checks to see that an email address is valid
function validEmail($email){
    $email=test_input($email);
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

//validOutdoor()
//checks each selected outdoor interest against a list of valid options
function validOutdoor($userout){
    $outdoor = getOutdoor();
    foreach ($userout as $selection){
        if(!in_array($selection,$outdoor)){
            return false;
        }
    }
    return true;
}

//validIndoor()
//checks each selected indoor interest against a list of valid options
function validIndoor($userin){
    $indoor = getIndoor();

    foreach ($userin as $selection){
        if(!in_array($selection,$indoor)){
            return false;
        }
    }
    return true;
}

//test input
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
