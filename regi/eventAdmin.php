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

    if (SECisUserLoggedIn($PASS_HMAC_SECRET_CODE)) {
        $my_user_id = $_SESSION['Suser_id'];
        $user_type = $_SESSION['Suser_type'];
    } else {
        $_SESSION['Smessage'] = 'Please Log In';
        header("Location: ./login.php?event_id={$event_id}");
        //print "<p>You must be logged in to register for an event.</p><p>If you do not have an account, you may create a new account <a href='myProfile.php' >here</a>.<br>";
        exit();
    }

    $submitValue='Create New Event';
    $event_name='';
    $event_status='OPEN';
    $event_is_program='N';
    $event_is_programY='';
    $event_is_programP='';
    $event_is_programN='';
    $description='';
    $gear_list='';
    $trip_info='';
    $confirmation_page='Thank you for registering. An event leader will be in contact with you soon regarding your participation in this event.';
    $question1='';

    $program_id='';
    $program_name='';


    if ($event_id == ''){
        // Only user_type  of Leader, Coleader, or Admin can create a new trip

        if ($_SESSION['Suser_type'] <> 'LEADER' && $_SESSION['Suser_type'] <> 'COLEADER' && $_SESSION['Suser_type'] <> 'ADMIN'){
            header("Location: ./errorPage.php?errTitle=Error&errMsg=You must be an AMC Leader, Coleader,  or Administrator to create new events.");
            exit(0);
        }
        // Note these are in twice
        // Now that all header redirects are passed, we can write html to page
        CHUNKgivehead($dates=true);
        CHUNKstartbody();

    }else{

        if ( ! UTILuser_may_admin($my_user_id, $event_id)){
            header("Location: ./errorPage.php?errTitle=Error&errMsg=You must be a designated this event's leader, coleader, or registrar to view this page. Please contact the trip leader.");
            exit(0);
        }
        // Note these are in twice
        // Now that all header redirects are passed, we can write html to page
        CHUNKgivehead($dates=true);
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
            $event_status=$row['event_status'];
            $event_is_program=$row['event_is_program'];
            $program_id=$row['program_id'];
            $description=$row['description'];
            $gear_list=$row['gear_list'];
            $trip_info=$row['trip_info'];
            $confirmation_page=$row['confirmation_page'];
            $question1=$row['question1'];
            $start_date=$row['start_date'];
            $end_date=$row['end_date'];
            $pricing=$row['pricing'];
            $rating=$row['rating'];

            if ($start_date == "0000-00-00") //This accounts for the events that were created with this date when
                $start_date = '';           //the start_date field was added to the database.


            $submitValue='Update Event';

            if ($event_is_program == 'Y')
                $event_is_programY ='checked';
            if ($event_is_program == 'P')
                $event_is_programP ='checked';
            if ($event_is_program == 'N')
                $event_is_programN ='checked';

            if ($program_id < 1)
                $program_id = '';
        }

        // Get program name
        //

        if ($program_id > 0)
        {
            $query = "select event_name
                FROM events
                WHERE event_id=$program_id;";

            $result = mysql_query($query);
            if (!$result) UTILdberror($query);

            $numrows = mysql_num_rows($result);
            if ($numrows == 1) {
                $row_program = mysql_fetch_assoc($result);
                $program_name=$row_program['event_name'];
            }
        }

    }  // end: $event_id<>''

    if ($event_id == ''){
        UTILbuildmenu(2);
        $start_date = '';   //define start_date for new events so PHP doesn't complain that it's undefined
        $end_date = '';
        $pricing = '';
        $rating = '';
    }
    else
        UTILbuildmenu(3);
    CHUNKstylemessage($_SESSION);

    CHUNKstartcontent($my_user_id, $event_id, 'admin');

    if ($event_id == ''){
        print "<h1 id='page_title'>Create New Event</h1>";
    }else{
        CHUNKshowtripname($event_id);
        print "<h1 id='page_title'>Event Administration Page</h1>";
    }
?>

<form name='trip_essence' action='action.php' method='post'>

<?php

  if ($submitValue == 'Update Event')
  {
    $event_url = 'http://hbbostonamc.org/regi/' . $event_id;
    print "<b>Registration URL:&nbsp;&nbsp;<a href='$event_url'>$event_url</a></b><br>";
    print "<p class='colored_note'>Copy and paste this URL into your AMC event posting to direct registrants to the Registration page.</p><br>";
  }

?>

* <span style="font-weight: bold">Event Name:</span> (Include location)<br>
<input type='text' required=required maxlength='60' name='event_name' value='<?php print $event_name; ?>' size=60><br><br>

