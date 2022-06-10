<?php
include_once 'util.php';
class Menu{
    protected $text;
    protected $sessionId;

    function __construct($text, $sessionId){
        $this->text = $text;
        $this->sessionId = $sessionId;
    }
    public function mainMenuRegistered(){
        $response = "CON Hi😊 Welcome to our hospital booking system.\n";
        $response .= "1. Enter 1 to continue \n";
        echo $response;

    }
    public function mainMenuUnRegistered(){
        $response = "CON Hi😊 Welcome to our hospital booking system. Reply with\n";
        $response .= "1. Register\n";
        echo $response;

    }
    public function registerMenu($textArray){
        $level = count($textArray);
        if($level == 1){
            echo "CON Please enter your full names:";
        }
       else if($level == 2){
            echo "CON Please enter your date of birth. Use DD/MM/YY format, e.g. 24/07/2002";
        }
       else if($level == 3){
            $response = "CON Please enter your gender:\n ";
            $response .= "1. Male\n";
            $response .= "2. Female\n";
            echo $response;

        }
       else if($level == 4){
          echo "CON Please enter your ID number:\n ";
           

        }
        else if($level ==5){
            $name = $textArray[1];
            $dob = $textArray[2];
            $gender = $textArray[3];
           echo "END Registration successful✅ You can now proceed.";
        }
       
    }
    public function bookAppointment($textArray){
        $level = count($textArray);
        if($level == 1){
            echo "CON Please enter your preferred date of appointment. Use DD/MM/YY format, e.g. 24/07/2002";
        }
       else if($level == 2){
            echo "CON Please enter your preferred time of appointment.";
        }
       else if($level == 3){
          $response = "CON Please enter your primary reason for appointment.\n ";
          echo $response;

        }
       else if($level == 4){
            $response = "CON Do you have a specific doctor you want to see?\n ";
            $response .= "1. Yes\n";
            $response .= "2. No\n";
            echo $response;

        }
       else if($level == 5 && $textArray[4] = 1 ){
            
            
                echo "CON Please enter the name of the doctor. If none, specify none\n";
        }
          
      
       else if($level == 6){
            echo "CON Please enter your preferred method of payment:\n";
           
        }
       
     
       else if($level == 7){
            $response = "CON You are about to book an appointment on " . $textArray[1] .  " at " . $textArray[2] . " with " . $textArray[5] .". Please confirm your appointment.\n";
            $response .= "1. Confirm\n";
            $response .= "2. Cancel\n";
            $response .= Util::$GO_BACK . " Back\n";
            $response .= Util::$GO_TO_MAIN_MENU . " Main Menu\n";
            echo $response;


           
        }
       else if($level == 8 && $textArray[7] = 1 ){

            echo "END Your appointment has been received. You will receive a confirmation from us concerning the status of your appointment soon.";
           
       }
       else if($level == 8 && $textArray[7] = 2 ){
            echo "END Thank you for using our services";

        

        }
       else if($level == 8 && $textArray[7] = Util::$GO_BACK ){
            echo "END You have requested to go one step back - NHIF ";

        }
       else if($level == 8 && $textArray[7] = Util::$GO_TO_MAIN_MENU){
            echo "END You have requested to go back to the main menu ";

        }
        else{
            echo "END Invalid entry!";
        }
   
}
}
?>