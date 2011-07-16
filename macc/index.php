<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>MACC</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/javascript" src="../js/menus.js"></script>
 <script language="JavaScript" src="../mm_menu.js"></script>
 <link href="../CSS/Level1_Arial.css" rel="stylesheet" type="text/css">
 <style type="text/css">
<style>
a:link{text-decoration: none;}
a:hover {
  text-decoration: underline;
}
body{
    font-family: Arial;
    font-size:  90%;
}
h1,h2,h3,h4,h5,.title{
    font-family: Georgia, Times New Roman;
    line-height:    100%;
    padding-top:    1em;}
.title{font-size: 200%;}
h1{font-size: 120%}
h2{font-size: 110%}
h3{font-size: 100%}
h4{font-size: 90%}
h5{font-size: 80%}
.level_1, h1{padding-left: 5%;}
.level_2, h2{padding-left: 10%;}
.level_3, h3{padding-left: 15%;}
.level_4, h4{padding-left: 20%;}
.level_5, h5{padding-left: 25%;}

 </style>
</head>

<body bgcolor="#EEEEFC" background="../img/water.gif" link="#000000" vlink="#000000" leftmargin="0" topmargin="0"><body leftmargin="0" topmargin="0"> <body leftmargin="0" topmargin="0">
<script language="JavaScript1.2">mmLoadMenus();</script>
<table align="center" width="759" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="760" bgcolor="#000000"><a href="http://www.maccweb.org/resources_templates.html"><img src="http://www.maccweb.org/Images/emacc_banner.jpg" width="759" height="96" border="0" longdesc="http://www.maccweb.org/Images/emacc_banner.jpg"></a></td>
  </tr>
</table>

<table  width="760" bgcolor="adbcc9" width="759" border="0" align="center" cellpadding="5" cellspacing="0">
<tr valign="top" bgcolor="d1d9d5" border="0" cellpadding="0" cellspacing="0"><td border="0" cellpadding="0" cellspacing="0">

<?php

function whereAmI(){
    //calculate path to come back to same directory
    $script_path = $_SERVER['SCRIPT_NAME'];
    $pattern = '/\/.*\//';
    preg_match($pattern, $script_path, $match_array);
    $script_dir = $match_array[0];
    $script_dir_no_trail = substr($script_dir, 1, -1);
    print "<div class='title' align='center'>$script_dir_no_trail</div>";
    print "<div align='center' ><a href='http://www.maccweb.org/resources_templates.html'>Back to MACC Electronic Resource Center</a> </div>";
}

function getDirectory( $path = '.', $level = 0 ){

    $ignore = array( 'cgi-bin', '.', '..','.git','index.php','resources_links.html','resources_templates.html','run.rb','indexbu.php','backups' );
    // Directories to ignore when listing output. Many hosts
    // will deny PHP access to the cgi-bin.
    $myDirs = array();
    $myFiles = array();
    $dh = @opendir( $path );
    // Open the directory to the handle $dh
    while( false !== ( $temp = readdir( $dh ) ) ){
        if( is_dir( "$path/$temp" ) ){
            $myDirs[] = $temp;
            //print "Found a directory: ";
            //print $temp.'\n';
        }
        else{
            $myFiles[] = $temp;
            //print "Found a file: ";
            //print $temp.'\n';
        }
    }

    if ($myDirs)
        sort($myDirs);
    if ($myFiles)
        sort($myFiles);

    $myArray = array_merge($myDirs, $myFiles);
    foreach($myArray as $file){
    $pretty_file = str_replace("_"," ",$file);


    // Loop through the directory

        if( !in_array( $file, $ignore ) ){
        // Check that this file is not to be ignored

            // Just to add spacing to the list, to better
            // show the directory tree.
            $heading_level = $level + 1;

            if( is_dir( "$path/$file" ) ){
            // Its a directory, so we need to keep reading down...
                print "<h{$heading_level}>";

                print "<strong>$pretty_file</strong><br />";
                print "</h{$heading_level}>\n";
                getDirectory( "$path/$file", ($level+1) );
                // Re-call this same function but on a new directory.
                // this is what makes function recursive.

            } else {
                print "<div class='level_{$heading_level}'>";
                print "<a href='{$path}/{$file}'>$pretty_file</a><br />";
                print "</div>\n";
                // Just print out the filename

            }

        }


    }


    closedir( $dh );
    // Close the directory handle

}
whereAmI();
getDirectory();
?>

</td>
</tr>
</table>
</body>
</html>


