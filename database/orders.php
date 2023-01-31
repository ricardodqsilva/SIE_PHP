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

    function eraseAnOrder($id_order){
        global $conn;
        $query1 = "delete from order_product where id_order='".$id_order."'";
        $query2 = "delete from orders where id_order='".$id_order."'";
        $result = pg_exec($conn, $query1);
        $result = pg_exec($conn, $query2);
        return $result;
    }

    function getSpecificOrder_product ($id_order){
        global $conn;
        $query = "select * from order_product where id_order= '".$id_order."'";
        $result = pg_exec($conn, $query);
        return $result;
    }

    function updateOrder($id_order_new, $id_order_old, $date_ordered, $username){
        global $conn;
        $query = "insert into orders (id_order,date_ordered,username) VALUES ('" .$id_order_new. "', '".$date_ordered."', '".$username."');";
        $result = pg_exec($conn, $query);

        $result = getSpecificOrder_product($id_order_old);
        $row = pg_fetch_assoc($result);

        while (isset($row['id_product'])){
            $query = "insert into order_product (id_order,id_product,quantity) VALUES ('" .$id_order_new. "', '".$row['id_product']."', '".$row['quantity']."');";
            pg_exec($conn, $query);

            $row = pg_fetch_assoc($result);
        }

        eraseAnOrder($id_order_old);

        return $result;
    }
?>