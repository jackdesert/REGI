<?php
include 'utils.php';


//$to = "Julie LePage <julielepage88@gmail.com>, Abby Driscoll <atdriscoll@gmail.com>, Jack Desert <jackdesert556@gmail.com>" ;
$to = "Jack Desert <jackdesert556@gmail.com>" ;
$first_name = "Tina";
$event_name = "Fall Hike to Trail's Cabin";
$statuses = Array('CANCELED', 'WAITLIST', 'APPROVED', 'REGISTRAR', 'CO-LEADER', 'LEADER');

$event_id = 100;
foreach ($statuses as $index => $reg_status){

    $title="AMC REGI Status: $reg_status -- $event_name";
    $message = reg_status_email($first_name, $reg_status, $event_name, $event_id);
    print $title . "\n\n";
    print $message;
    print "\n\n====================================================\n\n";
    UTILsendEmail($to, $title, $message);
}

// "You are now a leader" email
$email_first_name = "Jack Be Nimble";
$email_subject = "You are now a Leader in REGI";
$email_body = new_leader_email($email_first_name, $approve = true);
UTILsendEmail($to, $email_subject, $email_body);
$email_body = new_leader_email($email_first_name, $approve = false);
UTILsendEmail($to, $email_subject, $email_body);


