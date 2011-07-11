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
        $found = strstr($myCookie, 'user_name=');
        $this->assertNotEquals(false, $found, 'string user_name= not found in cookie');
        // Now test a bogus cookie
        $bogusCookie = 'sjdiekelsickeh';
        $badresult = SECtestCookie($bogusCookie, $this->special_code);
        $this->assertEquals(false, $badresult, 'bad cookie accepted');
        // Now test $myCookie, which should prove to be a valid cookie
        $goodresult = SECtestCookie($myCookie, $this->special_code);
        $this->assertEquals($cookieData, $goodresult, 'good cookie not accepted');
    }


}
?>
