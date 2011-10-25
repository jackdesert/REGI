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
        $values = array(0,1,5); //When tab 0, 1, or 5 is selected, selected_tab shows up even when not logged in
        foreach ($values as $value){
            print "value is: " . $value;
            $html = UTILbuildmenu($value);
            $this->assertGreaterThan(300, strlen($html), 'should return more than 300 characters');
            $search_term = 'selected_top_tab';
            $found = strstr($html, $search_term);
            $this->assertNotEquals(false, $found, 'search_term not found');
            //$this->assertStringStartsWith($found, strstr($html, $found), 'should find text "selected_top_tab" once');
        }
        //Make sure no errors thrown, even for arguments above 5
        $html = UTILbuildmenu(2);
        $html = UTILbuildmenu(3);
        $html = UTILbuildmenu(4);
        $html = UTILbuildmenu(6);


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

        $dirty_input = '&<>"\'';
        $washed_output = UTILclean($dirty_input, 0, '');
        $this->assertNotEquals($dirty_input, $washed_output, 'These symbols should be replaced by html');
        $this->assertEquals($washed_output, '&amp;&lt;&gt;&quot;&#039;', 'Single quotes, double quotes, ampersand, and <> should be cleaned');

        $long_input = 'a long, run-on sentence';
        $short_output = UTILclean($long_input, 5, '');
        print $washed_output;
        $this->assertNotEquals(strlen($long_input), strlen($short_output), 'Output should be shorter than input.');
        $this->assertEquals(5, strlen($short_output), 'Output should be 5 characters.');


    }


}
?>
