<?php
include '../../regi/chunks.php';

class UTILtest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        //Note: double quotes have been replaced with single quotes in this example
        //except where they have been replaced with an escaped double quote: \"
        $this->listings = "
<html>

<head>
<title>hbbostonamc.org</title>
<meta name='description' content='HB Boston - The Hiking/Backpacking Committee of Boston Chapter AMC' />
<meta name='keywords' content='hiking, backpacking, boston, AMC, HB, winter hiking, Spring hiking, instruction, White Mountains, New England' />
<meta name='Generator' content='Microsoft FrontPage 5.0' />
<meta name='robots' content='index, follow' />
<base href='http://www.hbbostonamc.org/' />
    <link rel='shortcut icon' href='http://www.hbbostonamc.org/images/favicon.ico' />
    <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
<link href='http://www.hbbostonamc.org/templates/amctemplate/template_css/template_css.css' type='text/css' rel='stylesheet' />
</head>
<body>
<div id='pagewrap'>
  <div id='layer10' onclick='location.href='http://www.hbbostonamc.org/index.php';' style='cursor:pointer;'>
    <div id='searchbox'>
    </div>
   </div>



<div style=\"padding-left:20px; width:90%;\">
    Search_Text_With_Divs
</div>


        </div>
    </body>
</html>";
    }
    public function testCHUNKtrimtrips()
    {
        $html = CHUNKtrimtrips($this->listings);
        $wanted1 = "Search_Text_With_Divs";
        $found1 = strstr($html, $wanted1);
        $this->assertNotEquals(false, $found1, 'Search_Text_With_Divs not found');
        $not_wanted2 = "</head";
        $found2 = strstr($html, $not_wanted2);
        $this->assertEquals(false, $found2, '</head> not stripped from html');
/*
        $found3 = strstr($html, $wanted3);
        $this->assertNotEquals(false, $found3, 'Search_Text_With_Divs not found');
        $found4 = strstr($html, $wanted4);
        $this->assertNotEquals(false, $found4, 'Search_Text_With_Divs not found');
        $found5 = strstr($html, $wanted5);
        $this->assertNotEquals(false, $found5, 'Search_Text_With_Divs not found');
*/

        //$this->assertEquals($num_opening_divs, $num_closing_divs, 'number of opening and closing divs differ');

    }

}
?>
