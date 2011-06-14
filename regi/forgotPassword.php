<!--

    AMC Trip Registration System
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
    if (isset($_SESSION['Smessage']))
        CHUNKstylemessage($_SESSION['Smessage']);
?>

    </div>
   </div>

   <div style="padding-left:20px; width:90%;">

<h2>Send My Password</h2>

If you have forgotten your password, enter your user name below and you will be sent an email with your current password.
We recommend changing your password when you login again by editing your profile.<br><br>

<form name='info' action='action.php' method='post'>
    <table><tr>
    <td><b>Enter User Name:</b></td>
    <td><input type='text' name='user_name' value='' MAXLENGTH=50></td>
    </tr></table>
    <input type='submit' name='action' value='Send My Password' onclick='return checkSendPassword()'>
</form>
<br>

<h2>Send My Account Info</h2>

If you have forgotten your user name, please enter the email address of your account below and you will be sent an email with your current login information.
We recommend changing your password when you log in again by editing your profile.<br><br>

<form name='info' action='action.php' method='post'>
    <table><tr>
    <td><b>Enter  Account Email:</b></td>
    <td><input type='text' name='email' value='' MAXLENGTH=40></td>
    </tr></table>
    <input type='submit' name='action' value='Send My Account Info' onclick='return checkSendPassword()'>
</form>
<p><br>

</div>
</body>
</html>
