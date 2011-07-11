<?php
include '../../regi/security.php';

class UTILtest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->special_code = 'nighe8c9orhtfk7';
    }
    public function testSECURITYcookie()
    {
        $cookieData = '12345';
        $myCookie = SECcreateCookie($cookieData, $this->special_code);
        $this->assertGreaterThan(5, strlen($myCookie), 'cookie less than 5 characters');


    }

}
?>
