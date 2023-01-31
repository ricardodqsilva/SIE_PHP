<?php
    session_save_path('C:\data');
    session_start();                            // Session start to get session variables of current version
    include('../includes/opendb.php');          // Open communication channel between server and database
    include_once("../database/orders.php");  // Include of PHP functions libraries related with SHOPPING CART page



    $id_order_old = $_POST['id_order_update'];
    $date_ordered = $_POST['date_ordered'];
    $username = $_POST['username'];
    $id_order_new = explode("waitingvalidation", $id_order_old);

    updateOrder($id_order_new[0], $id_order_old, $date_ordered, $username);                        // Addition of current order to database

    header('Location: ../pages/orders.php');     // Redirect to store with the objective of the user be able to make more shops
?>