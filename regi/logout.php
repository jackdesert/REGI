<?php

    include 'utils.php';
    session_start();

    $_SESSION = array();    // This removes all session vars.
    session_destroy();
    SECdestroyCookie();     // This removes the cookie
    header("Location: ./login.php");
    exit();

?>