<table style='border-collapse:separate;border-spacing:4ex 1ex;'>
    <tr>
        <td>
            * <span style="font-weight: bold">Start Date:</span> <br>MM/DD/YYYY<br>
            <input type='text' required=required maxlength='10' name='start_date' id='start_date' value='<?php print UTIL_date_prettify($start_date); ?>' size=10><br><br>
        </td>


        <td>
            <span style="font-weight: bold">End Date:</span> (Leave blank if event is only one day.)<br>MM/DD/YYYY<br>
            <input type='text' maxlength='10' name='end_date' id='end_date' value='<?php print UTIL_date_prettify($end_date); ?>' size=10><br><br>
        </td>
    </tr></table>

        * <span style="font-weight: bold">Event Status</span>:

        <br>Registration is ONLY active when status is set to 'OPEN' or 'WAIT LIST'.<br>All other statuses do NOT allow new registrations.
        <br>
        <select name='event_status'>
            <option value='<?php print $event_status; ?>'><?php print $event_status; ?>
            <option disabled>----------
            <option value='OPEN'>OPEN
            <option value='WAIT LIST'>WAIT LIST
            <option value='PENDING'>PENDING
            <option value='FULL'>FULL
            <option value='CLOSED'>CLOSED
            <option value='CANCELED'>CANCELED
        </select><br><br>

<span style="font-weight: bold">Hike Rating:</span> <br>

<?php CHUNKhikerating($rating, true); ?>
<!--
 <a href='http://www.hbbostonamc.org/index.php/Table/Key-to-Hike-Ratings/' target='_blank' >Hike Rating Key</a>)<br>

-->

<input type='text' maxlength='4' name='rating' value='<?php print $rating; ?>' size=4><br><br>


<span style="font-weight: bold">Cost:</span> (Example: <i>$110 covers 2 nights lodging, 2 breakfasts, and 2 dinners.</i>)<br>
<textarea name='pricing' rows=3 cols=60><?php print $pricing; ?></textarea><br><br>

<span style="font-weight: bold">* General Description:</span><br>
<textarea name='description' rows=8 cols=60><?php print $description; ?></textarea><br><br>

<span style="font-weight: bold">Gear List</span> (If no gear necessary, please type: "No gear necessary"):
<textarea name='gear_list' rows=8 cols=60><?php print $gear_list; ?></textarea><br><br>

<span style="font-weight: bold">Participant Info:</span> (Directions to trailhead, etc. Visible only to APPROVED participants.)
<textarea name='trip_info' rows=8 cols=60><?php print $trip_info; ?></textarea><br><br>

<h2>Program Info</h2>
<?php  //Set one button to be checked by default
    if ($event_is_programN + $event_is_programY + $event_is_programP == "")
        $event_is_programN = "checked";
?>

<input type="radio" name="event_is_program" value="N" <?php print $event_is_programN; ?> >This is a STANDALONE EVENT<br>

<input type="radio" name="event_is_program" value="Y" <?php print $event_is_programY; ?> >This is a PROGRAM<br>

<input type="radio" name="event_is_program" value="P" <?php print $event_is_programP; ?> >This event is PART OF A PROGRAM. The Program ID is
<input type='text' name='program_id' value='<?php print $program_id; ?>' size=10><?php print $program_name; ?><br>
<p class='colored_note'>Please contact the program leader for the program ID. If this event is not part of a program, leave blank.</p>

<h2>Default Questions</h2>
<p>Your event will ask the following by default: </p>

<ul>
<li><span style="font-weight: bold"><?php print "\"$SET_QUESTION_2\""; ?></span></li>
</ul>
<p>If it's not a PROGRAM, your event will also ask: </p>
<ul><li><span style="font-weight: bold"><?php print "\"$SET_QUESTION_1\""; ?></span></li>
</ul>


<p>You can also ask participants an additional question by listing it here:</p>

<span style="font-weight: bold">Additional Event Question </span>(Optional)<br>
<input type='text' name='question1' value='<?php print $question1; ?>' size=60><br><br>





<span style="font-weight: bold">Confirmation Page:</span> (Displays when user registers for event.)
<?php if ($event_id <> '') print "<br>Save changes and then you can <a href='./$event_id~confirm'><span style='font-size:130%;'>Preview</span></a> what you wrote.<br>"; ?>
<textarea name='confirmation_page' rows=8 cols=60><?php print $confirmation_page; ?></textarea><br><br>

<br><br>

<input type='hidden' name='event_id' value='<?php print $event_id; ?>'>
<input type='submit' class='button' name='action' value='<?php print $submitValue; ?>' onclick='return checkAdmin()'>
</form>

<?php CHUNKfinishcontent(); ?>

<?php

    if ($event_id == '')
        exit(0);
?>

