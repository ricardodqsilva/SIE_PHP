<?php
    function validateLogin($username,$password){
        global $conn;
        
        // Formulate query to see if the user is registered in the platform
        $query = "select * from users where username = '" . $username . "' AND password = '" . $password. "';" ;
        $result = pg_exec($conn, $query);
      
        // Get number of registers
        $num_registers = pg_num_rows($result);
        
        // If NUM_REGISTERS isn't greater than 0, it means that user isn't register in the platform
        if ($num_registers > 0) {
            $user = pg_fetch_assoc($result, 0);
            return $user;
        }
        else {
            return NULL;
        }
    }

    function registerUser($name,$username,$email,$password,$address){
        global $conn;

        // Formulate query with camps inserted by website visitor
        $query = "insert into users (username, password, name, email, admin_perm";
        if($address != NULL){
            $query .= ", address) values ('".$username."', '".$password."', '".$name."', '".$email."', '0', '".$address."');";
        }
        else{
            $query .= ") values ('".$username."', '".$password."', '".$name."', '".$email."', '0');";
        }
        $result = pg_exec($conn, $query);
        return $result;
    }

    function verifyUsernameNotExist($username){
        global $conn;

        // Formulate query to search username in database
        $query  = "select username from users where username='" . $username . "';";
        $result = pg_exec($conn, $query);

        // If query returns one or more results, returns FALSE <=> Username not exist is a FALSE afirmation
        if(pg_num_rows($result) > 0){
            return 0;
        }
        // If query returns none results, returns TRUE <=> Username not exist is a TRUE afirmation
        else{
            return 1;
        }
    }
?>