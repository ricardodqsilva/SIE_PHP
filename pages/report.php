<?php
    session_save_path('C:\data');
    session_start();
    $_SESSION['page'] = "report";

    include('../includes/opendb.php');
    include('common/header.php');
?>

<div class="">
    <a href="../css/stylesheet.css" download target="_blank"><img class="img_css" src="../images/icons/css.png"></a>
    <a href="../SIE-TP2_RicardoSilva+JoaoCasal.zip" download><img class="img_zip" img src="../images/icons/zip.png"></a>
    <a href="../SIE-TP2_RicardoSilva+JoaoCasal_Mockup.pptx" download><img class="img_ppt" img src="../images/icons/ppt.png"></a>
</div>

<?php
    include('common/footer.php');
    include('../includes/closedb.php');
?>