<?php
    session_start();                                // Session start to get session variables of current version
    include('../includes/opendb.php');              // Open communication channel between server and database
    include_once("../database/shoppcart.php");      // Include of PHP functions libraries related with SHOPPING CART page

    $product = $_POST['product_id_remove'];         // Get product id of item to be removed

    $id_products = array_keys($_SESSION['cart']);
    $new_cart = [];
    for($i=0;$i<sizeof($id_products);$i++){
        if($id_products[$i] == $product){
            continue;
        }
        $new_cart[$id_products[$i]] = $_SESSION['cart'][$id_products[$i]];
    }
    $_SESSION['cart'] = $new_cart;                  // Update shopping cart without the item removed from the cart

    header('Location: ../pages/shoppcart.php');     // Redirect to shopping cart to continue the shopping procedure
?>