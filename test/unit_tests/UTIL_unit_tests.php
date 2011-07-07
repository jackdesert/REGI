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
        $this->assertEquals('not specified', $pretty_date);
    }

    public function testUTILhashes()
    {
        $plain = 'a_very_long_passphrase';
        $encrypted = UTILgenhash($plain);
        $this->assertEquals(true, UTILcheckhash($plain, $encrypted));
    }

    public function testUTILbuildmenu()
    {
        $long = UTILbuildmenu(0);
        $this->assertGreaterThan(0, strlen($long), 'should have a return value of 0');
    }

    public function testUTILdbconnect()
    {
        $long = UTILdbconnect();
        $this->assertEquals(1, $long, 'should return 1 after connected');
    }
    public function testUTILclean()
    {
        $clean_input = 'a sentence with 1234567890 numbers and some !@#$%^*()-_=+[]{}|;\/?,`~ symbols.';
        $clean_output = UTILclean($clean_input, 0, '');
        $this->assertEquals($clean_input, $clean_output, 'All these symbols should come through clean');

        $dirty_input = 'dirty &<> symbols.';
        $washed_output = UTILclean($dirty_input, 0, '');
        print $washed_output;
        $this->assertNotEquals($dirty_input, $washed_output, 'These symbols should be replaced by html');
        $this->assertEquals($washed_output, 'dirty &amp;&lt;&gt; symbols.', 'These symbols should be replaced by html');
    }
}
?>
