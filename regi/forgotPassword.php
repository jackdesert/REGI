<!--

    AMC Event Registration System
    Copyright (C) 2010 Dirk Koechner

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, version 3 of the License.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    For a copy of the GNU General Public License, please refer to
    <http://www.gnu.org/licenses/>.

-->


<?php

    include 'utils.php';
    session_start();
    UTILdbconnect();
    CHUNKgivehead();
    CHUNKstartbody();
    UTILbuildmenu();
    //if (isset($_SESSION['Smessage']))
    //    CHUNKstylemessage($_SESSION['Smessage']);

    CHUNKstylemessage($_SESSION['Smessage']);
    unset($_SESSION['Smessage']);

    CHUNKstartcontent();
?>

<form name='account_help' action='action.php' method='post'>

<h1>Help with forgotten usernames and passwords</h1>
If you have forgotten your username or password, enter your email address below and select either "Username Reminder"
to be emailed your username, or "Reset Password" to receive and email link for resetting your password.
<br><br>
    <table><tr>
    <td><b>Email:</b></td>
    <td><input type='email' name='email' value='' MAXLENGTH=40></td>
    </tr>
    <tr>
    <td><input type='submit' name='action' value='Send Username' onclick=""></td>
    <td><input type='submit' name='action' value='Reset Password' onclick=""></td>
    </tr></table>
</form>


<?php CHUNKfinishcontent(); ?>

</body>
</html>
