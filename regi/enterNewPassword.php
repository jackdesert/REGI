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

    $reset = false;

    if (isset($_GET['pass_reset_code']) && isset($_GET['user_id'])){
        $submitted_pass_reset_code = $_GET['pass_reset_code'];
        $submitted_user_id = $_GET['user_id'];
        $checkquery = "SELECT pass_reset_code FROM users WHERE user_id='$submitted_user_id';";
        $result = mysql_query($checkquery);
        if (!$result) UTILdberror($query);
        $row = mysql_fetch_assoc($result);
        $saved_pass_reset_code=$row['pass_reset_code'];


        if ($submitted_pass_reset_code == $saved_pass_reset_code){
            $_SESSION['Suser_id'] = $submitted_user_id; //this essentially logs in the user
            $reset = true;
        }else{
            print $saved_pass_reset_code;
            $_SESSION['Smessage'] = "There is something wrong with your password reset link. Please try again.";
            header( 'Location: ./forgotPassword.php');
            exit();
        }

    }elseif(isset($_SESSION['Suser_id']))
        $reset = true;
    else
        $_SESSION['Smessage'] = "You Are Not Logged in. Please Log in.";


    if ($reset){
        $my_user_id = $_SESSION['Suser_id'];
        $_SESSION['Smessage'] = "Please Enter a new password and save your profile.";
        unset($_SESSION['Semail']); //this makes it look like the session is empty later on
    }else{
        header( 'Location: ./login.php');
        exit();
    }



    CHUNKstylemessage($_SESSION['Smessage']);
    unset($_SESSION['Smessage']);
    CHUNKstartcontent();



?>

<h1>Enter New Password</h1>


<form name='profile' action='action.php' method='post'>
    <table><tr>

    <td><b>* New Password</b></td>
    <td><input type='password' name='user_password' value='' MAXLENGTH=50 autofocus='autofocus'> (minimum 6 characters)</td>
    </tr><tr>
</tr></table>

<input type='hidden' name='user_id' value='<?php print $my_user_id ?>'>
<input type='submit' name='action' value='Save New Password' onclick='return checkNewPassword();'>
</form>
</div><!-- closing div for #myprofile_narrow, only in this page -->
<?php CHUNKfinishcontent(); ?>
</body>
</html>
