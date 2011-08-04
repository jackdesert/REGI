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

// Slim page
// This redirects things to the right place so we can have ultra-short URLs

    include 'utils.php';
    session_start();
    UTILdbconnect();

    $uri = $_SERVER['REQUEST_URI'];
    // Looking for everything in the URI after the last forward slash
    $pattern = "/[^\/]+$/";
    preg_match($pattern, $uri, $match_array);
    $last_bit = $match_array[0];
    if (is_numeric($last_bit)){
        $event_id = $last_bit;
        $query = "select event_id FROM events WHERE event_id=$event_id;";
        $result = mysql_query($query);
        if (!$result) UTILdberror($query);
        $numrows = mysql_num_rows($result);
        if ($numrows == 1) {
            //Redirect to the appropriate page
            header("Location: ./".$event_id);
            exit();
        }
    }


    CHUNKgivehead();
    CHUNKstartbody();
    UTILbuildmenu(3);
    CHUNKstylemessage($_SESSION);
    CHUNKstartcontent();
    print "<h1>Invalid URL</h1>";
    print "Please make sure you typed the web address (URL) correctly.";
    CHUNKfinishcontent();
