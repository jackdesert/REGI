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
    // SECURITY
    // - User must be logged in

    if (isset($_SESSION['Suser_id']))
    {
        $my_user_id = $_SESSION['Suser_id'];
        $user_type = $_SESSION['Suser_type'];
    }
    else
    {
        header("Location: ./errorPage.php?errTitle=Error&errMsg=User must be logged in to view this page.");
        exit(0);
    }

    // NOTE: Currently: ALL users can admin a trip IF their register_status is set to CO/LEADER or REGISTRAR
    //       They do NOT need to be AMC LEADERS.

    //if ($_SESSION['Suser_type'] <> 'LEADER' && $_SESSION['Suser_type'] <> 'ADMIN')
    //{
    //  header("Location: ./errorPage.php?errTitle=Error&errMsg=User must be an AMC Leader or Administrator to view this page.");
    //  exit(0);
    //}

    if (isset($_GET['event_id']))
        $event_id = $_GET['event_id'];
    else
        $event_id = '';

    $submitValue='New Event';
    $event_name='';
    $event_status='OPEN';
    $event_is_program='N';
    $event_is_programY='';
    $event_is_programP='';
    $event_is_programN='';
    $description='';
    $gear_list='';
    $trip_info='';
    $confirmation_page='Thank you for registering. A trip leader will be in contact with you soon regarding your participation in this event.';
    $question1='';
    $question2='';

    $program_id='';
    $program_name='';

    if ($event_id <> '')
    {
        // Check if current user is a leader, co-leader, or registrar of this trip
        //

        $query = "select users.user_id
            FROM users, user_events
            WHERE users.user_id = user_events.user_id
            AND (register_status='LEADER' or register_status='CO-LEADER' or register_status='REGISTRAR')
            AND event_id=$event_id
            AND users.user_id=$my_user_id;";

        $result = mysql_query($query);
        if (!$result) UTILdberror($query);

        $numrows = mysql_num_rows($result);
        if ($numrows <> 1 && $_SESSION['Suser_type'] <> 'ADMIN')
        {
            header("Location: ./errorPage.php?errTitle=Error&errMsg=User must be a designated trip leader, co-leader, or registrar to view this page. Please contact the trip leader.");
            exit(0);
        }

        // Get event summary info
        //

        $query = "select event_name, event_status, event_is_program, program_id, description, gear_list, trip_info, confirmation_page, question1, question2, start_date, end_date
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
            $question2=$row['question2'];
            $start_date=$row['start_date'];
            $end_date=$row['end_date'];

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

?>

    </div>
   </div>
   <div style="padding-left:20px; width:90%;">

<h2>Event Administration Page
<a href="#signUpSheet">[Jump to Sign-up Sheet]</a></h2>

<form name='info' action='action.php' method='post'>

* <span style="font-weight: bold">Event Name:</span> (include location, rating)<br>
<input type='text' name='event_name' value='<?php print $event_name; ?>' size=80><br><br>

* <span style="font-weight: bold">Event (Start) Date:</span> (format: YYYY-MM-DD)<br>
<input type='text' name='start_date' value='<?php print $start_date; ?>' size=80><br><br>

<span style="font-weight: bold">Event End Date:</span> (Optional. Only fill this out if event is more than one day.)<br>
<input type='text' name='end_date' value='<?php print $end_date; ?>' size=80><br><br>



<?php

  if ($submitValue == 'Update Event')
  {
    print "<b>* Registration URL: http://www.hbbostonamc.org/registrationSystem/login.php?event_id=$event_id</b><br>";
    print "<i>Note: Copy and paste this URL into your AMC trip posting to direct registrants to the Registration page.</i><br><br>";
  }

?>

* <span style="font-weight: bold">Event Status</span>:
<select name='event_status'>
        <option value='<?php print $event_status; ?>'><?php print $event_status; ?>
        <option disabled>----------
        <option value='OPEN'>OPEN
        <option value='WAIT LIST'>WAIT LIST
        <option value='PENDING'>PENDING
        <option value='FULL'>FULL
        <option value='CLOSED'>CLOSED
        <option value='CANCELED'>CANCELED
</select><br>
<i style="color: #096">Note: Registration is ONLY active when status is set to 'OPEN' or 'WAIT LIST'.  All other status do NOT allow new registrations.</i>
<br><br>

* General Description:
<textarea name='description' rows=8 cols=100><?php print $description; ?></textarea><br><br>

<span style="font-weight: bold">Gear List</span> (if no gear necessary, please type: "No gear necessary"):
<textarea name='gear_list' rows=8 cols=100><?php print $gear_list; ?></textarea><br><br>

<span style="font-weight: bold">Confirmation Page:</span> (This information will be displayed once a user registers for this event.)
<?php if ($event_id <> '') print "<br>Click here to <a href='./confirmationPage.php?event_id=$event_id'><big>Preview</big></a> the confirmation page."; ?>
<textarea name='confirmation_page' rows=8 cols=100><?php print $confirmation_page; ?></textarea><br><br>

<span style="font-weight: bold">Participant Info:</span> (Visible only for APPROVED participants, Directions to trailhead, etc).
<textarea name='trip_info' rows=8 cols=100><?php print $trip_info; ?></textarea><br><br>

<p>Two questions are automatically asked of participants upon registering. They are: </p>

<ol>
<li><span style="font-weight: bold"><?php print "\"$SET_QUESTION_1\""; ?></span></li>
<li><span style="font-weight: bold"><?php print "\"$SET_QUESTION_2\""; ?></span></li>
</ol>


<p>If you would like to ask additional questions, list them here:</p>

<span style="font-weight: bold">Additional Trip Question </span>(Optional)<br>
<input type='text' name='question1' value='<?php print $question1; ?>' size=80><br><br>
<!-- Do Not Display Second Question
<span style="font-weight: bold">Additional Trip Question 2 (Optional)</span><br>
<input type='text' name='question2' value='<?php print $question2; ?>' size=80><br><br>
-->

<h2>Program Info</h2>
<?php  //Set one button to be checked by default
    if ($event_is_programN + $event_is_programY + $event_is_programP == "")
        $event_is_programN = "checked";
?>

<input type="radio" name="event_is_program" value="N" <?php print $event_is_programN; ?> >This is a STANDALONE EVENT<br>

<input type="radio" name="event_is_program" value="Y" <?php print $event_is_programY; ?> >This is a PROGRAM<br>

<input type="radio" name="event_is_program" value="P" <?php print $event_is_programP; ?> >This event is PART OF A PROGRAM. The Program ID is
<input type='text' name='program_id' value='<?php print $program_id; ?>' size=10><?php print $program_name; ?><br>
<i style="color: #096">Note: Please contact the program leader for the Event ID of the program. If this event is not part of a program, leave blank or enter '0'</i>
<br>


<!--

Is this event a program? (ie. Winter Program, Spring Program, etc.)
<select name='event_is_program'>
        <option value='<?php print $event_is_program; ?>'><?php print $event_is_program; ?>
        <option disabled>---
        <option value='Y'>Y
        <option value='N'>N
</select><br><br>

OR, is this event <i>part</i> of a program? If so, please enter the Program ID:
<input type='text' name='program_id' value='<?php print $program_id; ?>' size=10><?php print $program_name; ?><br>
<i>Note: Please contact the program leader for the Event ID of the program. If this event is not part of a program, leave blank or enter '0'</i>

-->


<br><br>

<input type='hidden' name='event_id' value='<?php print $event_id; ?>'>
<input type='submit' name='action' value='<?php print $submitValue; ?>' onclick='return checkAdmin()'>
</form>

<?php

    if ($event_id == '')
        exit(0);
?>

<br>
<a name="signUpSheet"></a>
<hr>
<h1>Sign-up Sheet</h1>
<i style="color: #096">Don't forget to hit 'Update Signup Sheet' at bottom to save changes.</i>
<form name='info' action='action.php' method='post'>
<table border=1><tr>
<td></td><td>NAME / CONTACT</td><td>PROFILE & TRIP INFO</td><td>STATUS / ADMIN NOTES</td>

<?php

    // Display Sign-up Sheet to:
    //  - Administrators and trip co/leaders, registrar
    //  - TO DO: selected participants to view others who are selected??
    //

    $query = "(select users.user_id, registration_id, first_name, last_name,
        register_date, register_status, payment_status,
        email, phone_evening, phone_day, phone_cell,
        emergency_contact, member, experience, exercise, medical, diet,
        answer1, answer2, gear, questions, admin_notes
        FROM users, user_events
        WHERE users.user_id=user_events.user_id
        AND event_id = $event_id
        AND (register_status = 'LEADER' || register_status = 'CO-LEADER' || register_status = 'REGISTRAR')
        ORDER BY register_date)
        UNION
        (select users.user_id, registration_id, first_name, last_name,
        register_date, register_status, payment_status,
        email, phone_evening, phone_day, phone_cell,
        emergency_contact, member, experience, exercise, medical, diet,
        answer1, answer2, gear, questions, admin_notes
        FROM users, user_events
        WHERE users.user_id=user_events.user_id
        AND event_id = $event_id
        AND (register_status <> 'LEADER' && register_status <> 'CO-LEADER' && register_status <> 'REGISTRAR')
        ORDER BY register_date);";

    $result = mysql_query($query);
    if (!$result) UTILdberror($query);

    $numrows = mysql_num_rows($result);
    if ($numrows < 1) {
        print "<br>No one has registered<br>";
    } else {
        $x=0;
        $viewable_users='';

        $stat_count_leader=0;
        $stat_count_coleader=0;
        $stat_count_submitted=0;
        $stat_count_waitlist=0;
        $stat_count_approved=0;

        while($row = mysql_fetch_assoc($result)) {
            echo "</tr><tr>";
            echo "<td><input type='hidden' name='registration_id[]' value=$row[registration_id]>
<input type='hidden' name='first_name[]' value=$row[first_name]>
<input type='hidden' name='email[]' value=$row[email]>";

            if ($row[register_status]=='LEADER' || $row[register_status]=='CO-LEADER') {
                echo 'L'.++$stat_count_leader;
            }
            else if ($row[register_status]=='SUBMITTED') {
                echo 'S'.++$stat_count_submitted;
            }
            else if ($row[register_status]=='WAIT LIST') {
                echo 'W'.++$stat_count_waitlist;
            }
            else if ($row[register_status]=='APPROVED' || $row[register_status]=='ENROLLED') {
                echo 'A'.++$stat_count_approved;
            }
            echo "</td>";

            echo "<td valign='top'><b>$row[first_name] $row[last_name]</b>";
            echo "<br><b>Registered:</b>".UTILtime($row['register_date'])."";
            echo "<br><b>Member:</b> $row[member]";
            echo "<br><b>Email:</b> $row[email]";
            echo "<br><b>Evening:</b> $row[phone_evening]";
            echo "<br><b>Day:</b> $row[phone_day]";
            echo "<br><b>Cell:</b> $row[phone_cell]</td>";

            echo "<td valign='top'><b>Experience:</b> $row[experience]";
            echo "<br><b>Exercise:</b> $row[exercise]";
            echo "<br><b>Medical:</b> $row[medical]";
            echo "<br><b>Diet:</b> $row[diet]";
            echo "<br><b>Answer1:</b> $row[answer1]";
            echo "<br><b>Answer2:</b> $row[answer2]";
            echo "<br><b>Gear:</b> $row[gear]";
            echo "<br><b>Questions:</b> $row[questions]</td>";

            if ($event_is_program == 'Y')
            echo "<td  valign='top'><b>PROGRAM STATUS:</b><br>
                <select name='set_reg_status[]'>
                <option value='*'>$row[register_status]
                <option disabled>-------------
                <option value='LEADER'>LEADER
                <option value='CO-LEADER'>CO-LEADER
                <option value='REGISTRAR'>REGISTRAR
                <option value='SUBMITTED'>SUBMITTED
                <option value='WAIT LIST'>WAIT LIST
                <option value='ENROLLED'>ENROLLED
                <option value='CANCELED'>CANCELED
            </select>";
            else
            echo "<td  valign='top'><b>REGISTRATION STATUS:</b><br>
                <select name='set_reg_status[]'>
                <option value='*'>$row[register_status]
                <option disabled>-------------
                <option value='LEADER'>LEADER
                <option value='CO-LEADER'>CO-LEADER
                <option value='REGISTRAR'>REGISTRAR
                <option value='SUBMITTED'>SUBMITTED
                <option value='WAIT LIST'>WAIT LIST
                <option value='APPROVED'>APPROVED
                <option value='CANCELED'>CANCELED
            </select>";

            echo "<br><b>NOTES:</b><br><textarea name='admin_notes[]' rows=5>$row[admin_notes]</textarea>";

            if ($program_id > 0)
            {
                echo "<br><b>PROGRAM STATUS:</b><br> ";
                $pquery = "select register_status, payment_status
                        FROM user_events
                        WHERE event_id=$program_id
                        AND user_id=$row[user_id];";

                    $presult = mysql_query($pquery);
                    if (!$presult) UTILdberror($pquery);

                $pnumrows = mysql_num_rows($presult);
                if ($pnumrows <> 1) {
                    echo "NOT ENROLLED";
                } else {
                    $prow = mysql_fetch_assoc($presult);
                    echo $prow['register_status'];
                }
            }
            echo "</td>";

        } // end loop

        echo "<h2>COUNT SUMMARY: Co/Leaders:$stat_count_leader  *  Submitted:$stat_count_submitted  *  Wait List:$stat_count_waitlist  *  Approved:$stat_count_approved</h2>";

    }

?>

</tr></table><br>
<input type='hidden' name='event_id' value='<?php print $event_id; ?>'>
<input type='hidden' name='event_name' value='<?php print $event_name; ?>'>
<input type='submit' name='action' value='Update Signup Sheet' onclick=''>
</form>
<p>&nbsp;</p>
<h1>Export Signup Sheet</h1>
<p><i style="color: #096">Export Signup Sheet as Excel spreadsheet (tab delimited).</i>
  <br>
</p>
<form name='info' action='action.php' method='post'>
  <input type='hidden' name='event_id' value='<?php print $event_id; ?>'>
  <input type='hidden' name='event_name' value='<?php print $event_name; ?>'>
<input type='submit' name='action' value='Export Signup Sheet' onclick=''>
</form>

</div>
</body>
</html>
