<?php
class User{
    protected $name;
    protected $phone;
    protected $gender;
    protected $dob;
    protected $ID_No;


    function __construct($phone){
        $this->phone = $phone;
    }
    public function setName($name){
        $this -> name = $name;

    }
    public function setDOB($dob){
        $this -> dob = $dob;

    }
    public function setGender($gender){
        $this -> gender = $gender;

    }
    public function setID($ID_No){
        $this ->ID_No = $ID_No;

    }
    public function getName(){
       return $this ->name;

    }
    public function getDOB(){
        return $this ->dob;
 
     }
     public function getGender(){
        return $this ->gender;
 
     }
    public function getPhone(){
        return $this -> phone;
 
     }
     public function getID(){
        return $this -> ID_No;
 
     }
     public function register($pdo){
        try{
            $stmt = $pdo -> prepare("INSERT INTO users_ussd (name, phone, gender, dob, ID_No) values(?,?,?,?,?)");
            $stmt -> execute([$this->getName(),$this->getPhone(), $this->getGender(), $this->getDOB(), $this->getID()]);
            
        }
        catch(PDOException $e){
            echo $e->getMessage();

        }

     }
     public function isUserRegistered($pdo){
        $stmt = $pdo -> prepare("SELECT * from users_ussd  WHERE phone=?");
        $stmt -> execute([$this->getPhone()]);
        if(count($stmt->fetchAll())>0){
            return true;
        }
        else{
            return false;
        }

     }
     public function readName($pdo){
        $stmt = $pdo -> prepare("SELECT * from users_ussd  WHERE phone=?");
        $stmt -> execute([$this->getPhone()]);
        $row = $stmt->fetch();
        return $row['name'];

     }
     public function readUserId($pdo){
        $stmt = $pdo-> prepare("SELECT uid FROM users_ussd where phone=?");
        $stmt -> execute([$this->getPhone()]);
        $row = $stmt->fetch();
        return $row['uid'];
        
    }
}
?>