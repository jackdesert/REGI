<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>MACC</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/javascript" src="http://maccweb.org/js/menus.js"></script>
 <script language="JavaScript" src="http://maccweb.org/mm_menu.js"></script>
 <link href="http://maccweb.org/CSS/Level1_Arial.css" rel="stylesheet" type="text/css">
 <style type="text/css">
<style>
a:link{text-decoration: none;}
 body,td,th {
	font-family: Verdana, Arial, Helvetica, "Trebuchet MS", sans-serif;
	font-size: 12px;
}
 h1 {
	font-size: 18px;
	color: #000;
}
 h2 {
	font-size: 14px;
	color: #000;
}
 body {
	background-image: url(http://maccweb.org/img/clouds-book-bkd.gif);
	color: #000;
}
 </style>
</head>

<body bgcolor="#EEEEFC" link="#000000" vlink="#000000" leftmargin="0" topmargin="0"><body leftmargin="0" topmargin="0"> <body leftmargin="0" topmargin="0">
<table width="759" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="760" bgcolor="#000000"><img src="http://maccweb.org/img/banner_01.jpg" alt="" width="759" height="64"></td>
  </tr>
  <tr>
    <td height="32" bgcolor="#000000"><img src="http://maccweb.org/img/banner_03.gif" alt="" width="99" height="32"><a href="http://maccweb.org/index.html" onMouseOver="MM_showMenu(window.mm_menu_0211005850_0,0,21,null,'image9')" onMouseOut="MM_startTimeout();"><img src="http://maccweb.org/img/banner_04.gif" alt="" name="image9" width="48" height="32" border="0" id="image9"></a><a href="http://maccweb.org/edu.html" onMouseOver="MM_showMenu(window.mm_menu_0205213153_0,0,21,null,'image1')" onMouseOut="MM_startTimeout();"><img src="http://maccweb.org/img/banner_05.gif" alt="" name="image1" width="75" height="32" border="0" id="image1"></a><a href="http://maccweb.org/advocacy.html" onMouseOver="MM_showMenu(window.mm_menu_0205215445_0,0,21,null,'image2')" onMouseOut="MM_startTimeout();"><img src="http://maccweb.org/img/banner_06.gif" alt="" name="image2" width="68" height="32" border="0" id="image2" color="#00000"></a><a href="http://maccweb.org/resources.html" onMouseOver="MM_showMenu(window.mm_menu_0210170912_0,0,21,null,'image3')" onMouseOut="MM_startTimeout();"><img src="http://maccweb.org/img/banner_07.gif" alt="" name="image3" width="74" height="32" border="0" id="image3"></a><a href="http://maccweb.org/biodiversity.html" onMouseOver="MM_showMenu(window.mm_menu_0210231747_0,0,21,null,'image6')" onMouseOut="MM_startTimeout();"><img src="http://maccweb.org/img/banner_08.gif" alt="" name="image6" width="81" height="32" border="0" id="image6"></a><a href="http://maccweb.org/about.html" onMouseOver="MM_showMenu(window.mm_menu_0210172108_0,0,21,null,'image4')" onMouseOut="MM_startTimeout();"><img src="http://maccweb.org/img/banner_09.gif" alt="" name="image4" width="65" height="32" border="0" id="image4"></a><a href="http://maccweb.org/support.html" onMouseOver="MM_showMenu(window.mm_menu_0210173038_0,-50,21,null,'image5')" onMouseOut="MM_startTimeout();"><img src="http://maccweb.org/img/banner_10.gif" alt="" name="image5" width="58" height="32" border="0" id="image5"></a><a href="http://maccweb.org/products_services.html" onMouseOver="MM_showMenu(window.mm_menu_0211003036_0,-15,21,null,'image7')" onMouseOut="MM_startTimeout();"><img src="http://maccweb.org/img/banner_11.gif" alt="" name="image7" width="130" height="32" border="0" id="image7"></a><a href="http://maccweb.org/contact.html" onMouseOver="MM_showMenu(window.mm_menu_0211003924_0,-100,21,null,'image8')" onMouseOut="MM_startTimeout();"><img src="http://maccweb.org/img/banner_12.gif" alt="" name="image8" width="61" height="32" border="0" id="image8"></a></td>
  </tr>
</table>
<script language="JavaScript1.2">mmLoadMenus();</script>

<table  width="760" width="759" border="0" align="center" cellpadding="5" cellspacing="0">
<tr valign="top" border="0" cellpadding="0" cellspacing="0"><td border="0" cellpadding="0" cellspacing="0">

<?php

function whereAmI(){
    //calculate path to come back to same directory
    $script_path = $_SERVER['SCRIPT_NAME'];
    $pattern = '/\/.*\//';
    preg_match($pattern, $script_path, $match_array);
    $script_dir = $match_array[0];
    $script_dir = str_replace('/forms', '', $script_dir);
    $script_dir_no_trail = substr($script_dir, 1, -1);
    print "<br>";
    print "<div class='title' align='center'>$script_dir_no_trail</div>";
    print "<div align='center' ><a href='http://www.maccweb.org/resources_templates.html'>Back to MACC Electronic Resource Center</a> </div>";
    print "<br>";
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
    print "<br>";
}
whereAmI();
getDirectory();
?>

</td>
</tr>
</table>
</body>
</html>


