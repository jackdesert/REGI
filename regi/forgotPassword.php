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
    UTILbuildmenu(5);
    //if (isset($_SESSION['Smessage']))
    //    CHUNKstylemessage($_SESSION['Smessage']);

    CHUNKstylemessage($_SESSION);


    CHUNKstartcontent();
?>

<form name='account_help' action='action.php' method='post'>

<h1>I Forgot my User Name or my Password</h1>
Enter your email address below. Then select either "Send Username"
to be emailed your username, or "Reset Password" to receive an email link for resetting your password.
<br><br>
    <table style='margin: auto;'><tr><td></td>
    <td><b>Your Email Address:<br><input type='email' name='email' value='' MAXLENGTH=40 autofocus='autofocus' required='required'></b></td>
    <td></td>
    </tr>
    <tr>
    <td><input type='submit' class='button' name='action' value='Send Username' title='Remind me what my user name is.' onclick=""></td>
    <td></td>
    <td><input type='submit' class='button' name='action' value='Reset Password' title='Email me a link to reset my password.' onclick=""></td>
    </tr></table>
</form>


<?php CHUNKfinishcontent(); ?>


