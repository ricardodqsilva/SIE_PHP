<?php
    function getAllOrders(){
        global $conn;
        $query = "select * from orders order by date_ordered desc;";
        $result = pg_exec($conn, $query);
        return $result;
    }

    function getAllOrdersfromUser($username){
        global $conn;
        $query = "select * from orders where username='".$username."'order by date_ordered desc;";
        $result = pg_exec($conn, $query);
        return $result;
    }

    function getProductsAsociatedOrder($id_order){
        global $conn;
        $query = "select * from order_product, chuteiras where order_product.id_product = chuteiras.id_product and id_order='".$id_order."';";
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