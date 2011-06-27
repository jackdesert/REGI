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
    UTILbuildmenu(1);
    CHUNKstylemessage($_SESSION);

?>


<?php CHUNKstartcontent(); ?>
<h1>Support</h1>
Here is where a lot of Question and Answer goes on.
But until then, you email for help <a class='menu' href='mailto:amcbostonhbs@gmail.com?subject=Help With REGI Site' >here</a>.

<br>
Q:<br>
A:<br>
Q:<br>
A:<br>
Q:<br>
A:<br>
Q:<br>
A:<br>
Q:<br>
A:<br>
Q:<br>
A:<br>
Q:<br>
A:<br>
Q:<br>
A:<br>
Q:<br>
A:<br>
Q:<br>
A:<br>
Q:<br>
A:<br>
Q:<br>
A:<br>
Q:<br>
A:<br>


<?php CHUNKfinishcontent(); ?>

</body>
</html>
