<?php
// https://0d12-154-70-20-112.eu.ngrok.io/ussdsms/index.php
include_once 'menu.php';
include_once 'db.php';
include_once 'user.php';

        // Read the variables sent via POST from our API
        $sessionId   = $_POST["sessionId"];
        $serviceCode = $_POST["serviceCode"];
        $phoneNumber = $_POST["phoneNumber"];
        $text        = $_POST["text"];


        //$isRegistered = false;
        $user = new User($phoneNumber);
        $db = new DBConnector();
        $pdo = $db->connectToDB();

        //create object for the menu class
        $menu = new Menu();
        $text = $menu->middleware($text, $user, $sessionId, $pdo);

        if ($text == "" && $user->isUserRegistered($pdo)==true){
            // User is registered and the string is empty
            echo "CON " . $menu->mainMenuRegistered($user->readName($pdo));
            

        } else if ($text == "" && $user->isUserRegistered($pdo)==false ) {
            // User is unregistered and string is empty
           $menu->mainMenuUnRegistered();

        } else if ($user->isUserRegistered($pdo)== false) {
            // User is unregistered and string is not empty
            $textArray =explode("*", $text);
            switch($textArray[0]){
                case 1:
                    $menu->registerMenu($textArray, $phoneNumber, $pdo);
                break;
                default:
                     echo "END Invalid choice. Please try again.";

            }
           

        } else { 
            // User is registered and string is not empty
            $textArray =explode("*", $text);
            switch($textArray[0]){
                case 1:
                    $menu->bookAppointment($textArray,  $phoneNumber, $pdo);
                    break;
                 default:
                 $ussdLevel = count($textArray) - 1;
                 $menu -> persistInvalidEntry($sessionId, $user, $ussdLevel, $pdo);
                 echo "CON Invalid choice\n" . $menu->mainMenuUnRegistered($user->readName($pdo));
           
        }
    }
?>
      




