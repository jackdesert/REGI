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

// Common Utilities
//

    // include global settings (applied whereever 'utils.php' included)
    include 'settings.php';

    //return date format
    function UTILdate($datestr) {
        return date('M j, Y', strtotime($datestr));
    }

    //return date+time format
    function UTILtime($timestr) {
        return date('M j, Y h:m', strtotime($timestr));
    }

    // Build top menu
    function UTILbuildmenu() {

        print "<a href=\"http://www.hbbostonamc.org/trips.php\" >Back to HB Trip Listings</a> | ";

        if (isset($_SESSION['Suser_id'])) {

            if ($_SESSION['Suser_type'] == 'ADMIN' || $_SESSION['Suser_type'] == 'LEADER')
                print "<a href=\"eventAdmin.php\" >Create New Event</a> | ";

            print "<a href=\"myTrips.php\" >My Trips</a> | ";
            print "<a href=\"myProfile.php\" >My Profile</a> | ";

            print "<a href=\"logout.php\" >Logout</a>";
        }
        else
        {
            print "<a href=\"login.php\" >Login</a>";
        }

        print "</font><br>";
    }

    // DB Connect
    //

    function UTILdbconnect() {

        global $SET_DB_HOST, $SET_DB_USER, $SET_DB_PASSWORD, $SET_DB_NAME;

        $dbconn = mysql_pconnect("$SET_DB_HOST", "$SET_DB_USER", "$SET_DB_PASSWORD");
        if (!$dbconn) {
            UTILlog(mysql_error());
            header("Location: ./errorPage.php?errTitle=Database Error&errMsg=" . mysql_error());
            exit();
        }
        mysql_select_db("$SET_DB_NAME", $dbconn);
        return 1;
    }

    // Web field cleanup (escape chars.) and trim to max length
    //  - 1) escape + XSS attack handling via: htmlspecialchars()
    //      - escapes symbols: &, ', ", <, >
    //  - 2) trim via substr()
    // TBD  - 2) trim via mb_substr() - multi-byte safe string truncation

    //  Other functions:
    //  - mysql_real_escape_string() to escape '''
    //  - for XSS attack: htmlentities(), htmlspecialchars(), strip_tags()

    function UTILclean($field, $max_len, $req_field) {
        if ($max_len == 0) $max_len = 3000;     // 3000 chars. (~500 words) is the default max len.

        if ($req_field != '' && $field == '')
            $_SESSION['reqfields'].="$req_field . ";

        // TBD: check for obvious XSS attacks?  "<script" token

        return substr(htmlspecialchars($field, ENT_QUOTES), 0, $max_len);
    }


    // Check for validation error chain
    //

    function UTILrequiredfields() {

        if (isset($_SESSION['reqfields'])) {
            echo "Required fields missing:<br>$_SESSION[reqfields]";
            $_SESSION['Smessage'] = "The following are required fields: ".$_SESSION['reqfields'];
            unset($_SESSION['reqfields']);
            return 0;
        }
        return 1;
    }


    // return string proportional size refit: width="" height=""
    //  $size: size[0] = width, size[1] = height
    //  $target: max pixels in either X or Y

    function UTILimageResize($size, $target) {

        if ($size[0] < 5 && $size[1] < 5)
            return "width=\"0\" height=\"0\"";

        if ($size[0] > $size[1]) {
            $percentage = ($target / $size[0]);
        } else {
            $percentage = ($target / $size[1]);
        }

        //gets the new value and applies the percentage, then rounds the value
        $width = round($size[0] * $percentage);
        $height = round($size[1] * $percentage);

        return "width=\"$width\" height=\"$height\"";
    }


    // Upload external image file (name='photo')
    //

    function UTILuploadphoto($localfname) {

        //global $SET_MAX_PHOTO_LEN, $SET_IMG_FILE_DIR;
        $SET_MAX_PHOTO_LEN = 1000000;
        $SET_IMG_FILE_DIR = "./image_files/";

        $uploadfile = "";
        $filetmp = $_FILES['photo']['tmp_name'];
        $filesize = $_FILES['photo']['size'];
        $filetype = $_FILES['photo']['type'];
        $fileerr = $_FILES['photo']['error'];

        //UTILlog ("FILE UPLOAD: TMP FILE: $filetmp (FILE ERROR: $fileerr)".
        //  "\r\nFILE SIZE: $filesize  FILE TYPE: ".basename($filetype));

        if ($filesize > $SET_MAX_PHOTO_LEN) {
            $_SESSION['Smessage'] = "Note: File attachment too big: $filesize bytes. Must be $SET_MAX_PHOTO_LEN or less.";
            return -1;
        } elseif ($filesize > 100) {

            if ($filetype != 'image/jpeg' && $filetype != 'image/gif' && $filetype != 'image/pjpeg') {
                $_SESSION['Smessage'] = "Note: File attachment wrong type, must be either a gif or jpeg.";
                return -1;
            }

            $uploadfile = $localfname.'.'.basename($filetype);
            $uploadfilewithpath = $SET_IMG_FILE_DIR . $uploadfile;

            if (move_uploaded_file($filetmp, $uploadfilewithpath )) {
                UTILlog ("File: >$filetmp< was successfully uploaded to >$uploadfilewithpath<");
            } else {
                UTILlog ("ERROR moving File: >$filetmp< to >$uploadfilewithpath<");
            }
        }

        return $uploadfile;
    }

    // DB Error
    //

    function UTILdberror($query) {

        UTILlog("QUERY:".$query."\r\nERROR CODE:".mysql_errno()."\r\nERROR:".mysql_error());

        // ROLLBACK TRANSACTION
        //  - if there is a transaction

        $result_trans = mysql_query('ROLLBACK;');
        if (!$result_trans) UTILlog('DB ERROR : Unable to Rollback Transaction');

        $errmess = mysql_error();
        header("Location: ./errorPage.php?errTitle=Database Error&errMsg=".$errmess);
        exit();
    }


    // log
    //

    function UTILlog($mess) {

        $File = "./log/errorlog.log";
        $Handle = fopen($File, 'a+');

        $today = date("F j, Y, g:i a"); // Ex: March 10, 2001, 5:16 pm

        fwrite($Handle, "\r\n------------------------------------------\r\n$today\r\n------------------------------------------\r\n" . $mess);
        fclose($Handle);

        //print "System Message: ".$today." : ".$mess;
    }


    // Functions to convert arrays to strings, and vice-versa
    //  - from a post at http://us2.php.net/array

    // Converts an array to a string that is safe to pass via a URL
    function array_to_string($array) {
      $retval = '';
      foreach ($array as $index => $value) {
          $retval .= urlencode(base64_encode($index)) . '|' . urlencode(base64_encode($value)) . '||';
       }
       return urlencode(substr($retval, 0, -2));
    }

    // Converts a string created by array_to_string() back into an array.
    function string_to_array($string) {
     $retval = array();
      $string = urldecode($string);
      $tmp_array = explode('||', $string);

        foreach ($tmp_array as $tmp_val) {
            list($index, $value) = explode('|', $tmp_val);
            $retval[base64_decode(urldecode($index))] = base64_decode(urldecode($value));
        }
        return $retval;
    }

    // Send Email to BCC list (1 or many users)
    //  - Requires: SMTP mail server

    function UTILsendEmail($bcc, $title, $message) {

        //define the headers we want passed. Note that they are separated with \r\n

        $headers = "Content-Type: text/plain; charset=\"utf-8\"\r\n";
        $headers.= "From: AMC.Trip.Registration\r\nReply-To: Please.do.not.reply\r\nBcc: ".$bcc;

        $footer = "\n\n-----------------------------------------------------------------------\n";
        $footer.= "This email was sent to you by the AMC Boston Chapter trip registration system.\n";
        $footer.= "All email addresses are kept confidential.";

        //send the email
        $mail_sent = mail("", $title, $message.$footer, $headers);

        if (!$mail_sent)
            UTILlog("ERROR: email not sent FROM: ($SUID) TO: ($bcc) TITLE: ($title)");
    }


?>
