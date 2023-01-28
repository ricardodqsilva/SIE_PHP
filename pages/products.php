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
    echo    "<div><h2>" . $row['product_name'] . "</h4>";
    echo    "<p><i>Referência:      </i>" . $row['id_product'] . "</p>";
    echo    "<p><i>Marca:           </i>" . $row['product_brand'] . "</p>";
    echo    "<p><i>Tipo de Sola:    </i>" . $row['product_type'] . "</p>";
    echo    "<div style=\"background-color: lightgrey; width: 300px; padding: 5px 50px 50px 50px; text-align: center\"><h3>" . $row['price'] . "€</h3>";
    echo     "<form action=\"../actions/action_updateShoppCart.php\" method=\"post\">";
    echo         "<input type=\"hidden\" name=\"product_id_buy\" value=\"" . $row['id_product'] . "\">";
    echo         "<input style=\"margin-left: 0px; float:none\"class=\"button_products\" type=\"submit\" value=\"Adicionar ao Carrinho\">";
    echo     "</form>";    
    echo "</div>";
    echo            "</div>";
    echo    "<div style=\"padding: 0px;\"class=\"divider\"></div><div><h2>Descrição Ténica</h2><p>" .$row['description']."</div>";      
    echo "</div>";

?>

<?php
    include('common/footer.php');
    include('../includes/closedb.php');
?>