<?php
    function getAllOrders(){
        global $conn;
        $query = "select * from orders order by date_ordered desc;";
        $result = pg_exec($conn, $query);
        return $result;
    }

    function getProductsAsociatedOrder($id_order){
        global $conn;
        $query = "select * from order_product, clarinet where id_prod = id_product and id_ord='".$id_order."';";
        $result = pg_exec($conn, $query);
        return $result;
    }

    function eraseAllOrders(){
        global $conn;
        $query1 = "delete from order_product;";
        $query2 = "delete from orders;";
        $result = pg_exec($conn, $query1);
        $result = pg_exec($conn, $query2);
        return $result;
    }
?>