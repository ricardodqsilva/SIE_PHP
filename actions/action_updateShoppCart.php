<?php
    session_start();                        // Session start to get session variables of current version

    // Update shopping cart quantity related to specific product
    $product = $_POST['product_id_buy'];
    if($_SESSION['cart'][$product] == NULL){
        $_SESSION['cart'][$product] = 1;
    }
    else{
        $_SESSION['cart'][$product] += 1;
    }
    
    header('Location: ../pages/store.php'); // Redirect to store
?>