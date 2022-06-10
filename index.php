<?php
// https://0d12-154-70-20-112.eu.ngrok.io/ussdsms/index.php
include_once 'menu.php';

        // Read the variables sent via POST from our API
        $sessionId   = $_POST["sessionId"];
        $serviceCode = $_POST["serviceCode"];
        $phoneNumber = $_POST["phoneNumber"];
        $text        = $_POST["text"];


        $isRegistered = false;
        $menu = new Menu($text, $sessionId);

        if ($text == "" && !$isRegistered) {
            // User is registered and the string is empty
            $menu->mainMenuRegistered();
            

        } else if ($text == "" && $isRegistered ) {
            // User is unregistered and string is empty
           $menu->mainMenuUnRegistered();

        } else if ($isRegistered) {
            // User is unregistered and string is not empty
            $textArray =explode("*", $text);
            switch($textArray[0]){
                case 1:
                    $menu->registerMenu($textArray);
                break;
                default:
                     echo "END Invalid choice. Please try again.";

            }
           

        } else { 
            // User is registered and string is not empty
            $textArray =explode("*", $text);
            switch($textArray[0]){
                case 1:
                    $menu->bookAppointment($textArray);
                    break;
                 default:
                 echo "END Invalid choice. Please try again.";
           
        }
    }
?>
      




