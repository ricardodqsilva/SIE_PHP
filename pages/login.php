<?php
    session_save_path('C:\data');
    session_start();
    $_SESSION['page'] = "login";

    include('../includes/opendb.php');
    include('common/header.php');
?>

<!---------------------------------------------->
<!------------------- LOGIN -------------------->
<!---------------------------------------------->
<form method="post" action="../actions/action_login.php<?php if(isset($_GET['previous_page'])) echo "?previous_page=".$_GET['previous_page']; ?>">
    <div class="loginDiv" style="left: 452px; top: 434px">
        <p>Nome de Utilizador:</p>
        <input class="login_camps" type="text" name="log_username" required/>
    </div>
    <div class="loginDiv" style="left: 452px; top: 534px">
        <p>Password:</p>
        <input class="login_camps" type="password" name="log_password" required/>
    </div>
    <!-- ERROR MESSAGES RELATED TO SESSION LOGIN -->
    <div id="loginDivErrors">
        <?php 
            if(isset($_GET['error_login'])){
                switch ($_GET['error_login']) {
                    case '1':
                        echo "<p>( Nome de Utilizador ou Password não definidas. )</p>";
                        break;
                    case '2':
                        echo "<p>( Nome de Utilizador ou Password inválidos. )</p>";
                        break;
                    default:
                        echo "<p>( !!! Erro desconhecido !!! )</p>";
                }
            }
        ?>
    </div>
    <!-- BUTTON TO LOGIN -->
    <div class="loginDivButton">
        <input class="login_buttons" type="submit" value="Iniciar Sessão">
    </div>
</form>

<div class="login_separationBar">&nbsp</div> <!-- Rule in HTML -->

<!------------------------------------------------->
<!------------------- REGISTER -------------------->
<!------------------------------------------------->
<form method="post" action="../actions/action_register.php<?php if(isset($_GET['previous_page'])) echo "?previous_page=".$_GET['previous_page']; ?>">
    <div class="loginDiv" style="left: 962px; top: 122px; height: 112px;">
        <p style="font-weight: normal;margin-block-start: 0px;margin-block-end: 0px;font-size: 12px;line-height: 12px;">(campos obrigatórios: *)</p>
        <p>Nome*:</p>
        <input class="login_camps" type="text" name="reg_completname" required/>
    </div>
    <div class="loginDiv" style="left: 962px; top: 234px">
        <p>Morada:</p>
        <input class="login_camps" type="text" name="reg_address"/>
    </div>
    <div class="loginDiv" style="left: 962px; top: 334px">
        <p>Nome de Utilizador*:</p>
        <input class="login_camps" type="text" name="reg_username" required/>
    </div>
    <div class="loginDiv" style="left: 962px; top: 434px">
        <p>Endereço Eletrónico*:</p>
        <input class="login_camps" type="email" name="reg_email" required/>
    </div>
    <div class="loginDiv" style="left: 962px; top: 534px">
        <p>Password*:</p>
        <input class="login_camps" type="password" name="reg_password" required/>
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
    <div class="registerDivButton">
        <input class="login_buttons" type="submit" value="Registar">
    </div>
</form>

<?php
    include('common/footer.php');
    include('../includes/closedb.php');
?>