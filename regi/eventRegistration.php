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


    if (isset($_GET['event_id'])){
        $event_id = $_GET['event_id'];
    }else{
        header("Location: ./errorPage.php?errTitle=Error&errMsg=You attempted to view this page without specifying a trip. I suggest you go to My Events and click an event from there.");
        exit(0);
    }


    if (SECisUserLoggedIn($PASS_HMAC_SECRET_CODE)) {
        $my_user_id = $_SESSION['Suser_id'];
        if (isset($_SESSION['Suser_type'])){$user_type = $_SESSION['Suser_type'];}
        else{UTILtattletale("from eventRegi page, Suser_id no set");}
    } else {
        $_SESSION['Smessage'] = 'Please Log In';
        header("Location: ./login.php?event_id={$event_id}");
        exit();
    }


    // Now that all header redirects are passed, we can write html to page
    CHUNKgivehead();
    CHUNKstartbody();
    UTILbuildmenu(3);

    // Get event summary info
    //

    $query = "select event_name, event_status, event_is_program, program_id, description,
            gear_list, trip_info, question1, payment_method, start_date, end_date,
            pricing, rating
            FROM events
            WHERE event_id=$event_id;";

    $result = mysql_query($query);
    if (!$result) UTILdberror($query);

    $numrows = mysql_num_rows($result);
    if ($numrows <> 1) {
        $_SESSION['Smessage'] = "Invalid event ID.<br> Please make sure you typed in the URL correctly.";
        CHUNKstylemessage($_SESSION);
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
        $question1=$row['question1'];
        $payment_method=$row['payment_method'];
        $start_date=$row['start_date'];
        $end_date=$row['end_date'];
        $pricing=$row['pricing'];
        $rating=$row['rating'];
    }


    // Print list of co/leaders
    //



    CHUNKstylemessage($_SESSION);
    CHUNKstartcontent($my_user_id, $event_id, 'my');
    CHUNKshowtripname($event_id);
?>


<h1 id='page_title'>Event Registration</h1>

<h1>Event: <?php print $event_name; ?></h1>
<?php
    if ($end_date == '' || $end_date == '0000-00-00')
        $date_stri = UTILdate($start_date);
    else
        $date_stri = UTILdate($start_date)." - ".UTILdate($end_date);
    print "<p class='indented'>When: <b>{$date_stri}</b></p>";
    print "<p class='indented'>Event Status: <b>".$event_status."</b></p> ";
?>

