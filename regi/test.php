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

        // Login validation -----------------------------------------------------------
        //

            $user_id= 838;
            $event_name= "big name hot dog here";
            $event_is_program="N";
            $program_id= '100';
            $event_status='FULL';
            $description= 'blah blah blah blah';
            $gear_list= 'blah blah blah blah';
            $trip_info= 'blah blah blah blah';
            $confirmation_page= 'blah blah blah blah';
            $question1= 'blah blah blah blah';
            $question2= 'blah blah blah blah';
            $payment_method='none';
            $start_date= '0000-00-00';
            $end_date='2000-10-10';

            //$start_date= UTILclean($_POST["start_date"], 20, '');
            //$end_date= UTILclean($_POST["end_date"], 20, '');

            if ($program_id=='')
                $program_id='-1';


            mysql_query("set sql_mode = 'no_zero_date,traditional';");


            $query = "insert into events (event_name, event_status, event_is_program,
                program_id, description, gear_list, trip_info, confirmation_page,
                question1, question2, payment_method, start_date, end_date) values
                ('$event_name', '$event_status', '$event_is_program', $program_id, '$description',
                '$gear_list', '$trip_info', '$confirmation_page', '$question1', '$question2',
                '$payment_method', '$start_date', '$end_date' );";

            $result = mysql_query($query);
            print mysql_error();

            $event_id=mysql_insert_id();

            if (!$result)
                UTILdberror($query);

            // Insert current leader as LEADER of the trip
            $query = "insert into user_events (user_id, event_id,
                register_date, register_status) values
                ('$user_id', '$event_id', now(), 'LEADER');";


            $result = mysql_query($query);
            print mysql_error();

            if (!$result)
                UTILdberror($query);

            $_SESSION['Smessage'] = "This event has been inserted into the database (eventID = $event_id).<br>You can view and administer this event from 'My Trips'.<br>The registration URL for participants is listed below.";
            header("Location: ./eventAdmin.php?event_id=$event_id");
            exit();

?>
