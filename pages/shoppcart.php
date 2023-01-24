<?php
    session_save_path('C:\data');
    session_start();
    $_SESSION['page'] = "shoppcart";

    include('../includes/opendb.php');
    include('common/header.php');

    include_once("../database/shoppcart.php");
    if(isset($_SESSION['cart'])){
        $id_products = array_keys($_SESSION['cart']);
        $quantities  = array_values($_SESSION['cart']);
    }
    else{
        $id_products = NULL;
        $quantities  = NULL;
    }
?>


<div id="results_box">
    <?php

        $total_payment = 0;
		if($id_products != NULL){
        if(sizeof($id_products) >0 ){
            for($i=0; $i < sizeof($id_products); $i++){
                $query = getSpecificBoots($id_products[ $i ]);
                $row   = pg_fetch_assoc($query,0);
                
                echo  "<div class=\"product_separation\">&nbsp</div> <!-- Rule in HTML --> ";
                echo  "<div class=\"product_descrip\">";
                echo  "     <div class=\"product_imag_div\"><img src=\"" . $row['image_path']. "\" ;></div>";
                echo  "     <div class=\"product_info\">";
                echo  "         <h1>" . $row['product_name'] . "</h1>";
                echo  "         <h2> Código do Produto: " . $row['id_product']. "</h2>";
                echo  "     </div>";
                echo  "     <div class=\"product_price\">";
                echo  "         <h1>Preço / Unidade: " . number_format($row['price'], 2, "," , "." ). " €</h1>";
                echo  "         <h1>Número Unidades: " . number_format($quantities[$i], 0) . "</h1>";
                echo  "   </div>";
                echo  "   <div class=\"product_interact\">";
                echo "    <form action=\"../actions/action_removeProduct_ShoppCart.php\" method=\"post\">";
                echo "        <input type=\"hidden\" name=\"product_id_remove\" value=\"" . $row['id_product'] . "\">";
                echo "        <input class=\"button_products\" type=\"submit\" value=\"Remover do Carrinho\">";
                echo "    </form>";                          
                echo  "  </div>";
                echo "</div>";
             
                $total_payment = $total_payment + ($row['price']*$quantities[$i]);
            }
            echo  "<div class=\"product_separation\">&nbsp</div> <!-- Rule in HTML --> ";
        }} else {
            echo "<p>&nbsp&nbsp Não foram efetuadas nenhumas adições ao carrinho de compras.</p>";
            }   
?>
    
</div>

<!-------------------------------------------------------->
<!--------------------- TOTAL ORDERS --------------------->
<!-------------------------------------------------------->
<div id="filter_title"><b>Pagamento total da encomenda</b></div>
<div id="payment_camps">
    <form id="search_form" method="get" action="../actions/action_makeOrder.php">
        <?php
            echo "<p>" . number_format($total_payment, 2, "," , "." ) . " €</p>";
            if(isset($_SESSION['cart']))
                if(sizeof($_SESSION['cart'])>0)
                    echo "<p><input id=\"button_buy\" type=\"submit\" value=\"Finalizar compra\"></p>";
        ?>
    </form>
</div>

<?php
    include('common/footer.php');
    include('../includes/closedb.php');
?>