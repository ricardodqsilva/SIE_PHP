<?php
    session_save_path('C:\data');
    session_start();
    $_SESSION['page'] = "store"; //???

    // Initialise shopping cart
    if (!isset($_SESSION['cart'])){
        $_SESSION['cart'] = array();
    }

    include('../includes/opendb.php');
    include('common/header.php');

    include_once("../database/store.php");
?>

<?php 
    // Gets previous search words inserted by the user
    $searchWords = "";
    if(isset($_GET['search'])){
        $searchWords = $_GET['search'];
    }

    // Gets previous clarinet brands selected
    $brandsSelected = [];
	if(isset($_GET['brandsArray'])){
		$brandsSelected = $_GET['brandsArray'];
    }
    // Gets all clarinet brands available in the store
    $clarinetBrands = getAllClarinetBrands();
    
    // Gets previous clarinet types selected
    $typesSelected = [];
	if(isset($_GET['typesArray'])){
		$typesSelected = $_GET['typesArray'];
    }
    // Gets all clarinet types available in the store
    $clarinetTypes = getAllClarinetTypes();

    // Execute query to obtain search results
    $clarinetsSearched = getSearchedClarinets($searchWords, $typesSelected, $brandsSelected);
?>

<!------------------------------------------------------->
<!------------------- SEARCH FILTERS -------------------->
<!------------------------------------------------------->
<div id="filter_title"><b>Filtros de Pesquisa</b></div>
<div id="filter_camps">
    <form id="search_form" method="get" action="store.php">
        <p>Tipo:</p>
        <?php
            // List all clarinet types available in the store
            if(0 < pg_numrows($clarinetBrands)){
                for($i=0; $i < pg_numrows($clarinetTypes); $i++){
                    $row = pg_fetch_row($clarinetTypes, $i);
                    $checkboxElement = "<input type='checkbox' name='typesArray[]' value='".$row[0]."'";
                    // Guarantee the search past values remains visible
                    if(!empty($typesSelected)){
                        for($j=0; $j<sizeof($typesSelected); $j++){
                            if($row[0] == $typesSelected[$j]){
                                $checkboxElement .= " checked ";
                            }
                        }
                    }
                    $checkboxElement .= ">";
                    $checkboxElement .= "<label for='$row[0]'>"."Clarinete "."$row[0]</label><br>";
                    echo $checkboxElement;
                }
            }
            // In case there are any clarinet types defined in the database
            else{
                echo "Não existe nenhum tipo de clarinetes definida na base de dados<br>";
            }
        ?>

        <p>Marca:</p>
        <?php
            // List all clarinet brands available in the store
            if(0 < pg_numrows($clarinetBrands)){
                for($i=0; $i < pg_numrows($clarinetBrands); $i++){
                    $row = pg_fetch_row($clarinetBrands, $i);
                    $checkboxElement = "<input type='checkbox' name='brandsArray[]' value='".$row[0]."'";
                    // Guarantee the search past values remains visible
                    if(!empty($brandsSelected)){
                        for($j=0; $j<sizeof($brandsSelected); $j++){
                            if($row[0] == $brandsSelected[$j]){
                                $checkboxElement .= " checked ";
                            }
                        }
                    }
                    $checkboxElement .= ">";
                    $checkboxElement .= "<label for='$row[0]'>$row[0]</label><br>";
                    echo $checkboxElement;
                }
            }
            // In case there are any clarinet brands defined in the database
            else{
                echo "Não existe nenhuma marca de clarinetes definida na base de dados<br>";
            }
        ?>

        <input type="hidden" name="search" value="<?php if(!empty($searchWords)){echo $searchWords;}?>" />
        <p><input id="filter_ok" type="submit" value="Ok"></p>
    </form>
</div>


<!---------------------------------------------------->
<!-------------------- SEARCH BOX -------------------->
<!---------------------------------------------------->
<form action="store.php" method="get">
    <div class="div_search_bar">
        <input class="search_bar" type="text" value="<?php if(!empty($searchWords)){echo $searchWords;}?>" name="search" placeholder="     Pesquise nome produto aqui . . ." required>
    </div>
</form>


