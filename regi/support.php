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
This is a placeholder for Question and Answer as well as a REGI user guide (coming soon).
<h2>Email Support</h2>
You can <a class='menu' href='mailto:amcbostonhbs@gmail.com?subject=Help%20With%20REGI%20Site' >email the webmaster</a> for help.

<h2>Q &amp; A</h2>

Q:<br>
A:<br>


<?php CHUNKfinishcontent(); ?>

