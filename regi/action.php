<?php

/*
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

*/

// Action Page
//  - Contains all function calls that perform
//  - database insert, update, and delete

    include 'utils.php';

    // Start session
    session_start();

    // Connect to Database
    //
    UTILdbconnect();

    $_SESSION['Smessage'] = '';

    $action = $_POST['action'];
    switch($action) {

        // Login validation -----------------------------------------------------------
        //

        case "login":
            // Get POST vars from home.php
            //

            $event_id = $_POST["event_id"];
            $admin_event_id = $_POST["admin_event_id"];

            $Pusername = UTILclean($_POST["user_name"], 50, "User Name");
            $Ppassword = UTILclean($_POST["user_password"], 20, "Password");
            if (!UTILrequiredfields()) {
                header( 'Location: ./login.php');
                exit();
            }

            // SELECT USER FROM DB
            //

            $query = "select user_id, user_password, first_name, last_name, user_type
                from users where user_name = '$Pusername';";

            $result = mysql_query($query);
            if (!$result)
                UTILdberror($query);

            $numrows = mysql_num_rows($result);
            if ($numrows != 1) {
                $_SESSION['Smessage'] = "User name not found in Database.";
            } else {
                $row = mysql_fetch_assoc($result);

                if ($row['user_type'] == 'Inactive') {
                    $_SESSION['Smessage'] = "This user account is not activated.";
                }
                elseif ($Ppassword != $row['user_password']) {
                    $_SESSION['Smessage'] = "Invalid Password, please try again.";
                } else {
                    $_SESSION['Smessage'] = "Welcome: $row[first_name] $row[last_name], you are now logged in!";

                    // Put User Info into SESSION
                    //

                    $_SESSION['Suser_id'] = $row['user_id'];
                    $_SESSION['Sfirst_name'] = $row['first_name'];
                    $_SESSION['Slast_name'] = $row['last_name'];
                    $_SESSION['Suser_type'] = $row['user_type'];

                    // Update Last Login datetime
                    $query = "update users set last_login = now() where user_id = $row[user_id];";
                    $result = mysql_query($query);
                    if (!$result) UTILdberror($query);

                    if ($event_id <> '')
                        header("Location: ./eventRegistration.php?event_id=".$event_id);
                    else if ($admin_event_id <> '')
                        header("Location: ./eventAdmin.php?event_id=".$admin_event_id);
                    else
                        header("Location: ./myTrips.php?user_id=".$row['user_id']);

                    exit();
                }
            }

            header( "Location: ./login.php?event_id=".$event_id);
            exit();

        break;   // End: action=login


        // Register -----------------------------------------------------------
        //

        case "Register and Continue":

            $user_id= $_SESSION["Suser_id"];
            $event_id= $_POST["event_id"];
            $answer1= UTILclean($_POST["answer1"], 3000, '');
            $answer2= UTILclean($_POST["answer2"], 3000, '');
            $gear= UTILclean($_POST["gear"], 3000, '');
            $questions= UTILclean($_POST["questions"], 3000, '');
            $need_ride= UTILclean($_POST["need_ride"], 1, '');
            $can_take= UTILclean($_POST["can_take"], 2, '');
            $leaving_from= UTILclean($_POST["leaving_from"], 100, '');
            $returning_to= UTILclean($_POST["returning_to"], 100, '');

            //if ($user_id == '') $user_id = -1;

            //if (isset($_GET['event_id']))
            //  $event_id=$_GET['event_id'];
            //else
            //  $event_id='';

            $query = "insert into user_events (
                user_id, event_id, answer1, answer2, gear, questions, need_ride,
                can_take, leaving_from, returning_to,
                register_status, payment_status, register_date) values (
                '$user_id', '$event_id', '$answer1', '$answer2', '$gear', '$questions', '$need_ride',
                '$can_take', '$leaving_from', '$returning_to',
                'SUBMITTED', 'NO PAYMENT', now());";

            $result = mysql_query($query);

            $SUID = mysql_insert_id();

            if (mysql_errno()==1062)
                $_SESSION['Smessage']="You are already registered for this event.";
            else if (!$result)
                UTILdberror($query);
            else
            {
                $_SESSION['Smessage'] = "Your registration has been submitted.<br>Please check back in a few days for updates.";

                // Send email to leaders - TBD
                //
                //$leader_list=$_POST["leader_list"];
                $event_name=$_POST["event_name"];
                $first_name=$_SESSION["Sfirst_name"];
                $last_name=$_SESSION["Slast_name"];


                // Create email list of co/leaders + registrars
                //

                $query = "select users.first_name, users.last_name, users.email
                FROM users, user_events
                WHERE users.user_id = user_events.user_id
                AND (register_status='LEADER' or register_status='CO-LEADER' or register_status='REGISTRAR')
                AND event_id=$event_id;";

                $result = mysql_query($query);
                if (!$result) UTILdberror($query);

                $leader_list='';
                $numrows = mysql_num_rows($result);
                if ($numrows < 1) {
                    $leader_list="amcbostonhbs@gmail.com";
                }
                else
                {
                    while($row = mysql_fetch_assoc($result))
                        $leader_list=$leader_list."\"$row[first_name] $row[last_name]\" <$row[email]>, ";
                }


                $title="AMC Boston Chapter Trip Registration - New Registrant";
                $message="Notice to trip leaders:\n\n$first_name $last_name has just registered for the following trip: $event_name.\n\nClick here for the admin page:
http://www.hbbostonamc.org/registrationSystem/login.php?admin_event_id=$event_id\n\nThank you!";

                UTILsendEmail($leader_list, $title, $message);
            }

            header("Location: ./confirmationPage.php?event_id=$event_id");
            exit();

        break;


        // Update Register Info --------------------------------------------------
        //

        case "Update Register Info":

            $registration_id= $_POST["registration_id"];
            $event_id= $_POST["event_id"];
            $answer1= UTILclean($_POST["answer1"], 3000, '');
            $answer2= UTILclean($_POST["answer2"], 3000, '');
            $gear= UTILclean($_POST["gear"], 500, '');
            $questions= UTILclean($_POST["questions"], 500, '');
            $need_ride= UTILclean($_POST["need_ride"], 1, '');
            $can_take= UTILclean($_POST["can_take"], 2, '');
            $leaving_from= UTILclean($_POST["leaving_from"], 100, '');
            $returning_to= UTILclean($_POST["returning_to"], 100, '');

            $query = "update user_events set
                answer1='$answer1', answer2='$answer2', gear='$gear', questions='$questions',
                need_ride='$need_ride', can_take='$can_take',
                leaving_from='$leaving_from', returning_to='$returning_to'
                WHERE registration_id=$registration_id;";

            $result = mysql_query($query);

            if (!$result)
                UTILdberror($query);
            else
                $_SESSION['Smessage'] = "Registration info updated.";

            header("Location: ./myTrips.php?event_id=$event_id");
            exit();

        break;


        // Update Signup Sheet -------------------------------------------------------
        //

        case "Update Signup Sheet":

            $set_reg_status_AR = $_POST["set_reg_status"];
            $set_pay_status_AR = $_POST["set_pay_status"];
            $admin_notes_AR = $_POST["admin_notes"];
            $registration_id_AR = $_POST["registration_id"];
            $first_name_AR = $_POST["first_name"];
            $email_AR = $_POST["email"];

            $event_id= $_POST["event_id"];
            $event_name= $_POST["event_name"];

            $inc=0;
            foreach($registration_id_AR as $REG_ID)
            {
                if ($set_reg_status_AR[$inc][0] <> '*')
                {
                    $query = "update user_events set
                    register_status='$set_reg_status_AR[$inc]'
                    WHERE
                    registration_id=$REG_ID;";

                    $result = mysql_query($query);

                    if (!$result)
                        UTILdberror($query);

                    // Send email to participant - TBD
                    //
                    $first_name=$first_name_AR[$inc];
                    $email=$email_AR[$inc];
                    $reg_status=$set_reg_status_AR[$inc];

                    $title="AMC Boston Chapter - Trip Registration Status";
                    $message="Hello $first_name,\n\nYour trip registration status has been updated to $reg_status for the following trip: $event_name.\n\nClick here to log in and view this trip:
http://www.hbbostonamc.org/registrationSystem/login.php?event_id=$event_id
\n\nPlease contact the trip leader if there are any questions.\n\nThank you!";

                    UTILsendEmail($email, $title, $message);

                }

                //if ($set_pay_status_AR[$inc][0] <> '*')
                //{
                //  $query = "update user_events set
                //  payment_status='$set_pay_status_AR[$inc]'
                //  WHERE
                //  registration_id=$REG_ID;";

                //  $result = mysql_query($query);

                //  if (!$result)
                //      UTILdberror($query);
                //}

                // Check if change bit is set, currently always updating if not null - TBD
                if ($admin_notes_AR[$inc] <> '')
                {
                    $query = "update user_events set
                    admin_notes='$admin_notes_AR[$inc]'
                    WHERE
                    registration_id=$REG_ID;";

                    $result = mysql_query($query);

                    if (!$result)
                        UTILdberror($query);
                }

                $inc++;
            }

            $_SESSION['Smessage'] = "Sign-up Sheet Updated.";
            header("Location: ./eventAdmin.php?event_id=$event_id");
            exit();

        break;


        // Make Payment -----------------------------------------------------------
        //

        case "Pay with PayPal":

            $user_id= $_SESSION["Suser_id"];
            $registration_id= $_POST["registration_id"];
            $event_id= $_POST["event_id"];
            $event_name= $_POST["event_name"];
            $cost= $_POST["cost_per_person"];

            print "<h2>Link to PayPal</h2>";
            print "Event Name: $event_name<br>Cost: $cost<br>";
            print "Registration ID: $registration_id<br>User ID: $user_id<br>Event ID: $event_id";

        break;

        // Export Info Sheet -----------------------------------------------------------
        //

        case "Export Signup Sheet":

            $event_id = $_POST["event_id"];
            $event_name= $_POST["event_name"];
            //Remove non-alphanumeric chars from what we will use as the filename
            //Note those must be single quotes for it to work.
            $alphanum_trip_name = preg_replace('/[^a-zA-Z0-9\s]/', '', $event_name);
            //Shorten the trip name
            $alphanum_trip_name = substr($alphanum_trip_name,0,25);
            $alphanum_trip_name = trim($alphanum_trip_name);

            $query = "select users.user_id, first_name, last_name,
            register_date, register_status,
            email, phone_cell, emergency_contact, medical, diet, gear,
            need_ride, can_take, leaving_from, returning_to, admin_notes
            FROM users, user_events
            WHERE users.user_id=user_events.user_id
            AND event_id=$event_id
            ORDER BY register_status DESC;";

            $result = mysql_query($query);
            if (!$result) UTILdberror($query);

            $numrows = mysql_num_rows($result);
            if ($numrows < 1) {
                print "No participants found for this event.";
            } else {

                header("Content-type: text/plain");
                header("Content-Disposition: attachment; filename=\"Signup__{$alphanum_trip_name}.xls\"");

                //header("Content-type: application/csv");
                //header("Content-Disposition: attachment; filename=tripInfoSheet.csv \"");

                // header("Cache-control: private");
                // header('Pragma: private');

                echo "NAME\tREGISTER DATE\tREGISTER STATUS\tEMAIL\tCELL\tEMERGENCY CONTACT\tMEDICAL\tDIET\tGEAR\tNOTES\n";

                $x=0;
                while($row = mysql_fetch_assoc($result)) {
                    print "$row[first_name] $row[last_name]";
                    print "\t$row[register_date]";
                    print "\t$row[register_status]";
                    print "\t$row[email]";
                    print "\t$row[phone_cell]";
                    print "\t".preg_replace("/\r\n/", " || ", $row[emergency_contact] );
                    print "\t".preg_replace("/\r\n/", " || ", $row[medical] );
                    print "\t".preg_replace("/\r\n/", " || ", $row[diet] );
                    print "\t".preg_replace("/\r\n/", " || ", $row[gear] );
                    print "\t".preg_replace("/\r\n/", " || ", $row[admin_notes] );
                    print "\n";
                }
            }

        break;


        // New Profile -----------------------------------------------------------
        //

        case "New Profile":

            $user_name= UTILclean($_POST["user_name"], 40, 'User name');
            $user_password= UTILclean($_POST["user_password"], 20, 'Password');
            $first_name= UTILclean($_POST["first_name"], 20, 'First name');
            $last_name= UTILclean($_POST["last_name"], 20, 'Last name');
            $email= UTILclean($_POST["email"], 40, 'Email');
            $phone_evening= UTILclean($_POST["phone_evening"], 15, '');
            $phone_day= UTILclean($_POST["phone_day"], 15, '');
            $phone_cell= UTILclean($_POST["phone_cell"], 15, '');
            $member= UTILclean($_POST["member"], 1, '');
            $emergency_contact= UTILclean($_POST["emergency_contact"], 80, '');
            $experience= UTILclean($_POST["experience"], 500, '');
            $exercise= UTILclean($_POST["exercise"], 500, '');
            $medical= UTILclean($_POST["medical"], 500, '');
            $diet= UTILclean($_POST["diet"], 500, '');

            $event_id = $_POST["event_id"];

            if (!UTILrequiredfields()) {
                header( 'Location: ./userDetail.php');
                exit();
            }

            // Check if user_name is unique
            //
            $unique = true;
            $query = "select user_id from users where user_name='$user_name';";

            $result = mysql_query($query);
            if (!$result) UTILdberror($query);

            $numrows = mysql_num_rows($result);
            if ($numrows > 0){
                $_SESSION['Smessage'] = "This user name already exists, please choose another one.";
                $unique = false;
            }

            $query = "select email from users where email='$email';";

            $result = mysql_query($query);
            if (!$result) UTILdberror($query);

            $numrows = mysql_num_rows($result);
            if ($numrows > 0){
                $_SESSION['Smessage'] = "Another account already exists with this email address.<br>Please <a href='forgotPassword.php'>click here</a>to retrieve your password.";
                $unique = false;
            }
            if (! $unique) {
                $_SESSION['Sfirst_name']=$first_name;
                $_SESSION['Slast_name']=$last_name;
                $_SESSION['Semail']=$email;
                $_SESSION['Sphone_evening']=$phone_evening;
                $_SESSION['Sphone_day']=$phone_day;
                $_SESSION['Sphone_cell']=$phone_cell;
                $_SESSION['Smember']=$member;
                $_SESSION['Semergency_contact']=$emergency_contact;
                $_SESSION['Sexperience']=$experience;
                $_SESSION['Sexercise']=$exercise;
                $_SESSION['Smedical']=$medical;
                $_SESSION['Sdiet']=$diet;
                header("Location: ./myProfile.php");
                exit();
            }

            // Insert new profile
            //

            $query = "insert into users (
                user_name, user_password, first_name, last_name, user_type,
                email, phone_day, phone_evening, phone_cell, member,
                emergency_contact, experience, exercise, medical, diet,
                create_date) values (
                '$user_name', '$user_password', '$first_name', '$last_name', 'USER',
                '$email', '$phone_day', '$phone_evening', '$phone_cell', '$member',
                '$emergency_contact', '$experience', '$exercise',
                '$medical', '$diet', now());";

            $result = mysql_query($query);

            if (!$result)
                UTILdberror($query);

            $SUID=mysql_insert_id();
            $_SESSION['Suser_id']=$SUID;
            $_SESSION['Sfirst_name']=$first_name;
            $_SESSION['Suser_type']='USER';
            $_SESSION['Smessage'] = "Your profile has been created.";

            if ($event_id == '')
                header("Location: ./myProfile.php?user_id=$SUID");
            else
                header("Location: ./eventRegistration.php?event_id=$event_id");

            exit();

        break;


        // Update Profile -----------------------------------------------------------
        //

        case "Update Profile":

            $user_id= $_POST["user_id"];
            $user_name= UTILclean($_POST["user_name"], 40, 'User name');
            $user_password= UTILclean($_POST["user_password"], 20, 'Password');
            $first_name= UTILclean($_POST["first_name"], 20, 'First name');
            $last_name= UTILclean($_POST["last_name"], 20, 'Last name');
            $email= UTILclean($_POST["email"], 40, 'Email');
            $phone_evening= UTILclean($_POST["phone_evening"], 15, '');
            $phone_day= UTILclean($_POST["phone_day"], 15, '');
            $phone_cell= UTILclean($_POST["phone_cell"], 15, '');
            $member= UTILclean($_POST["member"], 1, '');
            $emergency_contact= UTILclean($_POST["emergency_contact"], 80, '');
            $experience= UTILclean($_POST["experience"], 500, '');
            $exercise= UTILclean($_POST["exercise"], 500, '');
            $medical= UTILclean($_POST["medical"], 500, '');
            $diet= UTILclean($_POST["diet"], 500, '');

            if (!UTILrequiredfields()) {
                header( 'Location: ./userMaint.php');
                exit();
            }

            $query = "update users set user_name='$user_name',
            user_password='$user_password', first_name='$first_name', last_name='$last_name', email='$email',
            phone_day='$phone_day', phone_evening='$phone_evening', phone_cell='$phone_cell',
            emergency_contact='$emergency_contact', member='$member', experience='$experience',
            exercise='$exercise', medical='$medical', diet='$diet'
            WHERE
            user_id=$user_id;";

            $result = mysql_query($query);

            if (!$result)
                UTILdberror($query);

            $_SESSION['Smessage'] = "Your profile has been updated.";
            header("Location: ./myProfile.php?user_id=$user_id");
            exit();

        break;

        // New Event -----------------------------------------------------------
        //

        case "New Event":

            $user_id= $_SESSION["Suser_id"];
            $event_name= UTILclean($_POST["event_name"], 100, 'Event name');
            $event_is_program=$_POST["event_is_program"];
            $program_id= $_POST["program_id"];
            $event_status=$_POST["event_status"];
            $description= UTILclean($_POST["description"], 2000, 'Event description');
            $gear_list= UTILclean($_POST["gear_list"], 2000, '');
            $trip_info= UTILclean($_POST["trip_info"], 2000, '');
            $confirmation_page= UTILclean($_POST["confirmation_page"], 2000, '');
            $question1= UTILclean($_POST["question1"], 200, '');
            $question2= UTILclean($_POST["question2"], 200, '');
            $payment_method=$_POST["payment_method"];

            //$start_date= UTILclean($_POST["start_date"], 20, '');
            //$end_date= UTILclean($_POST["end_date"], 20, '');

            if ($program_id=='')
                $program_id='-1';

            $query = "insert into events (event_name, event_status, event_is_program,
                program_id, description, gear_list, trip_info, confirmation_page,
                question1, question2, payment_method) values
                ('$event_name', '$event_status', '$event_is_program', $program_id, '$description',
                '$gear_list', '$trip_info', '$confirmation_page', '$question1', '$question2',
                '$payment_method');";

            $result = mysql_query($query);

            $event_id=mysql_insert_id();

            if (!$result)
                UTILdberror($query);

            // Insert current leader as LEADER of the trip
            $query = "insert into user_events (user_id, event_id,
                register_date, register_status) values
                ('$user_id', '$event_id', now(), 'LEADER');";

            $result = mysql_query($query);

            if (!$result)
                UTILdberror($query);

            $_SESSION['Smessage'] = "This event has been inserted into the database (eventID = $event_id).<br>You can view and administer this event from 'My Trips'.<br>The registration URL for participants is listed below.";
            header("Location: ./eventAdmin.php?event_id=$event_id");
            exit();

        break;


        // Update Event --------------------------------------------------
        //

        case "Update Event":

            $event_id= $_POST["event_id"];
            $event_name= UTILclean($_POST["event_name"], 100, 'Event name');
            $event_is_program=$_POST["event_is_program"];
            $event_status=$_POST["event_status"];
            $program_id= $_POST["program_id"];
            $description= UTILclean($_POST["description"], 2000, 'Event description');
            $gear_list= UTILclean($_POST["gear_list"], 2000, '');
            $trip_info= UTILclean($_POST["trip_info"], 2000, '');
            $confirmation_page= UTILclean($_POST["confirmation_page"], 2000, '');
            $question1= UTILclean($_POST["question1"], 200, '');
            $question2= UTILclean($_POST["question2"], 200, '');
            $payment_method=$_POST["payment_method"];

            if ($program_id=='')
                $program_id='-1';

            $query = "update events set event_name='$event_name', event_status='$event_status', event_is_program='$event_is_program',
                program_id=$program_id, description='$description', gear_list='$gear_list',
                trip_info='$trip_info', confirmation_page='$confirmation_page', question1='$question1', question2='$question2',
                payment_method='$payment_method'
                WHERE event_id=$event_id;";

            $result = mysql_query($query);

            if (!$result)
                UTILdberror($query);
            else
                $_SESSION['Smessage'] = "This event has been updated in the database.";

            header("Location: ./eventAdmin.php?event_id=$event_id");
            exit();

        break;


        // Email Password -----------------------------------------------------------
        //

        case "Send My Password":
            // Get POST vars from home.php
            //

            $user_name = UTILclean($_POST["user_name"], 50, "User Name");
            if (!UTILrequiredfields()) {
                header( 'Location: ./login.php');
                exit();
            }

            $query = "select user_id, user_password, first_name, last_name, email
            FROM users
            WHERE user_name='$user_name';";

            $result = mysql_query($query);
            if (!$result) UTILdberror($query);

            $numrows = mysql_num_rows($result);
            if ($numrows <> 1) {
                $_SESSION['Smessage'] = "Not a valid username.";
                header("Location: ./forgotPassword.php");
                exit();
            }

            $row = mysql_fetch_assoc($result);
            $first_name=$row['first_name'];
            $password=$row['user_password'];
            $email=$row['email'];

            $title="AMC Boston Chapter Registration System";

            $message="Hello $first_name,\n\nThis email is being sent due to a recent request to view your AMC Boston Chapter registration system password.\n\n
            Your username is: $user_name\n
            Your password is: $password\n\nThank you!";

            UTILsendEmail($email, $title, $message);

            $_SESSION['Smessage'] = "An email will be sent to you shortly.";

            header( 'Location: ./login.php');
            exit();

        break;


        // Email Account Info -----------------------------------------------------------
        //

        case "Send My Account Info":
            // Get POST vars from home.php
            //

            $email= UTILclean($_POST["email"], 40, 'Email');
            if (!UTILrequiredfields()) {
                header( 'Location: ./login.php');
                exit();
            }

            $query = "select user_id, user_name, user_password, first_name, last_name
            FROM users
            WHERE email='$email';";

            $result = mysql_query($query);
            if (!$result) UTILdberror($query);

            $numrows = mysql_num_rows($result);
            if ($numrows < 1) {
                $_SESSION['Smessage'] = "No account found with this email.";
                header("Location: ./forgotPassword.php");
                exit();
            }
            if ($numrows > 1) {
                $_SESSION['Smessage'] = "Warning: more than 1 account shares this email address.\n\nPlease enter your user name.";
                header("Location: ./forgotPassword.php");
                exit();
            }

            $row = mysql_fetch_assoc($result);
            $user_name=$row['user_name'];
            $first_name=$row['first_name'];
            $password=$row['user_password'];

            $title="AMC Boston Chapter Registration System";

            $message="Hello $first_name,\n\nThis email is being sent due to a recent request to view your AMC Boston Chapter registration system login information.\n\n
            Your username is: $user_name\n
            Your password is: $password\n\nThank you!";

            UTILsendEmail($email, $title, $message);

            $_SESSION['Smessage'] = "An email will be sent to you shortly.";

            header( 'Location: ./login.php');
            exit();

        break;


        default:
            echo "ERROR: Undefined action: >$action<";
        break;

    }  // End: action

?>
