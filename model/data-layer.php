<?php

/**
 *accses datalayer needed for dating app
 */
require_once $_SERVER['DOCUMENT_ROOT'].'/../pet-shop-config.php';

class DataLayer
{

    //feild for data connection object
    private $_dbh;

    //default construtor
    function __construct()
    {
        try {
            //Instantiate a PDO database object
            $this->_dbh = new PDO (DB_DSN, DB_USERNAME, DB_PASSWORD);

        }
        catch (PDOException $e) {
            echo "Error connecting to DB ".$e->getMessage();
        }
    }

    function saveMember($member)
    {

//         1 defione query
        $sql = "INSERT INTO member (FName,LName,age,gender,phone,email,state,seeking,bio,premium,interest)
                            VALUES (:FName,:LName,:age,:gender,:phone,:email,:state,:seeking,:bio,:premium,:interest)" ;

//        2 prepair statment
        $statement = $this->_dbh->prepare($sql);

        $interest="none";

        if(isset($_SESSION['pmember']))
        {

            $ininterest = $member->getInDoorInterests();
            $ininterest = implode(", ", $ininterest);
            $outinterset = $member->getOutDoorInterests();
            $outinterset = implode(", ", $outinterset);
            $interest = $ininterest.",".$outinterset;
        }



//        3 bind parameters
        $statement->bindParam(':FName',$member->getFname());
        $statement->bindParam(':LName',$member->getLname());
        $statement->bindParam(':age',$member->getAge());
        $statement->bindParam(':gender',$member->getGender());
        $statement->bindParam(':phone',$member->getPhone());
        $statement->bindParam(':email',$member->getEmail());
        $statement->bindParam(':state',$member->getState());
        $statement->bindParam(':seeking',$member->getSeeking());
        $statement->bindParam(':bio',$member->getBio());
        $statement->bindParam(':premium',$member->getPremium());
        $statement->bindParam(':interest',$interest);


//        4 execute the statment
        $statement->execute();


    }

    function getMember()
    {
        //1. Define the query
        $sql = "SELECT * FROM member";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters

        //4. Execute the query
        $statement->execute();

        //5. Process the results (get the primary key)
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }



    /**
     * @return string[]
     */
    static function getIndoor()
    {
        return array('tv', 'puzzles', 'movies', 'reading', 'cooking', 'playing cards', 'board games', 'video games');
    }

    /**
     * @return string[]
     */
    static function getOutdoor()
    {
        return array('hiking', 'walking', 'biking', 'climbing', 'swimming', 'collecting');
    }
}
