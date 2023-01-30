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

    $_SESSION['page'] = "products_management.php?id_product=" .$row['id_product'];

    include('common/header.php');


    echo "<div class=\"flex-container\">";

    if($admin_permissions){

    
    echo    "<div><img src= \"".$row['image_path']."\"></div>";
    echo    "<div><h2>" . $row['product_name'] . "</h2>";
    echo    "<p><i>Referência:      </i>" . $row['id_product'] . "</p>";
    echo    "<p><i>Marca:           </i>" . $row['product_brand'] . "</p>";
    echo    "<p><i>Tipo de Sola:    </i>" . $row['product_type'] . "</p>";
    echo    "<div style=\"background-color: lightgrey; width: 300px; padding: 5px 50px 20px 50px; text-align: center\"><h3>" . $row['price'] . "€</h3>";

    if(!$authenticated){
        echo "    <form action=\"../pages/login.php\" method=\"get\">";
        echo "<select style=\"margin-left: 0px; float:none; padding: 4px 18px; font-weight: normal;border-width: 1px;\" class=\"button_products\">";
        echo    "<option disabled selected value> Escolhe o teu tamanho </option>";
        echo    "<option>40</option>";
        echo    "<option>41</option>";
        echo    "<option>42</option>";
        echo    "<option>43</option>";
        echo    "<option>44</option>";
        echo "</select>";
        echo "        <input type=\"hidden\" name=\"previous_page\" value=\"" . $_SESSION['page'] . "\">";
        echo "        <input style=\"margin-left: -25px; float:none; margin-top: 7.86px;\"class=\"button_products\" type=\"submit\" value=\"Inicie Sessão para adicionar ao carrinho\">";
        echo "    </form>";
        echo "<p style=\"text-align: justify;\"><b>Disponibilidade: </b>" . number_format($row['quantity_available'], 0). "</p>";
    }
    else{
        if ( $row['quantity_available'] > 0 ){
            if(isset($_SESSION['cart']) && array_key_exists( $row['id_product'] , $_SESSION['cart'])){
                if( $row['quantity_available'] - $_SESSION['cart'][$row['id_product']] > 0 ){
                    //echo "<p style=\"text-align: justify;\"><b>Disponibilidade: </b>" . number_format($row['quantity_available'] - $_SESSION['cart'][$row['id_product']], 0). "</p>";
                    echo "        <p style=\"width:auto;\"><b>Disponibilidade:</b> ". number_format($row['quantity_available'] - $_SESSION['cart'][$row['id_product']], 0)."<a style=\"text-decoration:none;\" href=\"../actions/action_updateQuantity.php?product_id=".$row['id_product']."&type_update=decrease\"><button class=\"button_updateQuant\">-</button></a><a style=\"text-decoration:none;\" href=\"../actions/action_updateQuantity.php?product_id=".$row['id_product']."&type_update=increase\"><button class=\"button_updateQuant\">+</button></a></p>"; 
                }
                else{
                    //echo "<p style=\"text-align: justify;\"><b>Indisponível</b></p>";
                    echo "        <p style=\"width:auto;\"><b>Indisponível</b><a style=\"text-decoration:none;\" href=\"../actions/action_updateQuantity.php?product_id=".$row['id_product']."&type_update=decrease\"><button class=\"button_updateQuant\">-</button></a><a style=\"text-decoration:none;\" href=\"../actions/action_updateQuantity.php?product_id=".$row['id_product']."&type_update=increase\"><button class=\"button_updateQuant\">+</button></a></p>"; 

                }
            }
            else{
                echo "        <p style=\"width:auto;\"><b>Disponibilidade:</b> ". number_format($row['quantity_available'], 0)."<a style=\"text-decoration:none;\" href=\"../actions/action_updateQuantity.php?product_id=".$row['id_product']."&type_update=decrease\"><button class=\"button_updateQuant\">-</button></a><a style=\"text-decoration:none;\" href=\"../actions/action_updateQuantity.php?product_id=".$row['id_product']."&type_update=increase\"><button class=\"button_updateQuant\">+</button></a></p>"; 
                //echo "<p><b>Disponibilidade: </b>" . number_format($row['quantity_available'], 0). "</p>";
            }
        }
        else{
            //echo "<p style=\"text-align: justify;\"><b>Indisponível</b></p>";
            echo "        <p style=\"width:auto;\"><b>Indisponível</b><a style=\"text-decoration:none;\" href=\"../actions/action_updateQuantity.php?product_id=".$row['id_product']."&type_update=decrease\"><button class=\"button_updateQuant\">-</button></a><a style=\"text-decoration:none;\" href=\"../actions/action_updateQuantity.php?product_id=".$row['id_product']."&type_update=increase\"><button class=\"button_updateQuant\">+</button></a></p>"; 
        }
    }
   
    echo "</div>";
    echo            "</div>";
    echo    "<div style=\"padding: 0px;\"class=\"divider\"></div><div><h2>Descrição Técnica</h2><p>" .$row['description']."</p></div>";      
    
}
    else{
        echo "<p>&nbsp&nbsp Não tem permissões para aceder a esta página.</p>";
    }
    echo "</div>";
?>

<?php
    include('common/footer.php');
    include('../includes/closedb.php');
?>