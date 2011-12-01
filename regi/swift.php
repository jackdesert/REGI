<?php
set_include_path('/home/hbboston/pear/pear/php' . PATH_SEPARATOR . get_include_path());
include_once "swift_required.php";
function SWIFTsend($to, $subject, $plain){

    global $PASS_SWIFT_USER;
    global $PASS_SWIFT_PASSWORD;

    /*
     * Create the body of the message (a plain-text and an HTML version).
     * $plain is your plain-text email
     * $html is your html version of the email
     * If the reciever is able to view html emails then only the html
     * email will be displayed
     */
    /*$html = <<<EOM
    <html>
      <head></head>
      <body>
        <p>Hi!<br>
           How are you?<br>
        </p>
      </body>
    </html>
    EOM;
    */
    $footer = "\n\n-----------------------------------------------------------------------\n";
    $footer.= "REGI MAILER\nThank you for using the H/B Boston REGI. ";
    $footer.= "For help, please visit our support page at http://hbbostonamc.org/regi/support.";

    $plain .= $footer;


    // This is your From email address
    $from = array('regi@hbbostonamc.org' => 'REGI Mailer Boston HB');
    // Email recipients
    /*
     * $to = array(
      'jworky@gmail.com'=>'Mr. Jack E Desert',
      'jackdesert556@gmail.com'=>'someone new'
    );
    * */

    // Login credentials
    $username = $PASS_SWIFT_USER;
    $password = $PASS_SWIFT_PASSWORD;

    // Setup Swift mailer parameters
    $transport = Swift_SmtpTransport::newInstance('smtp.sendgrid.net', 587);
    $transport->setUsername($username);
    $transport->setPassword($password);
    $swift = Swift_Mailer::newInstance($transport);

    // Create a message (subject)
    $message = new Swift_Message($subject);
    // attach the body of the email
    $message->setFrom($from);
    $message->setBody($plain, 'text/plain');
    // $message->setBody($html, 'text/html');
    //$message->addPart($plain, 'text/plain');
    // Send message
    try{
        $message->setTo($to);
        if ($recipients = $swift->send($message, $failures)){
            // This will let us know how many users received this message
            $success = "Message sent out these ".$recipients." users: $to";
            UTILlog($success);
        }else{
            // something went wrong =(
            $string_of_failures = print_r($failures, true);
            UTILlog($string_of_failures);
            throw new Exception("Sendgrid Did Not Send. Are you over your daily allowance?");
        }
    }
    catch(Exception $e){
        UTIL_failover_sendEmail($to, $subject, $plain);
        UTILlog("Exception Caught: " . $e->getMessage() . "\nSending via sendmail instead");
    }
}
