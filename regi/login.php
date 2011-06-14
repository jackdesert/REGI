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

<html>
<head>
<link rel="shortcut icon" href="favicon.ico">
<link rel="icon" type="image/gif"
    <title>AMC Event Registration</title>
    <meta http-equiv="Content-Type" content="text/html; charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <SCRIPT type="text/javascript" src="validation.js"></SCRIPT>

<link href="http://www.hbbostonamc.org/templates/amctemplate/template_css/template_2css.css" type="text/css" rel="stylesheet" />
</head>
<body>
<div id="pagewrap">
  <div id="layer10" onClick="location.href='http://www.hbbostonamc.org/index.php';" style="cursor:pointer;">

<?php

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
    }

    if (isset($_GET['admin_event_id']))
        $admin_event_id=$_GET['admin_event_id'];
    else
        $admin_event_id='';

    if ($admin_event_id <> '' && isset($_SESSION['Suser_id'])) {
        header("Location: ./eventAdmin.php?event_id=".$admin_event_id);
        exit(0);
    }

    UTILbuildmenu();
    if (isset($_SESSION['Smessage']))
        print "<font color='red'>".$_SESSION['Smessage']."</font>";

?>

    </div>
   </div>
   <div style="padding-left:20px; width:90%;">
<ul>
<h4>Now it's much easier to register for H/B trips: </h4>
<li>Enter your profile and contact information only once</li>
<li>Manage your trip registration information and status online</li>
<h4>Once approved for a trip:</h4>
<li>View up-to-date trip information online</li>
<li>View carpool &amp; contact information of other participants</li>
</ul> <br>
<h2>To register, please login below:</h2>

<form name='info' action='action.php' method='post'>
    <table>
    <tr>
    <td><b>User Name</b></td>
    <td><input type='text' name='user_name' value='' MAXLENGTH=50></td>
    </tr><tr>
    <td><b>Password</b></td>
    <td><input type='password' name='user_password' value='' MAXLENGTH=20></td>

    <div style="display:none">
        HIDDEN FIELDS
    </div>

    </tr></table>
    <input type='hidden' name='event_id' value='<?php print $event_id; ?>'>
    <input type='hidden' name='admin_event_id' value='<?php print $admin_event_id; ?>'>
    <input type='submit' name='action' value='login' onclick='return checkLogin()'>
</form>

Don't have an account? <a href="myProfile.php?event_id=<?php print $event_id; ?>" >Create an account here &gt;</a>
<br>
Forgot your password? <a href="forgotPassword.php">Click here &gt;</a>

<br><br>
<a href="mailto:amcbostonhbs@gmail.com"><strong>Need more support? Contact us &gt; </strong></a>
<p></p>


</div>
</div>

</body>
</html>