<!-------------------------------------------------------->
<!-------------------- SEARCH RESULTS -------------------->
<!-------------------------------------------------------->
<div id="results_box">
    <?php
        if(pg_numrows($clarinetsSearched)>0){
            $row = pg_fetch_assoc($clarinetsSearched);

            while (isset($row['id_product'])){
                echo "<div class=\"product_separation\">&nbsp</div> <!-- Rule in HTML -->";

                echo "<div class=\"product_descrip\">";
                echo "    <div class=\"product_imag_div\"><img src=\"" . $row['image_path'] . "\"></div>";
                echo "    <div class=\"product_info\">";
                echo "        <h1>" . $row['product_name'] . "</h1>";
                echo "        <h2>" . $row['id_product'] . "</h2>";
                echo "    </div>";
                echo "    <div class=\"product_price\">";
                echo "        <h1>Preço: ". number_format($row['price'], 2, "," , "." ) . " €</h1>";
                if ( $row['quantity_available'] > 0 ){
                    if(isset($_SESSION['cart']) && array_key_exists( $row['id_product'] , $_SESSION['cart'])){
                        if( $row['quantity_available'] - $_SESSION['cart'][$row['id_product']] > 0 ){
                            if($admin_permissions && $authenticated){
                                echo "        <h1 style=\"width:auto;\">Disponibilidade: ". number_format($row['quantity_available'] - $_SESSION['cart'][$row['id_product']], 0)."<a style=\"text-decoration:none;\" href=\"../actions/action_updateQuantity.php?product_id=".$row['id_product']."&type_update=decrease\"><button class=\"button_updateQuant\">-</button></a><a style=\"text-decoration:none;\" href=\"../actions/action_updateQuantity.php?product_id=".$row['id_product']."&type_update=increase\"><button class=\"button_updateQuant\">+</button></a></h1>";
                            }
                            else{
                                echo "        <h1>Disponibilidade: ". number_format($row['quantity_available'] - $_SESSION['cart'][$row['id_product']], 0)."</h1>";
                            }
                        }
                        else{
                            echo "        <h1>Artigo indisponível</h1>";
                        }
                    }
                    else{
                        if($admin_permissions && $authenticated){
                            echo "        <h1 style=\"width:auto;\">Disponibilidade: ". number_format($row['quantity_available'], 0)."<a style=\"text-decoration:none;\" href=\"../actions/action_updateQuantity.php?product_id=".$row['id_product']."&type_update=decrease\"><button class=\"button_updateQuant\">-</button></a><a style=\"text-decoration:none;\" href=\"../actions/action_updateQuantity.php?product_id=".$row['id_product']."&type_update=increase\"><button class=\"button_updateQuant\">+</button></a></h1>";
                        }
                        else{
                            echo "        <h1>Disponibilidade: ". number_format($row['quantity_available'], 0)."</h1>";
                        }
                    }
                }
                else{
                    if($admin_permissions && $authenticated){
                        echo "        <h1>Artigo indisponível<a style=\"text-decoration:none;\" href=\"../actions/action_updateQuantity.php?product_id=".$row['id_product']."&type_update=increase\"><button class=\"button_updateQuant\">+</button></a></h1>";
                    }
                    else{
                        echo "        <h1>Artigo indisponível</h1>";
                    }
                }
                echo "    </div>";
                echo "    <div class=\"product_interact\">";

                // AUTHENTICATED - Add product to shopping cart
                if(!$authenticated){
                    echo "    <button class=\"button_products\" onclick=\"show_authenticationAlert()\">Adicionar ao Carrinho</button>";
                }
                else{
                    if ( $row['quantity_available'] > 0 ){
                        if(isset($_SESSION['cart']) && array_key_exists( $row['id_product'] , $_SESSION['cart'])){
                            if( $row['quantity_available'] - $_SESSION['cart'][$row['id_product']] > 0 ){
                                echo "    <form action=\"../actions/action_updateShoppCart.php\" method=\"post\">";
                                echo "        <input type=\"hidden\" name=\"product_id_buy\" value=\"" . $row['id_product'] . "\">";
                                echo "        <input class=\"button_products\" type=\"submit\" value=\"Adicionar ao Carrinho\">";
                                echo "    </form>";
                            }
                            else{
                                echo "    <button class=\"button_products\" onclick=\"show_unavailabilityAlert()\">Adicionar ao Carrinho</button>";
                            }
                        }
                        else{
                            echo "    <form action=\"../actions/action_updateShoppCart.php\" method=\"post\">";
                            echo "        <input type=\"hidden\" name=\"product_id_buy\" value=\"" . $row['id_product'] . "\">";
                            echo "        <input class=\"button_products\" type=\"submit\" value=\"Adicionar ao Carrinho\">";
                            echo "    </form>";
                        }
                    }
                    else{
                        echo "    <button class=\"button_products\" onclick=\"show_unavailabilityAlert()\">Adicionar ao Carrinho</button>";
                    }
                }

                // ADMIN_PERMISSIONS - Remove Product
                if($admin_permissions && $authenticated){
                    echo "    <form action=\"../actions/action_removeProduct.php\" method=\"post\">";
                    echo "        <input type=\"hidden\" name=\"product_id_remove\" value=\"" . $row['id_product'] . "\">";
                    echo "        <input class=\"button_products\" type=\"submit\" value=\"Remover Produto\">";
                    echo "    </form>";
                }

                echo "    </div>";
                echo "</div>";

                $row = pg_fetch_assoc($clarinetsSearched);
            }
            echo "<div class=\"product_separation\">&nbsp</div> <!-- Rule in HTML -->";
        }
        else{
            echo "<p>&nbsp&nbsp Não foram encontrados resultados para os parâmetros de pesquisa específicados.</p>";
        }
    ?>
</div>

<?php
    include('common/footer.php');
    include('../includes/closedb.php');
?>