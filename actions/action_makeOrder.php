<?php
    session_start();                            // Session start to get session variables of current version
    include('../includes/opendb.php');          // Open communication channel between server and database
    include_once("../database/shoppcart.php");  // Include of PHP functions libraries related with SHOPPING CART page

    $id_order = gmdate('Ymdhis');               // Generate order ID to became unique in database (Primary Key of 'orders' table)
    addOrder($id_order);                        // Addition of current order to database

    unset($_SESSION['cart']);                   // Destroy shopping cart to make it empty

    header('Location: ../pages/store.php');     // Redirect to store with the objective of the user be able to make more shops
?>