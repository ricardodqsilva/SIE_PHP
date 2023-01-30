<?php
    session_save_path('C:\data');
    session_start();                            // Session start to get session variables of current version
    include('../includes/opendb.php');          // Open communication channel between server and database
    include_once("../database/store.php");      // Include of PHP functions libraries related with LOGIN page
    
    // If mandatory registration camps are defined, create a new register entry in database
    if (isset($_POST["add_quantity"], $_POST["add_productprice"], $_POST["add_idproduct"], $_POST["add_productname"], $_POST["add_brand"], $_POST["add_producttype"], $_POST["add_picture"])) {
        // Save website visitor informations
        $idproduct = $_POST["add_idproduct"];
        $name  = $_POST["add_productname"];
        $price = $_POST["add_productprice"];
        $brand  = $_POST["add_brand"];
        $type = $_POST["add_producttype"];
        $picture  = $_POST["add_picture"];
        $quantity = $_POST["add_quantity"];

        // Verify if the optional camp ADDRESS was defined
        if(isset($_POST["add_description"])){
            $description = $_POST["add_description"];
        }
        else{
            $address = NULL;
        }


        $result = registerProduct($idproduct, $name, $price, $description, $brand, $type, $picture, $quantity);
        // Verify if username isn't already defined in database
        /*if((bool)(verifyUsernameNotExist($user)) == FALSE){
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
        }*/
    }
    /*else{
        // ERROR TYPE 1 - Mandatory camps aren't all defined
        header('Location: ../pages/login.php?error_register=1');
    }*/





?>