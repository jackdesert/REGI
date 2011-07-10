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

    if (isset($_GET['event_id']))
        $event_id=$_GET['event_id'];
    else
        $event_id='';

    if ($event_id <> '' && isset($_SESSION['Suser_id'])) {
        header("Location: ./eventRegistration.php?event_id=".$event_id);
        exit(0);
    }elseif($event_id == '' && isset($_SESSION['Suser_id'])) {
        header("Location: ./myTrips.php");
        exit(0);
    }

    if (isset($_GET['admin_event_id']))
        $admin_event_id=$_GET['admin_event_id'];
    else
        $admin_event_id='';

    if ($admin_event_id <> '' && isset($_SESSION['Suser_id'])) {
        header("Location: ./eventAdmin.php?event_id=".$admin_event_id);
        exit(0);
    }
    CHUNKgivehead();
    CHUNKstartbody();
    UTILbuildmenu(5);
    CHUNKstylemessage($_SESSION);

?>


   <div style="padding-left:20px; width:90%;">
<ul>
<h4>Now it's much easier to register for H/B events: </h4>
<li>Enter your profile and contact information only once</li>
<li>Manage your event registration information and status online</li>
<h4>Once approved for an event:</h4>
<li>View up-to-date event information online</li>
<li>View carpool &amp; contact information of other participants</li>
</ul> <br>
<h2>Please login here:</h2>

<form name='login' action='action.php' method='post'>
    <table>
    <tr>
    <td><b>User Name</b></td>
    <td><input type='text' name='user_name' value='' MAXLENGTH=50 autofocus='autofocus'></td>
    </tr><tr>
    <td><b>Password</b></td>
    <td><input type='password' name='user_password' value='' MAXLENGTH=20></td>

    <div style="display:none">
        HIDDEN FIELDS
    </div>

    </tr></table>
    <input type='hidden' name='event_id' value='<?php print $event_id; ?>'>
    <input type='hidden' name='admin_event_id' value='<?php print $admin_event_id; ?>'>
    <input type='submit' class='button' name='action' value='login' onclick='return checkLogin()'>
</form>

<br><b>Don't have an account? </b><a href="myProfile.php?event_id=<?php print $event_id; ?>" >Create an account here</a>
<br><br>
<b>Forgot your user name or password? </b><a href="forgotPassword.php">Click here</a>

<br><br><b>Need more support?</b>
<a href="support.php"> View our Support Page</a>
<p></p>

<?php CHUNKfinishcontent(); ?>

