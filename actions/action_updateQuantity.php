<?php
    session_start();                            // Session start to get session variables of current version
    include('../includes/opendb.php');          // Open communication channel between server and database
    include_once("../database/store.php");      // Include of PHP functions libraries related with STORE page

    // If product id and type of update (increased / decreased) are defined, update available product quantity
    if(isset($_GET['product_id'], $_GET['type_update'])){
        $id_product  = $_GET['product_id'];
        $type_update = $_GET['type_update'];

        switch ($type_update) {
            case 'increase':        // Increase available quantity
                updateIncreasedQuantity($id_product);
                break;
            case 'decrease':        // Decreased available quantity
                updateDecreasedQuantity($id_product);
                break;
        }
    }

    header('Location: ../pages/store.php');     // Redirect to store
?>