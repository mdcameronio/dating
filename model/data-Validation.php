<?php


class Validator
{
//validate name
//checks to see that a string is all alphabetic
   static function validateName($name)
    {

        $name = self::test_input($name);

        return ctype_alpha($name);
    }

//validate age
//checks to see that an age is numeric and
//between 18 and 118
    static function validateAge($age)
    {
        $age = self::test_input($age);
        if (is_numeric($age) && $age > 18 && $age <= 118) {
            return true;
        } else {
            return false;
        }
    }

//validate phone nuber
//checks to see that a phone number is valid
//(you can decide what constitutes a “valid” phone number)
    static function validPhone($phone)
    {
        $phone = self::test_input($phone);
        return preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phone);
    }


//valid Email ()
//checks to see that an email address is valid
    static function validateEmail($email)
    {
        $email = self::test_input($email);
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

//validOutdoor()
//checks each selected outdoor interest against a list of valid options
    static function validOutdoor($userout)
    {
        $outdoor = DataLayer::getOutdoor();
        foreach ($userout as $selection) {
            if (!in_array($selection, $outdoor)) {
                return false;
            }
        }
        return true;
    }

//validIndoor()
//checks each selected indoor interest against a list of valid options
    static function validIndoor($userin)
    {
        $indoor = DataLayer::getIndoor();

        foreach ($userin as $selection) {
            if (!in_array($selection, $indoor)) {
                return false;
            }
        }
        return true;
    }

//test input
    static function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}