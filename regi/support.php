<?php
/*
    AMC Event Registration System
    Copyright (C) 2010 Dirk Koechner
    Copyright (C) 2011 Jack Desert <jackdesert556@gmail.com>>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, version 3 of the License.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    For a copy of the GNU General Public License, please refer to
    <http://www.gnu.org/licenses/>.

*/

    include 'utils.php';
    session_start();
    UTILdbconnect();
    CHUNKgivehead();
    CHUNKstartbody();
    //Check cookie before building menu
    SECisUserLoggedIn($SET_HMAC_SECRET_CODE);
    UTILbuildmenu(1);
    CHUNKstylemessage($_SESSION);

?>


<?php CHUNKstartcontent(); ?>
<h1>Support</h1>
This is where you can get help using the REGI system.
<h2>User Guides</h2>
<a href='guides/AMCBostonHBOnlineEventRegSystem-UserGuide.pdf'>User Guide</a><br>
<?php
    if (isset($_SESSION['Suser_type']))
        if ($_SESSION['Suser_type'] != 'USER')
            print "<a href='guides/AMCBostonHBOnlineEventRegSystem-LeaderGuide.pdf'>Leader Guide</a><br>";
?>
<h2>Email Support</h2>
You can <a class='menu' href='mailto:amcbostonhbs@gmail.com?subject=Help%20With%20REGI%20Site' >email the webmaster</a> for help.

<h2>Frequently Asked Questions</h2>
<?php
    //The REGI FAQ is in LyX format, which makes for easy editing
    //To generate html from it, use elyxer
    print "<div class='width_60'>";
    $faq = system('python elyxer/elyxer.py --raw guides/Regi_FAQ.lyx');
    print $faq;
    print "</div>";
?>


<?php CHUNKfinishcontent(); ?>