<?php

    // If this event is part of a program, show program sign up status
    //

    if ($program_id > 0)
    {
        // Get Program Info
        //

        $pquery = "select event_name
            FROM events
            WHERE event_id = $program_id;";

        $presult = mysql_query($pquery);
        if (!$presult) UTILdberror($pquery);

        $pnumrows = mysql_num_rows($presult);
        if ($pnumrows == 1) {
            $prow = mysql_fetch_assoc($presult);
            print "This event is part of a program series: ";
            print "<a href=\"$program_id\" >".$prow['event_name'];
            print "</a><br>";
        }

        print "Your program enrollment status is: ";
        $pquery = "select register_status, payment_status
            FROM user_events
            WHERE event_id=$program_id
            AND user_id=$my_user_id;";

            $presult = mysql_query($pquery);
            if (!$presult) UTILdberror($pquery);

        $pnumrows = mysql_num_rows($presult);
        if ($pnumrows <> 1) {
            print "Not enrolled";
        } else {
            $prow = mysql_fetch_assoc($presult);
            print $prow['register_status'].'<br>';
        }
    }


    // Show Registration Fields (populate if already registered)
    //

    // Event specific fields
    $registration_id='';
    $answer1='';
    $answer2='';
    $gear='';
    $questions='';
    $need_ride='N';
    $need_rideY='';
    $need_rideN='';
    $need_rideD='';
    $can_take='0';
    $leaving_from='';
    $leave_time='';
    $returning_to='';
    $return_time='';
    $my_register_status="Not Registered";

    $submitValue='Sign Up For This Event';

    $query = "select registration_id, register_status, payment_status,
        need_ride, can_take, leaving_from, leave_time,
        returning_to, return_time,
        answer1, answer2, gear, questions
        FROM user_events
        WHERE event_id=$event_id
        AND user_id=$my_user_id;";

    $result = mysql_query($query);
    if (!$result) UTILdberror($query);

    $numrows = mysql_num_rows($result);
    if ($numrows == 1)
    {
        // This is a registered user

        $row = mysql_fetch_assoc($result);

        $registration_id=$row['registration_id'];
        $my_register_status=$row['register_status'];
        $my_payment_status=$row['payment_status'];
        $need_ride=$row['need_ride'];
        $can_take=$row['can_take'];
        $leaving_from=$row['leaving_from'];
        $leave_time=$row['leave_time'];
        $returning_to=$row['returning_to'];
        $return_time=$row['return_time'];
        $answer1=$row['answer1'];
        $answer2=$row['answer2'];
        $gear=$row['gear'];
        $questions=$row['questions'];

        $submitValue='Update Registration Page';
        if ($need_ride == 'Y')
            $need_rideY='checked';
        if ($need_ride == 'N')
            $need_rideN='checked';
        if ($need_ride == 'D')
            $need_rideD='checked';
    }

    print "<p class='indented'>My Registration Status: <b>$my_register_status</b></p>";
    CHUNKhikerating($rating);
    if (strlen($pricing) < 20){
        $start_bold = "<b>";
        $end_bold = "</b>";
    }else{
        $start_bold = '';
        $end_bold = '';
    }
    //print "<p class='indented'>Hike Rating: <b>".$rating.". </b>&nbsp;&nbsp;(<a href='http://www.hbbostonamc.org/index.php/Table/Key-to-Hike-Ratings/' target='_blank'>Hike Rating Key</a>)</p> ";
    print "<p class='indented'>Cost: ".$start_bold.str_replace("\n", "<br>", $pricing).$end_bold."</p> ";

    //Display co/leaders
    $query = "select users.user_id, users.first_name, users.last_name, users.email
            FROM users, user_events
            WHERE users.user_id = user_events.user_id
            AND (register_status='LEADER' or register_status='CO-LEADER')
            AND event_id=$event_id;";

    $result = mysql_query($query);
    if (!$result) UTILdberror($query);
    print "<h1>Leaders</h1>";
    $leader_list='';
    $numrows = mysql_num_rows($result);
    if ($numrows < 1) {
        $leader_list="No leaders or co-leaders are assigned to this event.";
    }
    else
    {
        print "<div class='indented'>";
        while($row = mysql_fetch_assoc($result)){
            $leader_list=$leader_list."\"$row[first_name] $row[last_name]\" <$row[email]>, ";
            print "<a href=mailto:{$row['email']}>$row[first_name] $row[last_name]</a><br>";
        }
        print "</div>";
    }




?>

<h1>Event Information</h1>

<p><?php print str_replace("\n", "<br>", $description); ?></p>

<h1>Gear List</h1>
<?php print str_replace("\n", "<br>", $gear_list); ?>

