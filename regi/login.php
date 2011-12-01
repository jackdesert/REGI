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

    if ($event_id <> '' && SECisUserLoggedIn($PASS_HMAC_SECRET_CODE)) {
        header("Location: ./".$event_id);
        exit(0);
    }elseif($event_id == '' && SECisUserLoggedIn($PASS_HMAC_SECRET_CODE)) {
        header("Location: ./");
        exit(0);
    }

    if (isset($_GET['admin_event_id']))
        $admin_event_id=$_GET['admin_event_id'];
    else
        $admin_event_id='';

    if ($admin_event_id <> '' && SECisUserLoggedIn($PASS_HMAC_SECRET_CODE)) {
        header("Location: ./".$admin_event_id."~admin");
        exit(0);
    }
    CHUNKgivehead();
    CHUNKstartbody();
    UTILbuildmenu(5);
    CHUNKstylemessage($_SESSION);

?>


   <div style="padding-left:20px; width:90%;">
<div style='float: left; width: 60%;'>

<h1>With REGI, it's easy to register for multiple AMC events</h1>
<ul>

<li>Enter your profile and contact information only once</li>
<li>Use your profile to register for as many events as you want</li>
<li>Once approved for an event, arrange carpooling with other approved participants</li>
<li>View up-to-date event information online</li>
</ul>
</div>
<div style='float: right; width: 30%;'>

<h2>Please login here:</h2>

<form name='login' action='action.php' method='post'>
    <table>
    <tr>
    <td class='slim'><b>Username</b></td>
    <td class='slim'><input type='text' name='user_name' value='' size=15 MAXLENGTH='50' autofocus='autofocus'></td>
    </tr><tr>
    <td class='slim'><b>Password</b></td>
    <td class='slim'><input type='password' maxlength='20' name='user_password' value='' size=15></td>

    </tr>
    <tr><td class='slim' colspan='2' style='text-align:right;'><input type='checkbox' name='use_cookie' value='checked' checked='checked'>Stay Signed In
    <input type='submit' style='margin:0;' class='button' name='action' value='login' onclick='return checkLogin()'>
    </td></tr></table>
    <input type='hidden' name='event_id' value='<?php print $event_id; ?>'>
    <input type='hidden' name='admin_event_id' value='<?php print $admin_event_id; ?>'>


</form>

<br><a href="myProfile" >Create an Account</a>
<br><a href="forgotPassword">Forgot Username or Password</a>
<br><a href="support"> Get Support</a>
<p> </p>
</div>

<div id='not_sure_why_this_div_is_here'>&nbsp;
<?php CHUNKfinishcontent(); ?>

