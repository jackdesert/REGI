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

    // SECURITY
    // - User must be logged in

    if (isset($_GET['event_id']))
        $event_id = $_GET['event_id'];
    else
        $event_id = '';

    if (SECisUserLoggedIn($SET_HMAC_SECRET_CODE)) {
        $my_user_id = $_SESSION['Suser_id'];
        $user_type = $_SESSION['Suser_type'];
    } else {
        $_SESSION['Smessage'] = 'Please Log In';
        header("Location: ./login.php?event_id={$event_id}");
        //print "<p>You must be logged in to register for an event.</p><p>If you do not have an account, you may create a new account <a href='myProfile.php' >here</a>.<br>";
        exit();
    }


     CHUNKgivehead();
     CHUNKstartbody();


        // Get event summary info
        //

        $query = "select event_name, event_status, event_is_program, program_id, description, gear_list, trip_info, confirmation_page, question1, start_date, end_date, pricing, rating
                FROM events
                WHERE event_id=$event_id;";

        $result = mysql_query($query);
        if (!$result) UTILdberror($query);

        $numrows = mysql_num_rows($result);
        if ($numrows <> 1) {
            print "<p>ERROR: Can not retrieve event from database.</p>";
            exit();
        } else {
            $row = mysql_fetch_assoc($result);
            $event_name=$row['event_name'];
            $event_is_program=$row['event_is_program'];
            $description=$row['description'];
            $gear_list=$row['gear_list'];
            $start_date=$row['start_date'];
            $end_date=$row['end_date'];
            $pricing=$row['pricing'];
            $rating=$row['rating'];

            if ($start_date == "0000-00-00") //This accounts for the events that were created with this date when
                $start_date = '';           //the start_date field was added to the database.

        }




    UTILbuildmenu(3);
    CHUNKstylemessage($_SESSION);

    CHUNKstartcontent($my_user_id, $event_id, 'share');
    CHUNKshowtripname($event_id);

    print "<h1>Thank Yor for Making a REGI Page</h1>";
    print "<p>Congratulations, your Registration Page has been created. This page allows you to keep track of who's signing up for your event. Now, let's post your event so people can sign up for it!</p>";
    print "<h1>Post your REGI page with your Trip Listing:</h1>";
    print "<ol><li>Log in to <a href = '$SET_OUTDOORS_LINK'>$SET_OUTDOORS_LINK</a>. </li>";
    print "<li>Click on the link in the side bar under <em>Events</em> that says <em>Add Chapter Trip</em>.</li>";
    print "<li>Below are the details of your event. Copy and paste them into your listing.</li>";
    print "</ol>";
    print "<div style = 'margin-left: 8%'>";

    $event_url = 'http://hbbostonamc.org/regi/' . $event_id;
    print "<b>Registration URL:&nbsp;&nbsp;<a href='$event_url'>$event_url</a></b><br>";
    if ($end_date){
        $date_label = "Start Date";
    }else{
        $date_label = "Date";
    }
    print $end_date;

?>
    <span style="font-weight: bold">Event Name:</span> &nbsp; <?php print $event_name; ?>

    <table style='border-collapse:separate;border-spacing:4ex 1ex;'>
        <tr>
            <td>
                <span style="font-weight: bold"><?php print $date_label;?>:</span> <br><?php print UTIL_date_prettify($start_date); ?>

            </td>

<?php
    if ($end_date){
        $printed_end_date = UTIL_date_prettify($end_date);
        print "<td><span style='font-weight: bold'>End Date:</span><br>$printed_end_date</td>";
        }
?>
        </tr></table>


    <span style="font-weight: bold">Hike Rating:</span> <?php print $rating; ?><br><br>



    <span style="font-weight: bold">Cost:</span> <?php print $pricing; ?><br><br>


    <span style="font-weight: bold">General Description:</span><br>
    <?php print $description; ?><br><br>


    <span style="font-weight: bold">Gear List</span>
    <?php print $gear_list; ?>
</div>
<h1>View Your Trip</h1>
<p>Once your event is posted on outdoors.org, you will be able to view it at <a href='hbTrips'>HB Trip Listings </a>. </p>

<?php CHUNKfinishcontent(); ?>

<?php

    if ($event_id == '')
        exit(0);

