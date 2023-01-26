<?php
    session_save_path('C:\data');
    session_start();                            // Session start to get session variables of current version
    include('../includes/opendb.php');          // Open communication channel between server and database
    include_once("../database/store.php");      // Include of PHP functions libraries related with STORE page

    $product = $_POST['product_id_remove'];     // Get product id to be removed from the store (historic data relatec with orders may become inconsistent!)

    removeProduct($product);                    // Remove the specific product from store
    
    header('Location: ../pages/store.php');     // Redirect to store
?>