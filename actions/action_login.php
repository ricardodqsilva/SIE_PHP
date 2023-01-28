<?php
    session_save_path('C:\data');
    session_start();                        // Session start to get session variables of current version
    include('../includes/opendb.php');      // Open communication channel between server and database
    include_once("../database/login.php");  // Include of PHP functions libraries related with LOGIN page

    // If POST variables of username and password are defined, verify in database if credentials are valid!
    if (isset($_POST["log_username"], $_POST["log_password"])) {
        // Gets users informatin inserted in the login form
        $user = $_POST["log_username"];
        $pass = md5($_POST["log_password"]);
        
        // Validate credentials
        $username = validateLogin($user,$pass);

        // User founded in database
        if($username != NULL) {
            // LOGIN INFORMATIONS
            $_SESSION['username']      = $username['username'];
            $_SESSION['authenticated'] = true;
            $_SESSION['admin']         = $username['admin_perm'] == 't' ? true : false;
            $_SESSION['name_user']     = $username['name'];

            // DEBUG - see admin permissions - Comment!!!
            //header('Location: ../pages/store.php?error='.$username['admin_perm']);<?php  echo "?previous_page=".$_GET['previous_page'];
            if(isset($_GET['previous_page'])){
                if($_GET['previous_page'] != str_starts_with($_GET['previous_page'], 'products')){
                header('Location: ../pages/'.$_GET['previous_page'].'.php');
                }
                else header('Location: ../pages/'.$_GET['previous_page']);
            }
            else
                header('Location: ../pages/store.php');
        }
        // Some camp necessary to login isn't defined
        else {
            // ERROR TYPE 2 - User isn't registered in the platform
            header('Location: ../pages/login.php?error_login=2');
        }


    }
    // If POST variables of username or password aren't defined, send error type 1!
    else{
        // ERROR TYPE 1 - Username or Password not defined!
        header('Location: ../pages/login.php?error_login=1');
    }
?>