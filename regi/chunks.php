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

function CHUNKgivehead(){
    print "
<!DOCTYPE HTML>
<html>
<head>
    <title>AMC Event Registration</title>
    <meta http-equiv='Content-Type' content='text/html; charset='UTF-8' />
    <link href='http://www.hbbostonamc.org/templates/amctemplate/template_css/template_2css.css' type='text/css' rel='stylesheet' />
    <link rel='stylesheet' type='text/css' href='css/stylin.css'/>
    <SCRIPT type='text/javascript' src='validation.js'></SCRIPT>
</head>
";

    return 1;
}

function CHUNKstartbody(){
    print "
<body>
    <div id='pagewrap'>
    <div id='layer10' onClick='location.href=\"http://www.hbbostonamc.org/index.php\";' style='cursor:pointer;'>
";
    return 1;
}

function CHUNKstylemessage($msg){
    print "<b><p id='bright_msg'>{$msg}</p></b>
        </div>
   </div>
   ";
}

function CHUNKstartcontent(){
    print "<div id='glue'>";
    CHUNKlefttabs();
    print "<div style='padding-left:20px; width:90%;'>
    ";

}

function CHUNKfinishcontent(){
    print "</div></div>";
}

function CHUNKlefttabs(){
    print "
<div id='tabs' style='float: left;'>

<p>top</p>
<p>middle</p>
<p>bottom</p>
</div>";
}
?>
