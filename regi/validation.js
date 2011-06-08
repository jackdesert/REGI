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

	if (document.info.event_name.value.length < 10)
		requiredFields += "   * Event Name (minimum 10 characters)\r\n";
	if (document.info.description.value.length < 10)
		requiredFields += "   * General Description (minimum 10 characters)\r\n";

	if (requiredFields != '')
		alert("The following are required fields:\n\r"+requiredFields);
	else
		return true;

	return false;
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

