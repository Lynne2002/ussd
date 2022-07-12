<?php
class Appointment{
    protected $date;
    protected $time;
    protected $doctor;
    protected $appointment_reason;
    protected $doctor_name;
    protected $payment;
    protected $phone;


    function __construct($phone){
        $this->phone = $phone;
    }
    public function setDate($date){
        $this -> date = $date;

    }
    public function setTime($time){
        $this -> time = $time;

    }
    public function setDoc($doctor){
        $this -> doctor = $doctor;

    }
    public function setDocName($doctor_name){
        $this ->doctor_name = $doctor_name;

    }
    public function setPay($payment){
        $this -> payment = $payment;

    }
    public function setApp($appointment_reason){
        $this -> appointment_reason = $appointment_reason;
    }


    public function getDate(){
       return $this ->date;

    }
    public function getTime(){
        return $this ->time;
 
     }
     public function getDoc(){
        return $this ->doctor;
 
     }
    public function getPhone(){
        return $this -> phone;
 
     }
     public function getDocName(){
        return $this -> doctor_name;
 
     }
     public function getPay(){
        return $this ->payment;
 
     }
     public function getApp(){
        return $this ->appointment_reason;
 
     }
     public function book($pdo, $user){
        try{
            $stmt = $pdo -> prepare("INSERT INTO ussd_booking (date, time, doctor, doctor_name, payment, appointment_reason, uid) values(?,?,?,?,?, ?,?)");
            $stmt -> execute([$this->getDate(),$this->gettime(), $this->getDoc(),$this->getDocName(), $this->getPay(), $this->getApp(), $user->readUserId($pdo)]);
            
        }
        catch(PDOException $e){
            echo $e->getMessage();

        }

     }
    
}
?>