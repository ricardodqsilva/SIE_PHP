<?PHP
    session_save_path('C:\data');
    session_start();                    // Session start to get session variables of current version
    $previous_page = $_SESSION['page']; // Get previous page accessed
    session_destroy();                  // Detroy current session - erase all session variables

    // Go to the previous page
    if($previous_page == "orders")
        header('Location: ../pages/store.php');
    else
        header('Location: ../pages/'.$previous_page.'.php');
?>