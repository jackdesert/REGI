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

// Breaking out  Commonly used DIV sections
//

// include global settings (applied whereever 'utils.php' included)


//Functions for formatting source code
function IN1(){
    return "\n    ";
}


function IN2(){
    return "\n        ";
}

function IN3(){
    return "\n            ";
}

function CHUNKdatepicker(){
            $date_stuff ="
            <link rel='stylesheet' type='text/css' media='all' href='jsdatepicker/jsDatePick_ltr.min.css' />
            <script type='text/javascript' src='jsdatepicker/jsDatePick.min.1.3.js'></script>
    <script type='text/javascript'>
        window.onload = function(){
            new JsDatePick({
                useMode:2,
                weekStartDay:0,
                target:'start_date',
                dateFormat:'%m/%d/%Y'
            });
            new JsDatePick({
                useMode:2,
                weekStartDay:0,
                target:'end_date',
                dateFormat:'%m/%d/%Y'
            });
        };
    </script>";
    return $date_stuff;

}


function CHUNKgivehead($dates=''){
    if ($dates)
        $date_includes = CHUNKdatepicker();
    else
        $date_includes = '';
    print "<!DOCTYPE HTML>
<html>
<head>
    <meta charset='UTF-8'>
    <title>AMC Event Registration</title>
    <link href='http://www.hbbostonamc.org/templates/amctemplate/template_css/template_2css.css' type='text/css' rel='stylesheet' />
    <link rel='stylesheet' type='text/css' href='css/stylin.css'/>
    <link rel='shortcut icon' href='images/favicon.ico' />
    <SCRIPT type='text/javascript' src='validation.js'></SCRIPT>
    <noscript><p style='color: yellow; font-size: 120%;'>Please enable Javascript in your browser to use this site.</p></noscript>
    $date_includes
</head>
";

    return 1;
}

function CHUNKstartbody(){
    print "
<body>
    <div id='pagewrap'>
    <div id='layer10'>
";
    return 1;
}

// Note this is passing by reference. It WILL change $_SESSION that you pass in
function CHUNKstylemessage(&$session){
    $msg = '';
    if (isset($session['Smessage'])){
        $msg = $session['Smessage'];
        unset($session['Smessage']);
    }

    print "<p id='bright_msg'>{$msg}</p>
        </div>
   <div id='linked_background' onClick='location.href=\"http://www.hbbostonamc.org/index.php\";' style='cursor: pointer; width: 31%; height: 90%;'></div>
   </div>
   ";
}

function CHUNKstartcontent($user='', $event='', $tab='none'){
    print "<div id='glue'>";
    if ($tab and $event)
        if (UTILuser_may_admin($user, $event))      //Display tabs if this user has auth.
            CHUNKlefttabs($user, $event, $tab);
    print "<div id='content'>
    <br><hr>";

}

function CHUNKfinishcontent(){
    print "<br><br></div></div></div><div id='footer'>Copyright 2011 &nbsp;&nbsp;Powered by REGI-Trunk </div></body></html>";
}

function CHUNKlefttabs($user, $event, $tab){
    $st1 = '';
    $st2 = '';
    $st3 = '';
    $err = '';
    $id_string = " id='selected_tab'";
    $class_string = " class='tab'";
    if ($tab == 'my')
        $st1 = $id_string;
    elseif ($tab == 'roster')
        $st2 = $id_string;
    elseif ($tab == 'admin')
        $st3 = $id_string;
    else
        $err = "<div>Tab\n Not \nSelected</div>";
    print "
<div id='tabs'>

<div{$st1}{$class_string} style='cursor: pointer;' onClick='location.href=\"{$event}\"'>Event Info</div>
<div{$st2}{$class_string} style='cursor: pointer;' onClick='location.href=\"{$event}~roster\"'>Roster</div>
<div{$st3}{$class_string} style='cursor: pointer;' onClick='location.href=\"{$event}~admin\"'>Admin</div>
{$err}
</div>";
}

function CHUNKdropdown($input, $selected_input){
    if ($input == $selected_input){
        $selected = " selected='selected'";
        $new_value = "*";   // The star indicates no change, so no email will be sent
    }else{
        $selected = '';
        $new_value = $input;
    }
    print "<option value='{$new_value}'{$selected}>{$input}";

}

