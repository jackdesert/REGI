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
    // If Suser_id defined, populate screen with user profile + set to Update mode
    //  otherwise, set to New mode

    $user_name='';
    $user_password='';
    $first_name='';
    $last_name='';
    $email='';
    $phone_evening='';
    $phone_day='';
    $phone_cell='';
    $member='';
    $member_yes='';
    $member_no='';
    $leader_request_yes='';
    $leader_request_no='';
    $leader_request='false';
    $emergency_contact='';
    $experience='';
    $medical='';
    $exercise='';
    $diet='';
    $readonly='';

    $my_user_id='';  // default values, assuming new user
    $my_user_type='';

    if (isset($_GET['event_id']))
        $event_id=$_GET['event_id'];
    else
        $event_id='';


    if (SECisUserLoggedIn($PASS_HMAC_SECRET_CODE)) {
        // if User is already logged in, pull profile from DB

        $my_user_id=$_SESSION['Suser_id'];
        $formAction='Update My Profile';

        // Get user profile
        //

        $query = "select user_name, first_name, last_name,
            user_type, email, phone_evening, phone_day, phone_cell,
            emergency_contact, member, experience, exercise, medical, diet
            FROM users
            WHERE user_id=$my_user_id;";

        $result = mysql_query($query);
        if (!$result) UTILdberror($query);

        $numrows = mysql_num_rows($result);
        if ($numrows <> 1) {
            print "<br>Can not retrieve user from database<br>";
        } else {
            $row = mysql_fetch_assoc($result);
            $user_name=$row['user_name'];
            $first_name=$row['first_name'];
            $last_name=$row['last_name'];
            $user_type=$row['user_type'];
            $email=$row['email'];
            $phone_evening=$row['phone_evening'];
            $phone_day=$row['phone_day'];
            $phone_cell=$row['phone_cell'];
            $member=$row['member'];
            $emergency_contact=$row['emergency_contact'];
            $experience=$row['experience'];
            $medical=$row['medical'];
            $exercise=$row['exercise'];
            $diet=$row['diet'];


            $readonly='readonly';
        }
    }elseif (isset($_SESSION['Semail'])){
        //if not logged in yet but some info like email is in the session,
        // it means they clicked "Create Profile", but something didn't work.
        $formAction='Create Profile';

        // These two fields only need to be saved if they haven't yet created their profile
        // (This is in case they face an error)
        if (isset($_SESSION['Suser_name'])){
            $user_name=$_SESSION['Suser_name'];
            unset($_SESSION['Suser_name']);
        }
        if (isset($_SESSION['Suser_password'])){
            $user_password=$_SESSION['Suser_password'];
            unset($_SESSION['Suser_password']);
        }


    }else{
        // If not logged in and not second time around, start fresh
        $formAction='Create Profile';
    }


    // Use anything that has been saved to the session so they don't lose what they've typed
    // (This is in case they face an error)
    // Question: do we really need to unset these?

    if (isset($_SESSION['Sfirst_name'])){
        $first_name=$_SESSION['Sfirst_name'];
        // don't unset because emails use this
    }
    if (isset($_SESSION['Slast_name'])){
        $last_name=$_SESSION['Slast_name'];
        // don't unset because emails use this
    }
    if (isset($_SESSION['Semail'])){
        $email=$_SESSION['Semail'];
        unset($_SESSION['Semail']);
    }
    if (isset($_SESSION['Sphone_evening'])){
        $phone_evening=$_SESSION['Sphone_evening'];
        unset($_SESSION['Sphone_evening']);
    }
    if (isset($_SESSION['Sphone_day'])){
        $phone_day=$_SESSION['Sphone_day'];
        unset($_SESSION['Sphone_day']);
    }
    if (isset($_SESSION['Sphone_cell'])){
        $phone_cell=$_SESSION['Sphone_cell'];
        unset($_SESSION['Sphone_cell']);
    }
    if (isset($_SESSION['Smember'])){
        $member=$_SESSION['Smember'];
        unset($_SESSION['Smember']);
    }
    if (isset($_SESSION['Sleader_request'])){
        $leader_request=$_SESSION['Sleader_request'];
        unset($_SESSION['Sleader_request']);
    }
    if (isset($_SESSION['Semergency_contact'])){
        $emergency_contact=$_SESSION['Semergency_contact'];
        unset($_SESSION['Semergency_contact']);
    }
    if (isset($_SESSION['Sexperience'])){
        $experience=$_SESSION['Sexperience'];
        unset($_SESSION['Sexperience']);
    }
    if (isset($_SESSION['Smedical'])){
        $medical=$_SESSION['Smedical'];
        unset($_SESSION['Smedical']);
    }
    if (isset($_SESSION['Sexercise'])){
        $exercise=$_SESSION['Sexercise'];
        unset($_SESSION['Sexercise']);
    }
    if (isset($_SESSION['Sdiet'])){
        $diet=$_SESSION['Sdiet'];
        unset($_SESSION['Sdiet']);
    }

    if ($member=='Y')
        $member_yes='checked';
    else
        $member_no='checked';

    // Remember their preference to be a leader or not
    if ($leader_request=='true')
        $leader_request_yes='checked';
    elseif ($leader_request=='false')
        $leader_request_no='checked';

    //Note that UTILbuildmenu() is called clear down here so we can use the cookie to log in before we display
    //the menu
    UTILbuildmenu(4);
    CHUNKstylemessage($_SESSION);
    CHUNKstartcontent();

