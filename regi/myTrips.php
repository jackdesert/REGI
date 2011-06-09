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
    <title>AMC Event Registration</title>
    <meta http-equiv="Content-Type" content="text/html; charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <SCRIPT type="text/javascript" src="validation.js"></SCRIPT>

<link href="http://www.hbbostonamc.org/templates/amctemplate/template_css/template_2css.css" type="text/css" rel="stylesheet" />
</head>
<body>
<div id="pagewrap">
  <div id="layer10" onClick="location.href='http://www.hbbostonamc.org/index.php';" style="cursor:pointer;">
    <div id="searchbox">

<?php

    include 'utils.php';
    session_start();
    UTILdbconnect();

    UTILbuildmenu();
    if (isset($_SESSION['Smessage']))
        print "<b><font color='red'>$_SESSION[Smessage]</font></b>";

?>

    </div>
   </div>
   <div style="padding-left:20px; width:90%;">

<h1>My Trips</h1>

<?php

    if (!isset($_SESSION['Suser_id']))
    {
        // ERROR?

        $my_user_id='';
        $my_user_type='';

        header("Location: ./errorPage.php?errTitle=Authorization Error&errMsg=User Not Authorized to View this Profile");
        exit();
    }
    else
    {
        $my_user_id=$_SESSION['Suser_id'];
        $my_user_type=$_SESSION['Suser_type'];

        // Show all events I am connected with as: signed up/wait list, selected
        //   leader, or co-leader
        //

        $query = "select events.event_id, event_name, event_status, register_date,
                register_status, program_id
                FROM events, user_events
                WHERE events.event_id=user_events.event_id
                AND user_events.user_id=$my_user_id
                ORDER BY register_status ASC
                LIMIT 30;";

        $result = mysql_query($query);
        if (!$result) UTILdberror($query);

        $numrows = mysql_num_rows($result);
        if ($numrows < 1 && $my_user_type == 'USER')
        {
            print " <h3>Welcome!</h3>
                <h3>You have not yet signed up for any events.</h3>
                <h3>Please view trip listings and click the 'Register Online' link for the trip you are interested in.</h3>";
        }
        else if ($numrows < 1 && $my_user_type == 'LEADER')
        {
            print " <h3>Welcome AMC Leader!</h3>
                <h3>You have not created any trips on this registration system yet.</h3>
                <h3>Please click the 'New Event' menu option above to enter in your first trip.</h3>";
        }
        else
        {

            print"<table border=2><tr><td>Event</td><td>Registration Submitted</td><td>My Registration Status</td></tr>";
            while($row = mysql_fetch_assoc($result)) {

                print "<tr><td>$row[event_name]  [event status: $row[event_status] ]<br>";
                print "<a href=\"eventRegistration.php?event_id=$row[event_id]\" >";
                print "[REGISTRATION PAGE]</a>";

                if ($row['register_status']=='LEADER' || $row['register_status']=='CO-LEADER'
                    || $row['register_status']=='REGISTRAR') {
                    print " <a href=\"eventAdmin.php?event_id=$row[event_id]\" ><font color='red'> [ADMINISTRATION PAGE]</font></a>";
                }

                print "<td>".UTILtime($row['register_date'])."</td>";
                print "<td>$row[register_status]</td></tr>";

            }
            print "</table>";
        }

    }
?>

<br><br>
</div>
</body>
</html>
