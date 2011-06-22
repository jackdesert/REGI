<!--

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

-->
<?php
    include 'utils.php';
    session_start();
    UTILdbconnect();
    CHUNKgivehead();
    CHUNKstartbody();
    UTILbuildmenu();
    CHUNKstylemessage($_SESSION['Smessage']);
    CHUNKstartcontent();
?>

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
    If any of the above makes sense to you, click the back button in your browser and try again. <br><br>
    Otherwise, please return to <a href="http://www.hbbostonamc.org/trips.php">Trip Listings</a> or <a href="./login.php">Login page</a>.
    <br><br>
<?php CHUNKfinishcontent(); ?>
</div>   <!-- outerframe -->

</body>
</html>
