<?php
    // Global Settings
    // Note that you must declare these 'global' inside any function you wish to use them in.
    // However, to use them somewhere OUTSIDE a function, no such declaration is necessary
    // Database
    //

    include 'passwords/regi_passwords.php';

    // Mandatory Questions
    $SET_QUESTION_1     = "Do you have the required gear? If you are missing any required <br>gear, please list it below. We can help if you have questions.";
    $SET_QUESTION_2     = "Do you have any questions or comments for us?";


    // Upload files / Images
    //

    $SET_MAX_PHOTO_LEN  = 30000;
    $SET_MAX_FIGURE_LEN = 30000;

    // For windows, use back slashes
    //$SET_IMG_FILE_DIR     = ".\\image_files\\";
    // For unix/linux, use forward slashes
    $SET_IMG_FILE_DIR       = "./image_files/";

    // The admin email gets notified when somebody creates an account and requests to be a leader
    $SET_ADMIN_EMAIL = array("amcbostonhbs@gmail.com" => "REGI Admin", "jackdesert556@gmail.com" => "Jack Desert");
    //$SET_ADMIN_EMAIL = "<jackdesert556@gmail.com>";

    // The support email receives mail when people write to support.
    $SET_SUPPORT_MAILTO = "amcbostonhbs@gmail.com";

    $SET_OUTDOORS_LINK = "http://activities.outdoors.org/admin";
/*Note there is purposefully no closing php tag here, because
if you accidentally put extra characters (even line breaks)
after a closing php tag, you will get a warning when this
file is included in another file. Such a warning can wreak
havoc when the warning ends up inside an Excel export. (It's
gibberish. So I'm removing this closing tag */

