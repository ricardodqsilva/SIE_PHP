 <?php   
    session_save_path('C:\data');
    session_start();
    //$_SESSION['page'] = "products.php";

    include('../includes/opendb.php');
    //include('common/header.php');

    include_once('../database/store.php');
?>

<?php

    $id_product = $_GET['id_product'];

    $result = getProductDetails($id_product);

    $row = pg_fetch_assoc($result);

    $_SESSION['page'] = "products.php?id_product=" .$row['id_product'];

    include('common/header.php');


    echo "<div class=\"flex-container\">";
    echo    "<div><img src= \"".$row['image_path']."\"></div>";
    echo    "<div><h2>" . $row['product_name'] . "</h4>";
    echo    "<p><i>Referência:      </i>" . $row['id_product'] . "</p>";
    echo    "<p><i>Marca:           </i>" . $row['product_brand'] . "</p>";
    echo    "<p><i>Tipo de Sola:    </i>" . $row['product_type'] . "</p>";
    echo    "<div style=\"background-color: lightgrey; width: 300px; padding: 5px 50px 50px 50px; text-align: center\"><h3>" . $row['price'] . "€</h3>";

    if(!$authenticated){
        echo "    <button style=\"margin-left: 0px; float:none\"class=\"button_products\" onclick=\"show_authenticationAlert()\">Inicie sessão para adicionar ao carrinho</button>";
    }
    else{
        if ( $row['quantity_available'] > 0 ){
            if(isset($_SESSION['cart']) && array_key_exists( $row['id_product'] , $_SESSION['cart'])){
                if( $row['quantity_available'] - $_SESSION['cart'][$row['id_product']] > 0 ){
                    echo "    <form action=\"../actions/action_updateShoppCart.php\" method=\"post\">";
                    echo "        <input type=\"hidden\" name=\"product_id_buy\" value=\"" . $row['id_product'] . "\">";
                    echo "        <input style=\"margin-left: 0px; float:none\"class=\"button_products\" type=\"submit\" value=\"Adicionar ao Carrinho\">";
                    echo "    </form>";
                }
                else{
                    echo "    <button style=\"margin-left: 0px; float:none\"class=\"button_products\" onclick=\"show_unavailabilityAlert()\">Adicionar ao Carrinho</button>";
                }
            }
            else{
                echo "    <form action=\"../actions/action_updateShoppCart.php\" method=\"post\">";
                echo "        <input type=\"hidden\" name=\"product_id_buy\" value=\"" . $row['id_product'] . "\">";
                echo "        <input style=\"margin-left: 0px; float:none\"class=\"button_products\" type=\"submit\" value=\"Adicionar ao Carrinho\">";
                echo "    </form>";
            }
        }
        else{
            echo "    <button style=\"margin-left: 0px; float:none\"class=\"button_products\" onclick=\"show_unavailabilityAlert()\">Adicionar ao Carrinho</button>";
        }
    }
   
    echo "</div>";
    echo            "</div>";
    echo    "<div style=\"padding: 0px;\"class=\"divider\"></div><div><h2>Descrição Técnica</h2><p>" .$row['description']."</div>";      
    echo "</div>";

?>

<?php
    include('common/footer.php');
    include('../includes/closedb.php');
?>