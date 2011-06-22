<?php

include 'utils.php';
session_start();
UTILdbconnect();
UTIL_gen_all_passhashes();
print "<html><body>Done.</body></html>";

?>
