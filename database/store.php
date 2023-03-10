<?php
    function getAllBootsTypes(){
        global $conn;
        $query = "select distinct product_type from chuteiras order by product_type;";
        $result = pg_exec($conn, $query);
        return $result;
    }
    
    function getAllBootsBrands(){
        global $conn;
        $query = "select distinct product_brand from chuteiras order by product_brand;";
        $result = pg_exec($conn, $query);
        return $result;
    }

    function getSearchedBoots($search, $types, $brands){
        global $conn;
        // Get all boots saved in the web-platform
        $query = "select * from chuteiras where true and (";
        
        // Set up search filters
        if(!empty($types) && sizeof($types) > 0){   // Filters for boots types
            for($i=0; $i < sizeof($types);$i++){
                $query .= "product_type = '" . $types[$i] . "'";
                if($i<sizeof($types)-1){
                    $query .= " or ";
                }
            }
            $query .= ")";
        }
        else{
            $query .= "true)";
        }
        $query .= " and (";
        if(!empty($brands) && sizeof($brands) > 0){ // Filters for boots brands
            for($i=0; $i < sizeof($brands);$i++){
                $query .= "product_brand = '" . $brands[$i] . "'";
                if($i<sizeof($brands)-1){
                    $query .= " or ";
                }
            }
            $query .= ") ";
        }
        else{
            $query .= "true) ";
        }

        // Search specific words in database with filters applied
        $separatedWords = explode(" ", $search);
        if($separatedWords[0] != NULL){
            for($i=0; $i < sizeof($separatedWords);$i++){
                $separatedWords[$i] = strtolower($separatedWords[$i]);
                $query .= "and LOWER(product_name) LIKE '%" . $separatedWords[$i] . "%' "; //checkar isto
            }
        }

        // Order query by product name
        $query .= "order by product_name;";

        // DEBUG - comment!!!
        // echo $query;

        // Execute query
        $result = pg_exec($conn, $query);
		return $result;
    }

    function removeProduct($id_product){
        global $conn;

        // Query to remove certain product from database
        $query = "delete from chuteiras where id_product = '".$id_product."'";

        // Execute query
        $result = pg_exec($conn, $query);
		return $result;
    }

    function updateIncreasedQuantity($id_product){
        global $conn;

        // Query to increase just 1 UNIT in quantity
        $query = "update chuteiras set quantity_available = quantity_available + 1 where id_product='". $id_product . "'";

        // Execute query
        $result = pg_exec($conn, $query);
		return $result;
    }

    function updateDecreasedQuantity($id_product){
        global $conn;

        // Query to decrease just 1 UNIT in quantity
        $query = "update chuteiras set quantity_available = quantity_available - 1 where id_product='". $id_product . "' and quantity_available > '0'";

        // Execute query
        $result = pg_exec($conn, $query);
		return $result;
    }

    function getProductDetails($id_product){
        global $conn;

        //explicar a query
        $query = "select * from chuteiras where id_product='". $id_product."'";

        // Execute query
        $result = pg_exec($conn, $query);
        return $result;
    }

    function registerProduct($idproduct, $name, $price, $description, $brand,$type, $picture, $quantity){
        global $conn;

        // Formulate query with camps inserted by website visitor
        $query = "insert into chuteiras (id_product, product_name, price, product_brand, product_type, image_path, quantity_available";
        if($description != NULL){
            $query .= ", description) values ('".$idproduct."', '".$name."', $price, '".$brand."', '".$type."', '".$picture."', $quantity, '".$description."');";
        }
        else{
            $query .= ") values ('".$idproduct."', '".$name."', '".$price."', '".$brand."', '".$type."', '".$picture."', $quantity);";
        }
        echo $query;
        $result = pg_exec($conn, $query);
        return $result;
    }
?>