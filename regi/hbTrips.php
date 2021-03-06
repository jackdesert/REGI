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
    SECisUserLoggedIn($PASS_HMAC_SECRET_CODE);
    UTILbuildmenu(0);
    CHUNKstylemessage($_SESSION);
    CHUNKstartcontent();
?>

<h1>HB Trip Listings From Inside REGI</h1>
<p class='colored_note'>To view these same trips on the main site, <a href='http://hbbostonamc.org/trips.php'>click here</a>.</p>
<br><hr>
<?php
    CHUNKtriplistings();

?>

<br><br>
</div>
<?php CHUNKfinishcontent(); ?>

