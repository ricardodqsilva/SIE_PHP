<?php
/***********************************************
 ***** CHECK AUTHENTICATION (IN ALL PAGES) *****
 ***********************************************/
    $authenticated = false;
    $admin_permissions = false;
    $username = NULL;
    if( !isset( $_SESSION['authenticated'] ) ){ 	/* If session variable AUTHENTICATED is not defined, then the client didn't authenticated until the moment */
        $_SESSION['authenticated'] = false;
    }
    else{                                           /* Else, gets the logged client's info in POST and gets other necessary information by DB queries, if authenticated! */
        if( $_SESSION['authenticated'] ){           /* If authenticated... */
            if( isset( $_SESSION['username'] ) ){
                $username = $_SESSION['username'];
                $authenticated = true;
            }
            else{
                $_SESSION['authenticated'] = false; /* The 2 session variables must be defined to the authetication mechanism be valid */
            }
        }
    }
    if( !isset( $_SESSION['admin'] ) ){             /* If session variable ADMIN is not defined, then the client don't have admin permissions */
        $_SESSION['admin'] = false;
    }
    else{                                           /* If session variable ADMIN is defined, then save permissions in auxiliar variable */
        $admin_permissions = $_SESSION['admin'];
    }
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <title>Loja de Chuteiras</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/stylesheet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.google.com/?query=Trebuchet+MS">
    <link rel="icon" href="../images/icons/football-boots.png" type="image/x-icon" />
    <script src="../js/main.js"></script>
</head>

<body>

<!----------------------------------------------------------->
<!------------------- TOP NAVIGATION BAR -------------------->
<!----------------------------------------------------------->
<div class="topnav">

    <!-- CURRENT PAGE: store -->

    <?php if($_SESSION['page'] == "store"){ ?>
        <div class="active"><a href="../pages/store.php"><b>Loja</b></a></div>
    <?php } ?>
    <?php if(!($_SESSION['page'] == "store")){ ?>
        <div><a href="../pages/store.php"><b>Loja</b></a></div>
    <?php } ?>

    <!-- CURRENT PAGE: orders -->

    <?php if($admin_permissions){if($_SESSION['page'] == ("orders") OR $_SESSION['page'] == ("management_products")){ ?>
        <div class="active"><a href="../pages/orders.php"><b>Gestão</b></a></div>
    <?php } ?>
    <?php if(!($_SESSION['page'] == ("orders") OR $_SESSION['page'] == ("management_products"))){ ?>
        <div><a href="../pages/orders.php"><b>Gestão</b></a></div>
    <?php }} ?>

    <!-- CURRENT PAGE: contacts -->

    <?php if($_SESSION['page'] == "contacts"){ ?>
        <div class="active"><a href="../pages/contacts.php"><b>Sobre Nós</b></a></div>
    <?php } ?>
    <?php if(!($_SESSION['page'] == "contacts")){ ?>
        <div><a href="../pages/contacts.php"><b>Sobre Nós</b></a></div>
    <?php } ?>

    <!-- CURRENT PAGE: report -->

    <?php if($_SESSION['page'] == "report"){ ?>
        <div class="active"><a href="../pages/report.php"><b>Transferências</b></a></div>
    <?php } ?>
    <?php if(!($_SESSION['page'] == "report")){ ?>
        <div><a href="../pages/report.php"><b>Transferências</b></a></div>
    <?php } ?>

    <!-- CURRENT PAGE: search box -->

    <?php if($_SESSION['page'] == "store"){ ?>
    <form action="../pages/store.php" method="get">
    <div class="div_search_bar nohover">
        <button type="submit"><i class="fa fa-search"></i></button>
        <input class="search_bar" type="text" value="<?php if(!empty($searchWords)){echo $searchWords;}?>" name="search" placeholder="Procurar...">
    </div>
    </form><?php } ?>

    <!-- CURRENT PAGE: login -->

    <?php if(!$_SESSION['authenticated']){ ?>    <!-- If NOT AUTHENTICATHED: show LOGIN -->
        <?php if($_SESSION['page'] == "login"){ ?>
            <div class="active" style="float: right"><a href="../pages/login.php?<?php echo "previous_page=".$_SESSION['page']; ?>"><b>Iniciar Sessão</b></a></div>
        <?php } ?>
        <?php if(!($_SESSION['page'] == "login")){ ?>
            <div style="float: right"><a href="../pages/login.php?<?php echo "previous_page=".$_SESSION['page']; ?>"><b>Iniciar Sessão</b></a></div>
        <?php } ?>
    <?php } ?>
    <?php if($_SESSION['authenticated']){ ?>     <!-- If AUTHENTICATHED: show LOGOUT -->
        <?php if($_SESSION['page'] == "login"){ ?>
            <div class="active" style="float: right"><a href="../actions/action_logout.php"><b>Encerrar Sessão</b></a></div>
        <?php } ?>
        <?php if(!($_SESSION['page'] == "login")){ ?>
            <div style="float: right"><a href="../actions/action_logout.php"><b>Encerrar Sessão</b></a></div>
        <?php } ?>
    <?php } ?>

    <!-- CURRENT PAGE: shoppcart -->

    <?php if($_SESSION['page'] == "shoppcart" && (!$authenticated)){ ?>
        <div class="active" style="float: right"><a class="a_shoppct" onclick="show_authenticationAlert()"><img class="shoppct_active" src="../images/shopping_cart.png"></a></div>
    <?php } ?>
    <?php if($_SESSION['page'] == "shoppcart" && ($authenticated)){ ?>
        <div class="active" style="float: right"><a class="a_shoppct" href="../pages/shoppcart.php"><img class="shoppct_active" src="../images/shopping_cart.png"></a></div>
    <?php } ?>
    <?php if(!($_SESSION['page'] == "shoppcart") && (!$authenticated)){ ?>
        <div style="float: right"><a class="a_shoppct" onclick="show_authenticationAlert()"><img class="shoppct" src="../images/shopping_cart.png"></a></a></div>
    <?php } ?>
    <?php if(!($_SESSION['page'] == "shoppcart") && ($authenticated)){ ?>
        <div style="float: right"><a class="a_shoppct" href="../pages/shoppcart.php"><img class="shoppct" src="../images/shopping_cart.png"></a></a></div>
    <?php } ?>

    <!-- SHOW username OR user's complet name -->

    <?php if($_SESSION['authenticated'])        /*** If AUTHENTICATHED: show username OR user's complet name ***/
        if(isset($_SESSION['name_user'])){
            echo "<a class=\"userhello\" style=\"padding-top:0px;\" href=\"../pages/personalpage.php?username=".$username."\"><div class=\"userhello\" style=\"float: right\">Olá, ". $_SESSION['name_user'] . "</div></a>";
        }
        else{
            echo "<div class=\"userhello\" style=\"float: right\"><b>Olá, ". $username . "</b></div>";
        }
    ?>
</div>