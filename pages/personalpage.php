<?php   
    session_save_path('C:\data');
    session_start();
    $_SESSION['page'] = "personalpage";

    include('../includes/opendb.php');
    include('common/header.php');

    include_once('../database/login.php');
?>

<?php

    $username = $_GET['username'];

    $result = getUserDetails($username);

    $row = pg_fetch_assoc($result);



    echo "<div style=\"margin-left: 410px; flex-direction: column;\" class=\"flex-container\">";
    

    if($authenticated){
        echo    "<h1 style=\"margin-top: 0px;\">Informações da Conta</h1>";
        echo    "<h3><i>Nome de Utilizador: </i><span>" . $row['username']."</span></h3>";
        echo    "<h3><i>Nome: </i><span>" . $row['name']."</span></h3>";
        echo    "<h3><i>Morada: </i><span>" . $row['adress']."</span></h3>";
        echo    "<h3><i>E-mail: </i><span>" . $row['email']."</span></h3>";
    }
    else echo "Não tem permissões para aceder a esta página.";

    echo "</div>";
    

?>



<div class="flex-container-menu">
    <div style="background-color:rgb(75,75,75); text-decoration:none"><a href="orders.php">Página Pessoal</a></div>
    <div style="text-decoration:none;"><a href="management_products.php">Minhas Encomendas</a></div>
</div>

<?php
    include('common/footer.php');
    include('../includes/closedb.php');
?>