<?php

    // If this event is a program
    //   -list all events tied with the program
    //

    if ($event_is_program=='Y')
    {
        print "<h1>Program Events</h1>";

        $query = "select event_id, event_name
            FROM events
            WHERE program_id=$event_id;";

        $result = mysql_query($query);
        if (!$result) UTILdberror($query);

        $numrows = mysql_num_rows($result);
        if ($numrows < 1) {
            print "<p>Events have not yet been added to program.</p>";
        } else {
            echo "<table>";

            while($row = mysql_fetch_assoc($result)) {

                echo "<tr><td><a href=\"$row[event_id]\" >$row[event_name]</a></td></tr>";

            }
            echo "</table>";
        }

    }


    // If event is not OPEN, and user has not already signed up, do not show registration form
    //

    if ($submitValue=='Sign Up For This Event' && $event_status != 'OPEN' && $event_status != 'WAIT LIST')
    {
        print "<br><br></div></body></html>";
        exit(0);
    }


    // Check: Is current user confirmed for this event?
    //

    if ($my_register_status=='APPROVED' || $my_register_status=='LEADER' || $my_register_status=='CO-LEADER' || $my_register_status=='ENROLLED')
    {
        //$row = mysql_fetch_assoc($result);
        //$my_reg_status = $row[];

        // Print Participant Info
        //

        print "<h1>Information for Participants</h1>";
        print htmlspecialchars_decode(str_replace("\n", "<br>", $trip_info));


        // Print list of all CONFIRMED participants if user is confirmed
        //

        $query = "select first_name, last_name, email,
            register_status, registration_id, need_ride, can_take,
            leaving_from, leave_time, returning_to, return_time
            FROM users, user_events
            WHERE users.user_id = user_events.user_id
            AND (register_status='LEADER' or register_status='CO-LEADER' or register_status='APPROVED')
            AND event_id=$event_id;";

        $result = mysql_query($query);
        if (!$result) UTILdberror($query);

        $numrows = mysql_num_rows($result);
        if ($numrows > 0)
        {
            print "<h1>Confirmed Participants</h1>";
            print "<table><tr class='table_header'><th>Name</th><th>Email</th><th>Need Ride</th><th>Can Take</th><th>Leaving From:</th><th>Returning To:</th></tr>";
            $rowcount = 0;
            while($row = mysql_fetch_assoc($result)) {
                $even_or_odd = $rowcount % 2;
                print "<tr class='row{$even_or_odd}'>";
                print "<td>$row[first_name] $row[last_name]</td>";
                print "<td>$row[email]</td>";
                print "<td>$row[need_ride]</td><td>$row[can_take]</td>";
                $leave_sep = '';
                if ($row['leave_time'] != '') $leave_sep = ' @ ';
                print "<td>$row[leaving_from]" . $leave_sep . "$row[leave_time]</td>";
                $return_sep = '';
                if ($row['return_time'] != '') $return_sep = ' @ ';
                print "<td>$row[returning_to]" . $return_sep . "$row[return_time]</td>";
                print "</tr>";
                $rowcount += 1;

            }
            print "</table>";
        }


    }

?>

    <h1>My Registration Information</h1>

    <form name='signup' action='action.php' method='post'>


<?php

    if ($question1 <> '')
    {
        print $question1;
        print "<br><textarea name='answer1' rows=3 cols=60 required='required'>$answer1</textarea><br><br>";
    }


    if ($event_is_program <> 'Y')
    {
        print "$SET_QUESTION_1<br>
    <textarea name='gear' rows=3 cols=60 required='required'>$gear</textarea><br>";

    }

    print $SET_QUESTION_2;
?>

    <br>
    <textarea name='questions' rows=3 cols=60 required='required'><?php print $questions; ?></textarea>

<?php

    if ($event_is_program <> 'Y')
    {

    print "<h1>Carpool Info</h1>
    <table><tr>
    <td>Do you want to carpool?</td>

    <td>
    <input type='radio' required='required' name='need_ride' value='D' $need_rideD >I can drive and can take
    <input type='text' name='can_take' value='$can_take' size=3 MAXLENGTH=2> other participants
    </td>

    </tr><tr>
    <td></td><td>
    <input type='radio' name='need_ride' value='Y' $need_rideY >I need a ride<br>
    </td>
    </tr><tr>
    <td></td><td>
    <input type='radio' name='need_ride' value='N' $need_rideN >I'm all set and will meet you there
    </td>

    </tr></table>
    <br><p class='colored_note'>Carpoolers, tell us where you're coming from and what time you're leaving.</p>
    <table>
    <tr><td></td><td>(Town)</td><td></td><td>(Time, Day)</td></tr>
    <tr>
        <td>Leaving from </td>
        <td><input type='text' name='leaving_from' value='$leaving_from' size=30 MAXLENGTH=100 required='required'></td>
        <td>at</td>
        <td><input type='text' name='leave_time' value='$leave_time' size=30 MAXLENGTH=100></td>
    </tr>
    <tr>
        <td>Returning to </td>
        <td><input type='text' name='returning_to' value='$returning_to' size=30 MAXLENGTH=100></td>
        <td>at</td>
        <td><input type='text' name='return_time' value='$return_time' size=30 MAXLENGTH=100></td>
    </tr>
    </table>";

    }

?>
    <br>
    <input type='hidden' name='registration_id' value='<?php print $registration_id; ?>'>
    <input type='hidden' name='event_id' value='<?php print $event_id; ?>'>
    <input type='hidden' name='event_name' value='<?php print $event_name; ?>'>
    <input type='hidden' name='leader_list' value='<?php print $leader_list; ?>'>
    <input type='submit' class='button' name='action' value='<?php print $submitValue; ?>' onclick='return checkSignup()'>
    </form>
<?php CHUNKfinishcontent(); ?>

