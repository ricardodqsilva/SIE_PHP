<?php

    function getSpecificBoots($id_product){
        global $conn;
        $query = "select * from chuteiras where id_product = '" . $id_product . "';";
        $result = pg_exec($conn, $query);
        return $result;
    }

    function addOrder($id_order){
        global $conn;
        $id_products = array_keys($_SESSION['cart']);
        $quantities  = array_values($_SESSION['cart']);
        addSpecificOrders($id_order);
        for($i=0; $i < sizeof($id_products); $i++){
            quantityOrdered($id_order,$id_products[$i],$quantities[$i]);
            decreaseQuantity($id_products[$i],$quantities[$i]);
        }       
    }

    function addSpecificOrders($id_order){  
        global $conn;                                                                            
        $query = "insert into orders (id_order,date_ordered,username) VALUES ('" .$id_order. "', localtimestamp, '".$_SESSION['username']."');";
        echo "DEBUG:". $query;
        $result = pg_exec($conn, $query);
        return $result;
    }

    function decreaseQuantity($id_products,$quantities){
        global $conn;
        $query = "update chuteiras SET quantity_available = quantity_available - '" .$quantities ."' where id_product = '" .$id_products. "';";
        $result = pg_exec($conn, $query);
        return $result;
    }

    function quantityOrdered($id_order,$id_products,$quantities){
        global $conn;
        $query = "insert into order_product (id_order,id_product,quantity) VALUES ('" .$id_order. "', '" .$id_products. "', '".$quantities."');";
        $result = pg_exec($conn, $query);
        return $result;
    }
?>