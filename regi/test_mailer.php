<?php
include 'utils.php';


$to = 'jackdesert556@gmail.com';
$event_name = "Beer and Wine Fest";
$statuses = Array('CANCELED', 'SUBMITTED', 'WAITLIST', 'APPROVED', 'REGISTRAR', 'COLEADER', 'LEADER');

$event_id = 100;
foreach ($statuses as $index => $reg_status){

    $title="AMC REGI Status: $reg_status -- $event_name";
    $message = reg_status_email('first_name', $reg_status, $event_name, $event_id);
    print $title . "\n\n";
    print $message;
    print "\n\n====================================================\n\n";
    UTILsendEmail($to, $title, $message);
}


