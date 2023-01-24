<?php
    session_start();                            // Session start to get session variables of current version
    include('../includes/opendb.php');          // Open communication channel between server and database
    include_once("../database/orders.php");     // Include of PHP functions libraries related with ORDERS page

    eraseAllOrders();                           // Erase all orders saved in the database

    header('Location: ../pages/store.php');     // Redirect to store
?>