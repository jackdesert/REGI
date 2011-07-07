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
        $html = UTILbuildmenu(0);
        $this->assertGreaterThan(300, strlen($html), 'should return more than 300 characters');
        $found = 'selected_top_tab';
        $this->assertStringStartsWith($found, strstr($html, $found), 'should find text "selected_top_tab" once');
        $html = UTILbuildmenu(1);
        $html = UTILbuildmenu(2);
        $html = UTILbuildmenu(3);
        $html = UTILbuildmenu(4);
        $html = UTILbuildmenu(5);
        $html = UTILbuildmenu(6);
        $html = UTILbuildmenu(7);
        $html = UTILbuildmenu(8);
        $html = UTILbuildmenu(9);
        $this->assertGreaterThan(0, strlen($html), 'should have a return value of 0');

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

    public function testUTILlog()
    {
        $current_dir = realpath('.');
        chdir('../../regi');    //change to directory where UTILlog is normally called from
        $random_string_length = 25;
        $random_string = substr(md5(uniqid(rand(), true)), 0, $random_string_length);
        $bogus_query = 'Unit test is writing this random string to log file: ' .  $random_string;
        UTILlog($bogus_query);
        $logfile_path = 'log/errorlog.log';
        $logfile = fopen($logfile_path,"r");
        $data = fread($logfile,filesize($logfile_path));
        fclose($logfile);
        $found = strstr($data, $bogus_query);
        $this->assertGreaterThan(0, strlen($found), 'string found should have length > 0');
        $this->assertEquals($found, $bogus_query, 'log file should contain the bogus_query that we wrote');
        chdir($current_dir);
    }

}
?>
