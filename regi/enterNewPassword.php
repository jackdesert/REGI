<?php
/*
    AMC Event Registration System
    Copyright (C) 2010 Dirk Koechner
    Copyright (C) 2011 Jack Desert <jackdesert556@gmail.com>>

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

    include 'utils.php';
    session_start();
    UTILdbconnect();
    CHUNKgivehead();
    CHUNKstartbody();
    UTILbuildmenu(4);

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

    }elseif(SECisUserLoggedIn($SET_HMAC_SECRET_CODE))
        $reset = true;
    else
        $_SESSION['Smessage'] = "You Are Not Logged in. Please Log in.";


    if ($reset){
        $my_user_id = $_SESSION['Suser_id'];
    }else{
        header( 'Location: ./login.php');
        exit();
    }


    CHUNKstylemessage($_SESSION);

    CHUNKstartcontent();



?>

<h1>Enter New Password</h1>


<form name='enter_new_password' action='action.php' method='post'>
    <table><tr>

    <td><b>* New Password</b></td>
    <td><input type='password' name='new_user_password' value='' MAXLENGTH=50 autofocus='autofocus' autocomplete='off'> (minimum 6 characters)</td>
</tr></table>
<br>
<input type='hidden' name='user_id' value='<?php print $my_user_id ?>'>
<input type='submit' class='button' name='action' value='Save New Password' onclick='return checkNewPassword();'>
</form>
<br>
<?php CHUNKfinishcontent(); ?>

