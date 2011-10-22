<?php

/*
    AMC Event Registration System
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
function leader_means(){
    $means = "\n\nYou (along with all the other leaders, coleaders, and registrars of this event) will receive an email any time someone registers for this event. ";
    $means .= "You can also administer this trip as follows: From the Roster tab, you can approve other registrants, export an Excel spreadsheet of registrants, and send emails to approved participants. ";
    $means .= "From the Admin tab, you can update the event details. ";
    return $means;
}

function congrats_admin($reg_status, $event_name){
    $up = strtoupper($reg_status);
    $congrats = "Congratulations! You are now listed as a $up for the following event: $event_name. ";
    return $congrats;
}
function regi_link($event_id){
    $link = "http://hbbostonamc.org/regi/$event_id";
    return $link;
}

function regi_link_sentence($event_id){
    $link = regi_link($event_id);
    $sentence = "You may view the REGI page for this event at $link. ";
    return $sentence;
}

function waitlist_means(){
    $wait = "If a spot becomes available, you will be notified. ";
    return $wait;
}
function contact_leader(){
    return "\n\nPlease contact the event leader if you have any questions.";
}

function thank($reg_status){
    return "\n\nThank you for being a $reg_status!\n\n";
}
function reg_status_email($first_name, $reg_status, $event_name, $event_id){
    $reg_status = strtolower($reg_status);
    $bit = "$first_name,\n\n";
    // Note the database uses a dash in "co-leader"
    $reg_status = str_replace("-", "", $reg_status);
    switch($reg_status) {
        case "leader":
            $bit .= congrats_admin($reg_status, $event_name);
            $bit .= regi_link_sentence($event_id);
            $bit .= leader_means();
            $bit .= thank($reg_status);
            break;
        case "coleader":
            $bit .= congrats_admin($reg_status, $event_name);
            $bit .= regi_link_sentence($event_id);
            $bit .= leader_means();
            $bit .= thank($reg_status);
            break;
        case "registrar":
            $bit .= congrats_admin($reg_status, $event_name);
            $bit .= regi_link_sentence($event_id);
            $bit .= leader_means();
            $bit .= thank($reg_status);
            break;
        case "approved":
            $bit .= "Congratulations! You have been APPROVED to participate in the following event: $event_name. ";
            $bit .= regi_link_sentence($event_id);
            $bit .= "\n\nCARPOOL\n";
            $bit .= "Carpooling is good for the environment, and a great way to get to know people. ";
            $bit .= "We encourage you to contact other participants and find ways to share transportation. ";
            $bit .= "You can update your carpool information and view the carpool information for other ";
            $bit .= "participants by going to the REGI site for the event:  ";
            $bit .= regi_link($event_id);
            $bit .= ".";
            $bit .= contact_leader();
            break;
        case "waitlist":
            $bit .= "You are on the WAIT LIST for the following event: $event_name. ";
            $bit .= waitlist_means();
            $bit .= regi_link_sentence($event_id);
            $bit .= contact_leader();
            break;
        case "canceled":
            $bit .= "You are no longer registered for the following event: $event_name. ";
            $bit .= "If you believe this is a mistake, please contact the event leader.\n\n";
            $bit .= regi_link_sentence($event_id);
            break;
        default:    // This should never be reached.
            $up = strtoupper($reg_status);
            $bit .= "Your registration status has been updated to $up for the following event: $event_name.\n\n";
            $bit .= regi_link_sentence($event_id);
            //log the error
            $mail_error = "Case not found in emails.php.";
            $mail_error .= "\nreg_status: " . $reg_status;
            $mail_error .= "\nevent_id: " . $event_id;
            UTILlog($mail_error);

    }
    return $bit;
}


function new_leader_email($first_name, $approve = true) {
    global $SET_SUPPORT_EMAIL;
    $bit = "$first_name,\n\n";
    if ($approve) {
        $bit .= "You are now a leader in REGI. Please log out of REGI, then log back in for this to take effect. \n\n";
        $bit .= "http://hbbostonamc.org/regi";

    }else{
        $bit .= "According to our records, you are not an AMC leader. So you have not been ";
        $bit .= "made a leader in REGI. If you believe this is a mistake, please contact us at $SET_SUPPORT_EMAIL.\n\n";
        $bit .= "http://hbbostonamc.org/regi/support";
    }

    return $bit;
}



/*Note there is purposefully no closing php tag here, because
if you accidentally put extra characters (even line breaks)
after a closing php tag, you will get a warning when this
file is included in another file. Such a warning can wreak
havoc when the warning ends up inside an Excel export. (It's
gibberish. So I'm removing this closing tag */

