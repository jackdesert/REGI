<?php

    include 'utils.php';

    // Start session
    session_start();

    // Connect to Database
    //
    UTILdbconnect();
    print "connected";


    UTIL_gen_all_passhashes();
    print "done";
?>