?>

<h1>My Profile</h1>

<?php
    if ($formAction=='Create Profile') {
    print "<font color='red'>Please note: if you have already created an account, please use that account to login and do not create a new account.  If you don't remember your password, please click <a href='forgotPassword'>here</a>.</font>";
    }
?>

<p>Keeping your profile up to date helps leaders determine if you are physically fit for a particular event.
Your profile information is visible only to the leaders of the events you register for. </p>

<form name='profile' action='action.php' method='post'>
    <table><tr>


    <?php
    if ($formAction == 'Create Profile'){
        print "<td><b>* User Name</b></td>
        <td><input type='text' name='user_name' value='$user_name' MAXLENGTH=40 $readonly required='required'>  (6-40 chars.) Please don't use the following: ' &quot; &lt; > &amp;</td>
        </tr><tr>";
        print "
        <td><b>* Password</b></td>
        <td><input type='password' name='user_password' value='$user_password' MAXLENGTH=50  required='required'> (minimum 6 characters)</td>
        </tr><tr>";
    }else{
        print "<td><b>&nbsp;&nbsp;User Name:</b></td><td> $user_name</td></tr><tr>";
        print "    <td><b>&nbsp;&nbsp;Password</b></td><td>Save changes to your profile, then you may <a href='enterNewPassword.php'> change your password</a>.</td></tr><tr>";
    }
    ?>

    <td><b>* First Name</b></td>
    <td><input type='text' name='first_name' value='<?php echo $first_name; ?>' MAXLENGTH=20 required='required'>   </td>
    </tr><tr>
    <td><b>* Last Name</b></td>
    <td><input type='text' name='last_name' value='<?php echo $last_name; ?>' MAXLENGTH=20 required='required'></td>
    </tr><tr>
    <td><b>* Email</b></td>
    <td><input type='email' name='email' value='<?php echo $email; ?>' MAXLENGTH=40 required='required'></td>
    </tr><tr>
    <td><b>Phone (evening)</b></td>
    <td><input type='text' name='phone_evening' value='<?php echo $phone_evening; ?>' MAXLENGTH=20></td>
    </tr><tr>
    <td><b>Phone (weekday)</b></td>
    <td><input type='text' name='phone_day' value='<?php echo $phone_day; ?>' MAXLENGTH=20></td>
    </tr><tr>
    <td><b>Phone (cell)</b></td>
    <td><input type='text' name='phone_cell' value='<?php echo $phone_cell; ?>' MAXLENGTH=20></td>
</tr></table>

<p>Are you an AMC member?
<input type="radio" name="member" value="Y" <?php print $member_yes ?> >YES
&nbsp;
<input type="radio" name="member" value="N" <?php print $member_no ?> >NO

<?php
    if ($formAction=='Create Profile') {
        print "<p>Are you a current AMC H/B Leader or Coleader?
        <input type='radio' name='leader_request' value='true' $leader_request_yes >YES
        &nbsp;
        <input type='radio' name='leader_request' value='false' $leader_request_no >NO
        <font color='red'><br>Please note: selecting yes will send an email to the administrator to verify your AMC H/B Leader/Coleader status.</p></font>";
    }
?>

<div id='myprofile_narrow'>
<p>* What is your previous hiking experience? (If applicable, please name mountains and include approximate distances.)<br />

<textarea name="experience" rows="10" cols="60" required='required'>
<?php echo $experience; ?>
</textarea></p>

<p>* What is your weekly exercise routine? Please be honest.<br />
<textarea name="exercise" rows="6" cols="60" required='required'>
<?php echo $exercise; ?>
</textarea></p>

<p>* Do you have any allergies, are taking any medications, or have other medical conditions that may be important? (Your answer will remain confidential.)<br />
<textarea name="medical" rows="3" cols="60" required='required'>
<?php echo $medical; ?>
</textarea></p>

<p>* In case of emergency, please enter a person to contact, including name and phone number.<br />
<textarea name="emergency_contact" rows="3" cols="60" required='required'>
<?php echo $emergency_contact; ?>
</textarea></p>

<p>Do you have any dietary preferences or restrictions (vegetarian, food allergies, etc.)?<br />
<textarea name="diet" rows="3" cols="60">
<?php echo $diet; ?>
</textarea></p>
<?php
if ($formAction == "Update My Profile"){
    $check = "checkUpdatedProfile";
}else{
    $check = "checkNewProfile";
}
?>
<input type='hidden' name='event_id' value='<?php print $event_id ?>'>
<input type='hidden' name='user_id' value='<?php print $my_user_id ?>'>
<input type='submit' class='button' name='action' value='<?php print $formAction; ?>' onclick='return <?php print $check; ?>()'>
</div><!-- closing div for #myprofile_narrow, only in this page -->
</form>
<?php CHUNKfinishcontent(); ?>

