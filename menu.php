<?php
include_once 'util.php';
include_once 'user.php';
include_once 'util.php';
include_once 'appointment.php';
class Menu{
    protected $text;
    protected $sessionId;

    function __construct(){}
    
    public function mainMenuRegistered($name){
        $response = "Hi ". $name . " 😊 Welcome to our hospital booking system.\n";
        $response .= "1. Enter 1 to continue \n";
        return $response;

    }
    public function mainMenuUnRegistered(){
        $response = "CON  Hi😊 Welcome to our hospital booking system. Reply with\n";
        $response .= "1. Register\n";
        echo $response;

    }
    public function registerMenu($textArray, $phoneNumber, $pdo){
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
            $ID_No = $textArray[4];
            $user = new User($phoneNumber);
            $user -> setName($name);
            $user -> setGender($gender);
            $user -> setID($ID_No);
            $user -> setDOB($dob);
            $user->register($pdo);
           echo "END Registration successful✅ You can now proceed to book an appointment";
        }
       
    }
    public function bookAppointment($textArray,  $phoneNumber, $pdo){
        $level = count($textArray);
        $response ="";
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
        $date = $textArray[1];
        $time = $textArray[2];
        $appointment_reason = $textArray[3];
        $doctor = $textArray[4];
        $doctor_name = $textArray[5];
        $payment = $textArray[6];
        $user = new User($phoneNumber);
        $appointment = new Appointment($phoneNumber);
        $appointment -> setDate($date);
        $appointment-> setTime($time);
        $appointment -> setApp($appointment_reason);
        $appointment -> setDoc($doctor);
        $appointment -> setDocName($doctor_name);
        $appointment -> setPay($payment);
        $appointment->book($pdo, $user);

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
public function middleware($text, $user, $sessionId, $pdo){
    //Remove entries for going back and going to the main menu
    
    return $this->invalidEntry($this->goBack($this->goToMainMenu($text)), $user, $sessionId, $pdo);
}
public function goBack($text){
    $explodedText = explode("*", $text);
    while(array_search(Util::$GO_BACK, $explodedText) != false){
        $firstIndex = array_search(Util::$GO_BACK, $explodedText);
        array_splice($explodedText, $firstIndex-1, 2);

   
    }
    return join("*",$explodedText);


}
public function goToMainMenu($text){
    $explodedText = explode("*", $text);
    while(array_search(Util::$GO_TO_MAIN_MENU, $explodedText) != false){
        $firstIndex = array_search(Util::$GO_TO_MAIN_MENU, $explodedText);
        $explodedText =array_slice($explodedText, $firstIndex + 1);


    }
    return join("*",$explodedText);

}
public function persistInvalidEntry($sessionId, $user, $ussdLevel, $pdo){

    $stmt = $pdo->prepare("INSERT INTO ussdsession (sessionID, uid, ussdLevel) values (?,?,?)");
    $stmt -> execute($sessionId, $user->readUserId($pdo), $ussdLevel);
    $stmt= null;
}
public function invalidEntry($ussdStr, $user, $sessionId, $pdo){
    $stmt = $pdo->prepare("SELECT ussdLevel from ussdsession WHERE sessionId=?");
    $stmt -> execute([$sessionId]);
    $result = $stmt->fetchAll();

    if(count($result)==0){
        return $ussdStr;
    }
    $strArray = explode("*", $ussdStr);
    foreach($result as $value){
        unset($strArray[$value['ussdLevel']]);

    }
    $strArray = array_values($strArray);
    return join("*", $strArray);

}
}
?>