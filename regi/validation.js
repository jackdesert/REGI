<!-- Front End JS functions -->

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

function checkProfile() {
    requiredFields = "";

    if (document.forms.profile.user_name.value.length < 6)
        requiredFields += "   * User Name (minimum 6 characters)\r\n";
    if (document.forms.profile.user_password.value.length < 6)
        requiredFields += "   * Password (minimum 6 characters)\r\n";
    if (document.forms.profile.first_name.value == '')
        requiredFields += "   * First Name\r\n";
    if (document.forms.profile.last_name.value == '')
        requiredFields += "   * Last Name\r\n";
    if (document.forms.profile.email.value == '')
        requiredFields += "   * Email\r\n";

    if (requiredFields != '')
        alert("The following are required fields:\n\r"+requiredFields);
    else
        return true;

    return false;
}

function checkDate(date_string, label){
    var pattern=/^[\d]{4}-\d\d-\d\d$/;
    var err = '';
    if (pattern.test(date_string)){  //first pass makes sure it's the correct number of numbers and dashes
        //First pass
        var groups = date_string.split('-');
        var year = groups[0];
        if ('1999' < year && year < '2020');
        else
            err += label + "Bad Year: " + year + "\r\n";
        var month = groups[1];
        if ('00' < month && month < '13');
        else
            err += label + "Bad Month: " + month + "\r\n";
        var day = groups[2];
        if ('00' < day && day < '31');
        else
            err += label + "Bad Day of the Month: " + day + "\r\n";

        //For some reason Javascript uses 0-based counting for month
        var myDate = new Date(year,month-1,day);
        if (year == myDate.getFullYear() && month == myDate.getMonth() + 1 && day == myDate.getDate());
        else
            err += label + "Invalid Combination. (You're not scheduling for the 30th of February, are you?)\r\n";
    }else
        err += label + "Date Format Invalid. (Should look something like 2012-07-24)\r\n";


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

