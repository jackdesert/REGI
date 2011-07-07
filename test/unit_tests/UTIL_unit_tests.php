<?php
include '../../regi/utils.php';

class StackTest extends PHPUnit_Framework_TestCase
{
    public function testUTILdate()
    {
        $ugly_date = '2011-12-24';
        $pretty_date = UTILdate($ugly_date);
        $this->assertEquals('Sat, Dec 24, 2011', $pretty_date);
        $ugly_date = '0000-00-00';
        $pretty_date = UTILdate($ugly_date);
        $this->assertEquals('not specified', $pretty_date);
    }
    public function testUTILshortdate()
    {
        $ugly_date = '2011-12-24';
        $pretty_date = UTILshortdate($ugly_date);
        $this->assertEquals('Sat 12/24/11', $pretty_date);
        $ugly_date = '0000-00-00';
        $pretty_date = UTILshortdate($ugly_date);
        $this->assertEquals('not specified', $pretty_date);    }

    public function testUTILhashes()
    {
        $plain = 'a_very_long_passphrase';
        $encrypted = UTILgenhash($plain);
        $this->assertEquals(true, UTILcheckhash($plain, $encrypted));
    }

    public function testUTILbuildmenu()
    {
        $long = UTILbuildmenu(0);
        $this->assertGreaterThan(0, strlen($long));
    }
}
?>
