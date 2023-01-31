<?php
    session_save_path('C:\data');
    session_start();
    $_SESSION['page'] = "orders_personalpage";

    include('../includes/opendb.php');
    include('common/header.php');
    
    include_once("../database/orders.php");

    $allOrders = getAllOrdersfromUser($username);

    echo "<div id=\"results_box\">";

    // The historic that will be presented only shows if ADMIN_PERMISSIONS are TRUE
    if($authenticated){
        if(pg_num_rows($allOrders)>0){
            // Get just ONE ROW from query that contains all orders made in the Boots Store
            $row = pg_fetch_assoc($allOrders);

            while (isset($row['id_order'])){
                // Separate different orders
                echo "<div class=\"product_separation\">&nbsp</div> <!-- Rule in HTML -->";

                // Display order
                echo "<div class=\"order_descrip\">";

                if(str_contains($row['id_order'], "waitingvalidation")){
                    $id_order = explode("waitingvalidation", $row['id_order']);
                    echo "    <h1>ID " . $id_order[0] . ": efetuada em ". $row['date_ordered'] . " <span class=\"red\">(Espera Envio)</span></h1>";
                }
    
    
                    else echo "    <h1>ID " . $row['id_order'] . ": efetuada em ". $row['date_ordered'] . " <span class=\"green\">(Enviado)</span></h1>";


                echo "    <table>";
                echo "        <tr>";
                echo "            <th class=\"headerTable1\"><i><b>Nome do Produto:</b></i></th>";
                echo "            <th class=\"headerTable2\"><i><b>Número Unidades:</b></i></th>";
                echo "            <th class=\"headerTable3\"><i><b>Preço / Unidade:</b></i></th>";
                echo "        </tr>";
                
                $allProductsRelatOrder = getProductsAsociatedOrder($row['id_order']);
                if(pg_num_rows($allProductsRelatOrder)>0){
                    $row_eachOrder = pg_fetch_assoc($allProductsRelatOrder);
                    $totalPay = 0;
                    while(isset($row_eachOrder['id_order'])){
                        echo "        <tr>";
                        echo "            <td class=\"column1\">".$row_eachOrder['product_name']."</td>";
                        echo "            <td class=\"column2\">".$row_eachOrder['quantity']."</td>";
                        echo "            <td class=\"column3\">".number_format($row_eachOrder['price'], 2, "," , "." )." €</td>";
                        echo "        </tr>";
                        $totalPay = $totalPay + $row_eachOrder['price'] * $row_eachOrder['quantity'];
                        $row_eachOrder = pg_fetch_assoc($allProductsRelatOrder);
                    }
                    echo "        <tr>";
                    echo "            <td class=\"footerTable1\"></td>";
                    echo "            <td class=\"footerTable2\"><b>Total:</b></td>";
                    echo "            <td class=\"footerTable3\">".number_format($totalPay, 2, "," , "." )." €</td>";
                    echo "        </tr>";
                }
                else{
                    echo "ERRO - não foram encontrados os produtos associados a determinada ordem.";
                }

                echo "    </table>";



                echo "</div>";

                // Get other ONE ROW from query that contains all orders made in the Clarinets Store
                $row = pg_fetch_assoc($allOrders);
            }
                
            // Separate different orders
            echo "<div class=\"product_separation\">&nbsp</div> <!-- Rule in HTML -->";

        }
        else{
            echo "<p>&nbsp&nbsp Não existe de momento histórico de encomendas na plataforma.</p>";
        }
    }
    else{
        echo "<p>&nbsp&nbsp Não tem permissões para aceder a esta página.</p>";
    }

    echo "</div>";

    include('common/footer.php');
    include('../includes/closedb.php');
?>


<div class="flex-container-menu">
    <div style="text-decoration:none"><a href="personalpage.php?username=<?php echo $username ?>">Página Pessoal</a></div>
    <div style="background-color:rgb(75,75,75); text-decoration:none;"><a href="orders_personalpage.php">Minhas Encomendas</a></div>
</div>