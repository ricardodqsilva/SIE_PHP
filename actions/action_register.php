<?php
    session_start();                            // Session start to get session variables of current version
    include('../includes/opendb.php');          // Open communication channel between server and database
    include_once("../database/login.php");      // Include of PHP functions libraries related with LOGIN page
    
    // If mandatory registration camps are defined, create a new register entry in database
    if (isset($_POST["reg_completname"], $_POST["reg_username"], $_POST["reg_email"], $_POST["reg_password"])) {
        // Save website visitor informations
        $name  = $_POST["reg_completname"];
        $user  = $_POST["reg_username"];
        $email = $_POST["reg_email"];
        $pass  = md5( $_POST["reg_password"] );

        // Verify if the optional camp ADDRESS was defined
        if(isset($_POST["reg_address"])){
            $address = $_POST["reg_address"];
        }
        else{
            $address = NULL;
        }

        // Verify if username isn't already defined in database
        if((bool)(verifyUsernameNotExist($user)) == FALSE){
            // ERROR TYPE 3 - Username already exists in database
            header('Location: ../pages/login.php?error_register=3');
        }
        else{
            // Add new user to the platform
            $result = registerUser($name,$user,$email,$pass,$address);

            // Verify if the database addition was successfully completed/
            if($result != FALSE) {
                if(isset($_GET['previous_page']))
                    header('Location: ../pages/'.$_GET['previous_page'].'.php');
                else
                    header('Location: ../pages/store.php');
            }
            else {
                // ERROR TYPE 2 - Invalid insertion into database
                header('Location: ../pages/login.php?error_register=2');
            }
        }
    }
    else{
        // ERROR TYPE 1 - Mandatory camps aren't all defined
        header('Location: ../pages/login.php?error_register=1');
    }

?>