function CHUNKtriplistings(){
    $url = "http://www.hbbostonamc.org/trips.php";
    $html = file_get_contents($url);
    $trimmed = CHUNKtrimtrips($html);
    print $trimmed;
    return 0;

}

function CHUNKtrimtrips($in_html){
    $begin = '<div style="padding-left:20px; width:90%;">';
    $end = '</div></body></html>';  //Note there are carriage returns in the real thing
    $topless = strstr($in_html, $begin);
    $topless = str_replace($begin, '<div>', $topless);

    //Remove the $end material by finding hte last </div>
    //note there are two 'r's in the function name, indicating reverse
    $index = strrpos($topless, '</div>');
    $topless_and_bottomless = substr($topless, 0, $index);
    $trimmed = trim($topless_and_bottomless);
    $links_here = CHUNKlinksopenhere($trimmed);
    return $links_here;


}
function CHUNKlinksopenhere($in_html){
    $open_same_window = str_replace('target="_new"', '', $in_html);
    $go_local = str_replace('href="http://www.hbbostonamc.org/registrationSystem/', 'href="./', $open_same_window);
    $short_urls_too = str_replace('href="http://hbbostonamc.org/regi/', 'href="./', $go_local);
    return $short_urls_too;
}

function CHUNKhikerating($rating, $edit = false){
    if ($edit == true){
        $show_rating_too = "<div style='float:left;'> (Example: <i>B3B</i>, also see the&nbsp;&nbsp;</div>";
    }else{
        $show_rating_too = "<div class='indented' style='float:left;'>Hike Rating: <b>".$rating." </b>&nbsp;&nbsp;(</div>";
    }
    $stuff=$show_rating_too . "
    <div class='hike_rating'>
    <a href='http://www.hbbostonamc.org/index.php/Table/Key-to-Hike-Ratings/' target='_blank'>Hike Rating Key</a>)
    <div class='visible_on_hover'>
    <div class='row0'>
    <h2>Hike Rating Quick Reference</h2>
    (Click link to see full reference.)
    </div>

    <div class='row1'>
    <dl>
        <dt>First letters indicate <b>mileage</b>:</dt>
        <dd>AA = 13 mi and over</dd>
        <dd>A = 9 to 13 mi</dd>
        <dd>B = 5 to 9 mi</dd>
        <dd>C = under 5 mi</dd>
    </dl>
    </div>
    <div class='row0'>
    <dl>
        <dt>Middle number indicates <b>pace</b> across &quot;average&quot; terrain:</dt>
        <dd>1 = very fast (2.5 mph+)</dd>
        <dd>2 = fast (2 to 2.5 mph)</dd>
        <dd>3 = moderate (1.5 to 2 mph)</dd>
        <dd>4 = leisurely (0.5 to 1.5 mph)</dd>
    </dl>
    </div>
    <div class='row1'>
    <dl>
        <dt>End letters indicate <b>terrain</b>:</dt>
        <dd>A = very strenuous</dd>
        <dd>B = strenuous</dd>
        <dd>C = average</dd>
        <dd>D = easy</dd>
    </dl>
    </div>

    <div class='row0'>
    <dl>
        <dt>Example: <b>B3B</b></dt>
        <dd>5-9 miles (B)</dd>
        <dd>moderately paced (3)</dd>
        <dd>on strenuous terrain (B)</dd>
    </dl>
    </div>



    </div>
    </div>";
    print $stuff;
    return $stuff;
}

/* Cut material from hike rating:
 *
 *     <div class='row0'>
    <dl>
        <td>Notes:</td>
        <dd>Terrain ratings may not match Connecticut or Southeastern Massachusetts values.</dd>
        <dd>Backpacks rate the most difficult day of hiking planned.</dd>
        <dd>Some ratings may have an additional two letters at the end, these indicate a terrain level between the values.</dd>
        <dd>Actual trip pace may differ from the pace number if terrain is not &quot;average&quot;.</dd>
    </dl>
    </div>
    *
    * */


/*Note there is purposefully no closing php tag here, because
if you accidentally put extra characters (even line breaks)
after a closing php tag, you will get a warning when this
file is included in another file. Such a warning can wreak
havoc when the warning ends up inside an Excel export. (It's
gibberish. So I'm removing this closing tag */

