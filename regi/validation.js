<!-- Front End JS functions -->

function checkLogin() {
    requiredFields = "";

    if (document.info.user_name.value.length < 6)
        requiredFields += "   * User Name (minimum 6 characters)\r\n";
    if (document.info.user_password.value.length < 6)
        requiredFields += "   * Password (minimum 6 characters)\r\n";

    if (requiredFields != '')
        alert("The following are required fields:\n\r"+requiredFields);
    else
        return true;

    return false;
}

function checkProfile() {
    requiredFields = "";

    if (document.info.user_name.value.length < 6)
        requiredFields += "   * User Name (minimum 6 characters)\r\n";
    if (document.info.user_password.value.length < 6)
        requiredFields += "   * Password (minimum 6 characters)\r\n";
    if (document.info.first_name.value == '')
        requiredFields += "   * First Name\r\n";
    if (document.info.last_name.value == '')
        requiredFields += "   * Last Name\r\n";
    if (document.info.email.value == '')
        requiredFields += "   * Email\r\n";

    if (requiredFields != '')
        alert("The following are required fields:\n\r"+requiredFields);
    else
        return true;

    return false;
}

function checkAdmin() {
    requiredFields = "";

    if (document.info[0].event_name.value.length < 10){
        requiredFields += "   * Event Name (minimum 10 characters)\r\n";}
    if (document.info[0].description.value.length < 10)
        requiredFields += "   * General Description (minimum 10 characters)\r\n";

    var pattern=/^[\d]{4}-\d\d-\d\d$/;
    var start_date = document.info[0].start_date.value;
    if (pattern.test(start_date)){  //first pass makes sure it's the correct number of numbers and dashes
        //First pass
        var groups = start_date.split('-');
        var year = groups[0];
        if ('1999' < year && year < '2020');
        else
            requiredFields += "   * Bad Year in Date\r\n";
        var month = groups[1];
        if ('00' < month && month < '13');
        else
            requiredFields += "   * Bad Month in Date\r\n";
        var day = groups[2];
        if ('00' < day && day < '31');
        else
            requiredFields += "   * Bad Day in Date\r\n";

    }else
        requiredFields += "   * Start Date Format Invalid. (Should look something like 2012-07-24)\r\n";

    //For some reason Javascript uses 0-based counting for month
    var myDate = new Date(year,month-1,day);
    if (year == myDate.getFullYear() && month == myDate.getMonth() + 1 && day == myDate.getDate());
    else
        requiredFields += "   * Start Date Invalid. (You're not scheduling for the 30th of February, are you?)\r\n";


    if (requiredFields != ''){
        alert("Please correct the following issues so we may process your request:\n\r"+requiredFields);
        return false;
    }else{
        return true;
    }
}

function checkSendPassword() {
    requiredFields = "";

    if (document.info.user_name.value.length < 6)
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

