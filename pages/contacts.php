<?php
    session_save_path('C:\data');
    session_start();
    $_SESSION['page'] = "contacts";

    include('../includes/opendb.php');
    include('common/header.php');
?>

<!---------------------------------------------->
<!---- Info about the author Ricardo Silva ----->
<!---------------------------------------------->
<div  class="flip-card">
  <div class="flip-card-inner">
    <div class="flip-card-front"><img src="../images/" alt="Author"></div>
    <div class="flip-card-back">
        Ricardo Silva
        <br>
        MEEC - Automação
        <br>
        Número de Telemóvel: 924055930
        <br>
        <a href="mailto:up201503004@fe.up.pt">up201806701@fe.up.pt</a>
    </div>
  </div>
</div>

<!------------------------------------------------>
<!---- Info about the author João Casal ----->
<!------------------------------------------------>
 <div class="flip-card" style="float: right;margin-top: -450px; margin-right: 340px;">
  <div class="flip-card-inner">
    <div class="flip-card-front" ><img src="../images/jc.png" alt="Author"></div> 
    <div class="flip-card-back">
        João Casal
        <br>
        MEEC - Automação
        <br>
        Número de Telemóvel: 917966804
        <br>
        <a href="mailto:up201708986@fe.up.pt">up201806187@fe.up.pt</a>
    </div>
  </div>
</div>

<?php
    include('common/footer.php');
    include('../includes/closedb.php');
?>