 <?php   
    session_save_path('C:\data');
    session_start();
    $_SESSION['page'] = "products";

    include('../includes/opendb.php');
    include('common/header.php');

    include_once('../database/store.php');
?>

<?php

    $id_product = $_GET['id_product'];

    $result = getProductDetails($id_product);

    $row = pg_fetch_assoc($result);

    
    echo "<div class=\"flex-container\">";
    echo    "<div><img src= \"".$row['image_path']."\"></div>";
    echo    "<div><h4>" . $row['product_name'] . "</h4><p>" . $row['price'] ."€</div>";  
    echo "</div>";

?>

<?php
    include('common/footer.php');
    include('../includes/closedb.php');
?>