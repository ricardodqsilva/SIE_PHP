<?php
    session_save_path('C:\data');
    session_start();
    $_SESSION['page'] = "management_products";

    include('../includes/opendb.php');
    include('common/header.php');
    
    include_once("../database/store.php");


    echo "<div class=\"results-container\">";
    // The historic that will be presented only shows if ADMIN_PERMISSIONS are TRUE
    if($admin_permissions){
        
    

        $searchWords="";
        $typesSelected=[];
        $brandsSelected=[];


        // Execute query to obtain search results
        $bootsSearched = getSearchedBoots($searchWords, $typesSelected, $brandsSelected);

        if(pg_num_rows($bootsSearched)>0){
            $row = pg_fetch_assoc($bootsSearched);

            while (isset($row['id_product'])){


                echo "    <div><a style=\"text-decoration:none; color:inherit\" href=\"products_management.php?id_product=".$row['id_product']."\"><img class=\"results-container_img\"src=\"" . $row['image_path'] . "\"></a>";
                ///echo "    <div>";
                echo "<h4 style=\"width: 305.8px; height: 38px;\">" . $row['product_name'] . "</h4>";
                echo         "<h3 style=\"width: 305.8px; margin-bottom: 3px;\">". number_format($row['price'], 2, "," , "." ) . " €";
                //echo      "</div>";  
                if ( $row['quantity_available'] > 0 ){
                    if(isset($_SESSION['cart']) && array_key_exists( $row['id_product'] , $_SESSION['cart'])){
                        if( $row['quantity_available'] - $_SESSION['cart'][$row['id_product']] > 0 ){
                            if($admin_permissions && $authenticated){
                                //echo "        <h1 style=\"width:auto;\">Disponibilidade: ". number_format($row['quantity_available'] - $_SESSION['cart'][$row['id_product']], 0)."<a style=\"text-decoration:none;\" href=\"../actions/action_updateQuantity.php?product_id=".$row['id_product']."&type_update=decrease\"><button class=\"button_updateQuant\">-</button></a><a style=\"text-decoration:none;\" href=\"../actions/action_updateQuantity.php?product_id=".$row['id_product']."&type_update=increase\"><button class=\"button_updateQuant\">+</button></a></h1>";
                            }
                            else{
                                //echo "        <h1>Disponibilidade: ". number_format($row['quantity_available'] - $_SESSION['cart'][$row['id_product']], 0)."</h1>";
                            }
                        }
                        else{
                            //echo "        <h1>Artigo indisponível</h1>";
                        }
                    }
                    else{
                        if($admin_permissions && $authenticated){
                            //echo "        <h1 style=\"width:auto;\">Disponibilidade: ". number_format($row['quantity_available'], 0)."<a style=\"text-decoration:none;\" href=\"../actions/action_updateQuantity.php?product_id=".$row['id_product']."&type_update=decrease\"><button class=\"button_updateQuant\">-</button></a><a style=\"text-decoration:none;\" href=\"../actions/action_updateQuantity.php?product_id=".$row['id_product']."&type_update=increase\"><button class=\"button_updateQuant\">+</button></a></h1>";
                        }
                        else{
                            //echo "        <h1>Disponibilidade: ". number_format($row['quantity_available'], 0)."</h1>";
                        }
                    }
                }
                else{
                    if($admin_permissions && $authenticated){
                        //echo "        <h1>Artigo indisponível<a style=\"text-decoration:none;\" href=\"../actions/action_updateQuantity.php?product_id=".$row['id_product']."&type_update=increase\"><button class=\"button_updateQuant\">+</button></a></h1>";
                    }
                    else{
                        //echo "        <h1>Artigo indisponível</h1>";
                    }
                }
                ///echo "    </div>";
                ///echo "    <div class=\"product_interact\">";

                // AUTHENTICATED - Add product to shopping cart
                if(!$authenticated){
                    //echo "    <button style=\"float:none; margin: 0px 0px 0px 20px\"class=\"button_products\" onclick=\"show_authenticationAlert()\">Adicionar ao Carrinho</button>";

                    echo     "<form style=\"display:inline\"action=\"products_management.php\" method=\"get\">";
                    echo         "<input type=\"hidden\" name=\"id_product\" value=\"" . $row['id_product'] . "\">";
                    echo         "<input style=\"float:none; margin: 0px 0px 0px 40px\"class=\"button_products\" type=\"submit\" value=\"Mais Detalhes\">";
                    echo     "</form>";

                }
                else{
                    if ( $row['quantity_available'] > 0 ){
                        if(isset($_SESSION['cart']) && array_key_exists( $row['id_product'] , $_SESSION['cart'])){
                            if( $row['quantity_available'] - $_SESSION['cart'][$row['id_product']] > 0 ){
                                echo "    <form style=\"display:inline\"action=\"products_management.php\" method=\"get\">";
                                echo "        <input type=\"hidden\" name=\"id_product\" value=\"" . $row['id_product'] . "\">";
                                echo "        <input style=\"float:none; margin: 0px 0px 0px 40px\"class=\"button_products\" type=\"submit\" value=\"Mais Detalhes\">";
                                echo "    </form>";
                            }
                            else{
                                //echo "    <button style=\"float:none; margin: 0px 0px 0px 20px\"class=\"button_products\" onclick=\"show_unavailabilityAlert()\">Adicionar ao Carrinho</button>";
                                echo     "<form style=\"display:inline\"action=\"products_management.php\" method=\"get\">";
                                echo         "<input type=\"hidden\" name=\"id_product\" value=\"" . $row['id_product'] . "\">";
                                echo         "<input style=\"float:none; margin: 0px 0px 0px 40px\"class=\"button_products\" type=\"submit\" value=\"Mais Detalhes\">";
                                echo     "</form>";
                            }
                        }
                        else{
                            echo     "<form style=\"display:inline\"action=\"products_management.php\" method=\"get\">";
                            echo         "<input type=\"hidden\" name=\"id_product\" value=\"" . $row['id_product'] . "\">";
                            echo         "<input style=\"float:none; margin: 0px 0px 0px 40px\"class=\"button_products\" type=\"submit\" value=\"Mais Detalhes\">";
                            echo     "</form>";
                        }
                    }
                    else{
                        //echo "    <button style=\"float:none; margin: 0px 0px 0px 20px\"class=\"button_products\" onclick=\"show_unavailabilityAlert()\">Adicionar ao Carrinho</button>";
                        echo     "<form style=\"display:inline\"action=\"products_management.php\" method=\"get\">";
                        echo         "<input type=\"hidden\" name=\"id_product\" value=\"" . $row['id_product'] . "\">";
                        echo         "<input style=\"float:none; margin: 0px 0px 0px 40px\"class=\"button_products\" type=\"submit\" value=\"Mais Detalhes\">";
                        echo     "</form>";
                    }
                }
                echo "</h4>";
                // ADMIN_PERMISSIONS - Remove Product
                if($admin_permissions && $authenticated){
                    echo "    <form action=\"../actions/action_removeProduct.php\" method=\"post\">";
                    echo "        <input type=\"hidden\" name=\"product_id_remove\" value=\"" . $row['id_product'] . "\">";
                    echo "        <input style=\"float:none; margin-left: 105px;\"class=\"button_products\" type=\"submit\" value=\"Remover Produto\">";
                    echo "    </form>";
                }

                
                echo "    </div>";

                $row = pg_fetch_assoc($bootsSearched);

            }
            //echo "<div class=\"product_separation\">&nbsp</div> <!-- Rule in HTML -->";
        }
        
        else{
            echo "<p>&nbsp&nbsp Não foram encontrados resultados para os parâmetros de pesquisa específicados.</p>";
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
    <div style="text-decoration:none"><a href="orders.php">Encomendas</a></div>
    <div style="background-color:rgb(75,75,75); text-decoration:none;"><a href="management_products.php">Produtos</a></div>
</div>

<div class="flex-container-menu" style="top:264px">
    <div style="text-decoration:none"><a href="add_products.php">Adicionar Produto</a></div>
</div>