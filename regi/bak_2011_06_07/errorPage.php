<!--

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

-->

<html>
<head>
	<title>AMC Trip Registration</title>
	<meta http-equiv="Content-Type" content="text/html; charset="UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
	<SCRIPT type="text/javascript" src="validation.js"></SCRIPT>

<link href="http://www.hbbostonamc.org/templates/amctemplate/template_css/template_2css.css" type="text/css" rel="stylesheet" />
</head>
<body>
<div id="pagewrap">
   <div id="layer10" onClick="location.href='http://www.hbbostonamc.org/index.php';" style="cursor:pointer;">

		<?php
			include 'utils.php';
			session_start();
			//echo UTILbuildMenu('');
		?>

   </div>
   <div style="padding-left:20px; width:90%;">

	<?php

		if (isset($_GET['errTitle']))
			$Errtitle = $_GET['errTitle'];
		else
			$Errtitle = 'Application Error';

		if (isset($_GET['errMsg']))
			$Errbody = $_GET['errMsg'];
		else
			$Errbody = '';

		print "<h1>$Errtitle</h1><br><br>";
		print "<b>$Errbody</b>";

	?>

	<br><br>
	<br><br>
	Please return to <a href="http://www.hbbostonamc.org/trips.php">Trip Listings</a> or <a href="./login.php">Login page</a>.
	<br><br>

</div>   <!-- outerframe -->

</body>
</html>