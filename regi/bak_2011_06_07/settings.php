<?php
	// Global Settings

	// Database
	//

	$SET_DB_HOST		= "localhost";

	$SET_DB_USER		= "hbboston_admin";
	$SET_DB_PASSWORD	= "admin";

	$SET_DB_NAME		= "hbboston_amcreg";

	// Upload files / Images
	//

	$SET_MAX_PHOTO_LEN	= 30000;
	$SET_MAX_FIGURE_LEN	= 30000;

	// For windows, use back slashes
	//$SET_IMG_FILE_DIR		= ".\\image_files\\";
	// For unix/linux, use forward slashes
	$SET_IMG_FILE_DIR		= "./image_files/";


	// Set these secret settings in the Paypal profile
	//	- note, these values are sent via GET by paypal
	//	- and are visible on the server access logs

	$SET_PAYPAL_SECRET_VAR = "tobe";
	$SET_PAYPAL_SECRET_VAL = "ornottobe";

?>