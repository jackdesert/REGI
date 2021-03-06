<!-- Front End JS functions -->

function checkSignup() {
    if (document.forms.signup.gear.value.length < 3){
        alert("Please answer the question, 'Do you have the required gear?' before submitting");
        return false;
    }
    if (document.forms.signup.questions.value.length < 2){
        alert("Please answer the question, 'Do you have any questions or comments for us?' before submitting.");
        return false;
    }
    var index = 0;
    var count = 0;
    for (index = 0; index < 3; index++){
        if (document.forms.signup.need_ride[index].checked){
            count = 1;
        }
    }
    if (count == 0){
        alert("Please indicate your carpooling preferences before submitting.");
        return false;
    }

    if (document.forms.signup.leaving_from.value.length < 1){
        alert("Please indicate where you are leaving from before submitting.");
        return false;
    }

    return true;
}


function checkLogin() {
    requiredFields = "";

    if (document.forms.login.user_name.value.length < 6)
        requiredFields += "   * User Name (minimum 6 characters)\r\n";
    if (document.forms.login.user_password.value.length < 6)
        requiredFields += "   * Password (minimum 6 characters)\r\n";

    if (requiredFields != '')
        alert("The following are required fields:\n\r"+requiredFields);
    else
        return true;

    return false;
}

function verifyPasswordLength(){
    if (document.forms.profile.user_password.value.length < 6)
        return ("   * Password (minimum 6 characters)\r\n");
    else
        return ('');
}
function checkNewPassword(){
    if (document.forms.enter_new_password.new_user_password.value.length < 6)
        alert("Please enter a password at least 6 characters long\r\n");
    else
        return true;
    return false;
}

function checkNewProfile() {
    if (document.forms.profile.user_password.value.length < 6){
        alert ("Your password must be at least 6 characters");
        return false;
    }
    if (document.forms.profile.user_name.value.length < 6){
        alert ("Your user name must be at least 6 characters");
        return false
    }
    return checkUpdatedProfile();
}

/* Note that checkUpdatedProfile() is a subset of checkNewProfile() */
function checkUpdatedProfile() {
    requiredFields = "";

    if (document.forms.profile.first_name.value == '')
        requiredFields += "   * First Name\r\n";
    if (document.forms.profile.last_name.value == '')
        requiredFields += "   * Last Name\r\n";
    if (document.forms.profile.email.value == '')
        requiredFields += "   * Email\r\n";
    if (document.forms.profile.experience.value == '')
        requiredFields += "   * Previous Hiking Experience\r\n";
    if (document.forms.profile.exercise.value == '')
        requiredFields += "   * What is your weekly exercise routine?\r\n";
    if (document.forms.profile.emergency_contact.value == '')
        requiredFields += "   * Emergency Contact\r\n";
    if (document.forms.profile.medical.value == '')
        requiredFields += "   * The Allergies / Medications / Medical Conditions question\r\n";
    if (document.forms.profile.experience.value == '')
        requiredFields += "   * Previous Hiking Experience\r\n";

    if (requiredFields != ''){
        alert("Please enter the following required fields:\n\r"+requiredFields);
        return false;
    }else if (email_not_valid(document.forms.profile.email.value)){
        alert("Invalid email address.");
        return false;
    }else{
        return true;
    }

    return false;
}

function checkDate(date_string, label){
    var pattern=/^\d\d\/\d\d\/[\d]{4}$/;
    var err = '';
    if (pattern.test(date_string)){  //first pass makes sure it's the correct number of numbers and dashes
        //First pass
        var groups = date_string.split('/');
        var year = groups[2];
        if ('1999' < year && year < '2020');
        else
            err += label + "Bad Year: " + year + "\r\n";
        var month = groups[0];
        if ('00' < month && month < '13');
        else
            err += label + "Bad Month: " + month + "\r\n";
        var day = groups[1];
        if ('00' < day && day < '32');
        else
            err += label + "Bad Day of the Month: " + day + "\r\n";

        //For some reason Javascript uses 0-based counting for month
        var myDate = new Date(year,month-1,day);
        if (year == myDate.getFullYear() && month == myDate.getMonth() + 1 && day == myDate.getDate());
        else
            err += label + "Invalid Combination. (You're not scheduling for the 30th of February, are you?)\r\n";
    }else
        err += label + "Date Format Invalid. (Should look something like 12/07/2012)\r\n";


    return err;
}



function checkAdmin() {
    requiredFields = "";

    if (document.forms.trip_essence.event_name.value.length < 10){
        requiredFields += "   * Event Name (minimum 10 characters)\r\n";}
    if (document.forms.trip_essence.description.value.length < 10)
        requiredFields += "   * General Description (minimum 10 characters)\r\n";

    var start_date = document.forms.trip_essence.start_date.value;
    var end_date = document.forms.trip_essence.end_date.value;
    var myString =  checkDate(start_date, "* Start Date: ");
    requiredFields += myString;
    if (end_date != ''){
        myString =  checkDate(end_date, "* End Date: ");
        requiredFields += myString;
    }

    if (requiredFields != ''){
        alert("Please correct the following issues so we may process your request:\n\r"+requiredFields);
        return false;
    }else{
        return true;
    }
}

function checkSendPassword() {
    requiredFields = "";

    if (document.forms.send_pass.user_name.value.length < 6)
        requiredFields += "   * User Name (minimum 6 characters)\r\n";

    if (requiredFields != '')
        alert("The following are required fields:\n\r"+requiredFields);
    else
        return true;

    return false;
}

function showhide() {
  var res1 = document.getElementById('res1');
  if (document.info.user_type.value == 'Researcher')
    h = "block";
  else
    h = "none";
  res1.style.display = h;
}

function areyousure() {

    conf = confirm("Are you sure you want to delete?");

    if (conf == false)
        return false;
    else
        return true;
}

function email_not_valid(elementValue){
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (emailPattern.test(elementValue))
        return false;
    else
        return true;
}
