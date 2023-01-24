<?php
    // Make connection with PostgreSQL database
    $conn = pg_connect("host=db.fe.up.pt dbname=sie2243 user=sie2243 password=gAGiHDrh");
    if (!$conn)
    {
        print "Nao foi possivel estabelecer a ligacao";
        exit;
    }
    $query = "set schema 'projeto2';";	
    pg_exec($conn, $query);
?>