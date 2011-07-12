<?php

    include 'utils.php';
    session_start();
    $_SESSION['Smessage'] = "Good bye, $_SESSION[Sfirst_name], you are now logged off.";
    //UTILdbconnect();

    unset($_SESSION['Suser_id']);
    unset($_SESSION['Sfirst_name']);
    unset($_SESSION['Suser_type']);

    unset($_SESSION['Sviewable_users']);

    session_unset();
    session_destroy();
    SECdestroyCookie();
    header("Location: ./login.php");
    exit();

?>
