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
function registrar_also_means(){
    $also = "\n\nAs a registrar, you will not be participating in the event. But you get all the other perks of being a leader. ";
    return $also;
}

function congrats_admin($reg_status, $event_name){
    $congrats = "Congratulations! You are now listed as a $reg_status for the following event: $event_name. ";
    return $congrats;
}
function regi_link($event_id){
    $link = "http://hbbostonamc.org/regi/$event_id";
    $sentence = "You may view this event online at $link. ";
    return $sentence;
}

function waitlist_means(){
    $wait = "Waitlist means...";
}
function contact_leader(){
    return "\n\nPlease contact the event leader if you have any questions.";
}

function thank($reg_status){
    return "\n\nThank you for being a $reg_status!\n\n";
}
function reg_status_email($first_name, $reg_status, $event_name, $event_id){
    $reg_status = strtolower($reg_status);
    $bit = "Hello $first_name,\n\n";
    switch($reg_status) {
        case "leader":
            $bit .= congrats_admin($reg_status, $event_name);
            $bit .= regi_link($event_id);
            $bit .= leader_means();
            $bit .= thank($reg_status);
        break;
        case "coleader":
            $bit .= congrats_admin($reg_status, $event_name);
            $bit .= regi_link($event_id);
            $bit .= leader_means();
            $bit .= thank($reg_status);
        break;
        case "registrar":
            $bit .= congrats_admin($reg_status, $event_name);
            $bit .= regi_link($event_id);
            $bit .= registrar_also_means();
            $bit .= leader_means();
            $bit .= thank($reg_status);
        break;
        case "approved":
            $bit .= "Congratulations! You have been approved to participate in the following event: $event_name. ";
            $bit .= regi_link($event_id);
            $bit .= contact_leader();
        break;
        case "waitlist":
            $bit .= "You are on the wait list for the following event: $event_name. ";
            $bit .= waitlist_means();
            $bit .= regi_link($event_id);
            $bit .= contact_leader();
        break;
        case "canceled":
            $bit .= "You are no longer registered for the folling event: $event_name.\n\n";
            $bit .= "If you believe this is a mistake, please contact the event leader.\n\n";
        break;


    }
    return $bit;
}

/*Note there is purposefully no closing php tag here, because
if you accidentally put extra characters (even line breaks)
after a closing php tag, you will get a warning when this
file is included in another file. Such a warning can wreak
havoc when the warning ends up inside an Excel export. (It's
gibberish. So I'm removing this closing tag */

