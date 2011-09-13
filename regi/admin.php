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


    if (SECisUserLoggedIn($SET_HMAC_SECRET_CODE)) {
        $my_user_id = $_SESSION['Suser_id'];
        $user_type = $_SESSION['Suser_type'];
    } else {
        $_SESSION['Smessage'] = 'Please Log In';
        header("Location: ./login.php?event_id={$event_id}");
        //print "<p>You must be logged in to register for an event.</p><p>If you do not have an account, you may create a new account <a href='myProfile.php' >here</a>.<br>";
        exit();
    }

    // Only admins can view this page
    if ($_SESSION['Suser_type'] != "ADMIN"){
        $_SESSION['Smessage'] = "Only admins can view that page.<br>Redirecting";
        header("Location: ./myEvents");
        exit();
    }



        $query = "SELECT first_name, last_name, email, user_id, leader_request FROM users WHERE leader_request = true";

        $result = mysql_query($query);
        if (!$result) UTILdberror($query);
        CHUNKgivehead();
        CHUNKstartbody();
        UTILbuildmenu(3);
        CHUNKstylemessage($_SESSION);

        CHUNKstartcontent('','','');

        $numrows = mysql_num_rows($result);
        if ($numrows > 0) {
            $row = mysql_fetch_assoc($result);
            $first_name=$row['first_name'];
            $last_name=$row['last_name'];
            $leader_id = $row['user_id'];
            print_r ($row);
        }

CHUNKfinishcontent();
