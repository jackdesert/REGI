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
        exit();
    }

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
    $confirmation_page='Thank you for registering. An event leader will be in contact with you soon regarding your participation in this event.';
    $question1='';
    $question2='';

    $program_id='';
    $program_name='';

    if ($event_id == ''){
        // Only user_type  of Leader, Coleader, or Admin can create a new trip

        if ($_SESSION['Suser_type'] <> 'LEADER' && $_SESSION['Suser_type'] <> 'COLEADER' && $_SESSION['Suser_type'] <> 'ADMIN'){
            header("Location: ./errorPage.php?errTitle=Error&errMsg=You must be an AMC Leader, Coleader,  or Administrator to create new events.");
            exit(0);
        }


    }else{

        if ( ! UTILuser_may_admin($my_user_id, $event_id)){
            header("Location: ./errorPage.php?errTitle=Error&errMsg=You must be a designated this event's leader, coleader, or registrar to view this page. Please contact the trip leader.");
            exit(0);
        }

        // Now that all header redirects are passed, we can write html to page
        CHUNKgivehead();
        CHUNKstartbody();
        UTILbuildmenu(3);
        CHUNKstylemessage($_SESSION);

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

    CHUNKstartcontent($my_user_id, $event_id, 'roster');

    if ($event_id == '')
        exit(0);
?>


<h1 id='page_title'>Roster of Participants</h1>
<i style="color: #096">Don't forget to hit 'Update Roster' at bottom to save changes.</i>
<form name='signup' action='action.php' method='post'>
<table><tr class='table_header'>
<th></th><th>NAME / CONTACT</th><th>PROFILE & EVENT INFO</th><th>STATUS / ADMIN NOTES</th>

<?php

    // Display Sign-up Sheet to:
    //  - Administrators and event co/leaders, registrar
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
        $approved_email_list = '';
        $rowcount = 0;
        while($row = mysql_fetch_assoc($result)) {
            $even_or_odd = $rowcount % 2;
            echo "</tr><tr class='row{$even_or_odd}'>";
            $rowcount += 1; // can increment here because it's not referenced again later
            echo "<td><input type='hidden' name='registration_id[]' value=$row[registration_id]>
<input type='hidden' name='first_name[]' value=$row[first_name]>
<input type='hidden' name='email[]' value=$row[email]>";

            if ($row['register_status']=='LEADER' || $row['register_status']=='CO-LEADER') {
                echo 'L'.++$stat_count_leader;
                $approved_email_list .= $row['email'] . ',';
            }
            else if ($row['register_status']=='SUBMITTED') {
                echo 'S'.++$stat_count_submitted;
            }
            else if ($row['register_status']=='WAIT LIST') {
                echo 'W'.++$stat_count_waitlist;
            }
            else if ($row['register_status']=='APPROVED' || $row['register_status']=='ENROLLED') {
                echo 'A'.++$stat_count_approved;
                $approved_email_list .= $row['email'] . ',';
            }
            echo "</td>";

            echo "<td><b>$row[first_name] $row[last_name]</b>";
            echo "<br><b>Registered:</b>".UTILtime($row['register_date'])."";
            echo "<br><b>Member:</b> $row[member]";
            echo "<br><b>Email:</b> $row[email]";
            echo "<br><b>Evening:</b> $row[phone_evening]";
            echo "<br><b>Day:</b> $row[phone_day]";
            echo "<br><b>Cell:</b> $row[phone_cell]</td>";

            echo "<td><b>Experience:</b> $row[experience]";
            echo "<br><b>Exercise:</b> $row[exercise]";
            echo "<br><b>Medical:</b> $row[medical]";
            echo "<br><b>Diet:</b> $row[diet]";
            echo "<br><b>Answer1:</b> $row[answer1]";
            echo "<br><b>Answer2:</b> $row[answer2]";
            echo "<br><b>Gear:</b> $row[gear]";
            echo "<br><b>Questions:</b> $row[questions]</td>";

            if ($event_is_program == 'Y')
            echo "<td><b>PROGRAM STATUS:</b><br>
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
            echo "<td><b>REGISTRATION STATUS:</b><br>
                <select name='set_reg_status[]'>";
            $selected_status = $row['register_status'];
            CHUNKdropdown('LEADER', $selected_status);
            CHUNKdropdown('CO-LEADER', $selected_status);
            CHUNKdropdown('REGISTRAR', $selected_status);
            print "<option disabled>-------------";
            CHUNKdropdown('APPROVED', $selected_status);
            CHUNKdropdown('WAIT LIST', $selected_status);
            CHUNKdropdown('CANCELED', $selected_status);
            CHUNKdropdown('SUBMITTED', $selected_status);
            print "</select>";

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


    }

?>

</tr></table><br>
<?php echo "<h2>COUNT SUMMARY: Co/Leaders:$stat_count_leader  *  Submitted:$stat_count_submitted  *  Wait List:$stat_count_waitlist  *  Approved:$stat_count_approved</h2>"; ?>
<input type='hidden' name='event_id' value='<?php print $event_id; ?>'>
<input type='hidden' name='event_name' value='<?php print $event_name; ?>'>
<input type='submit' class='button' name='action' value='Update Roster' onclick=''>
</form>
<p>&nbsp;</p>
<?php
if (strlen($approved_email_list) > 0){
    print "<h1>Email Approved Participants</h1>";
    $approved_email_list = substr($approved_email_list, 0, -1); //removing trailing comma
    print "Click this link to <a href=mailto:$approved_email_list>email approved participants</a>. ";
    print "(Leaders/Coleaders included).";
}
?>
<h1>Export Roster</h1>
<p>Here you can export the roster as either a Microsoft Excel spreadsheet (recommended), or as tab delimited text.
</p>
<form name='export' action='action.php' method='post'>
  <input type='hidden' name='event_id' value='<?php print $event_id; ?>'>
  <input type='hidden' name='event_name' value='<?php print $event_name; ?>'>
<input type='submit' class='button' name='action' value='Export Excel Spreadsheet' onclick=''>
<input type='submit' class='button' name='action' value='Export Tab Delimited' onclick=''>
</form>

<?php CHUNKfinishcontent(); ?>
