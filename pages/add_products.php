<?php
    session_save_path('C:\data');
    session_start();
    $_SESSION['page'] = "add_products";

    include('../includes/opendb.php');
    include('common/header.php');
?>


<?php    if($admin_permissions){
?>

<form method="post" action="../actions/action_addProduct.php<?php if(isset($_GET['previous_page'])) echo "?previous_page=".$_GET['previous_page']; ?>">
    <div class="loginDiv" style="left: 962px; top: 122px; height: 112px;">
        <p style="font-weight: normal;margin-block-start: 0px;margin-block-end: 0px;font-size: 12px;line-height: 12px;">(campos obrigatórios: *)</p>
        <p>Nome do Produto*:</p>
        <input class="login_camps" type="text" name="add_productname" required/>
    </div>
    <div class="loginDiv" style="left: 962px; top: 234px">
        <p>Referência*:</p>
        <input class="login_camps" type="text" name="add_idproduct" required/>
    </div>
    <div class="loginDiv" style="left: 962px; top: 334px">
        <p>Preço*:</p>
        <input class="login_camps" type="number" name="add_productprice" required/>
    </div>
    <div class="loginDiv" style="left: 962px; top: 434px">
        <p>Marca*:</p>
        <input class="login_camps" type="text" name="add_brand" required/>
    </div>
    <div class="loginDiv" style="left: 962px; top: 534px">
        <p>Tipo de Sola*:</p>
        <input class="login_camps" type="text" name="add_producttype" required/>
    </div>
    <div class="loginDiv" style="left: 962px; top: 634px">
        <p>Descrição Técnica:</p>
        <input class="login_camps" type="text" name="add_description"/>
    </div>
    <div class="loginDiv" style="left: 962px; top: 734px">
        <p>Fotografia*:</p>
        <input class="login_camps" type="file" name="add_picture" required/>
    </div>
    <div class="loginDiv" style="left: 962px; top: 834px">
        <p>Disponibilidade*:</p>
        <input class="login_camps" type="number" name="add_quantity" required/>
    </div>
    <!-- ERROR MESSAGES RELATED TO REGISTRATION -->
    <div id="registerDivErrors">
        <?php 
            if(isset($_GET['error_register'])){
                switch ($_GET['error_register']) {
                    case '1':
                        echo "<p>( Dados de registo não válidos. )</p>";
                        break;
                    case '2':
                        echo "<p>( Campos obrigatórios não estão todos preenchidos. )</p>";
                        break;
                    case '3':
                        echo "<p>( Nome de utilizador já existe. Por favor insira outro. )</p>";
                        break;
                    default:
                        echo "<p>( !!! Erro desconhecido !!! )</p>";
                }
            }
        ?>
    </div>
    <!-- BUTTON TO REGISTER -->
    <div class="registerDivButton" style="top: 974px">
        <input style="margin-bottom:100px;" class="login_buttons" type="submit" value="Inserir">
    </div>
</form>

<?php
    }
    else{
        echo "<p>&nbsp&nbsp Não tem permissões para aceder a esta página.</p>";
    }

?>

<?php
    include('common/footer.php');
    include('../includes/closedb.php');
?>