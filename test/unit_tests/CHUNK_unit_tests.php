<?php
include '../../regi/chunks.php';

class UTILtest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        //Note: double quotes have been replaced with single quotes in this example
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



<div style='padding-left:20px; width:90%;'>
    Search_Text_With_Divs
</div>


        </div>
    </body>
</html>";
    }
    public function testCHUNKtrimtrips()
    {
        $html = CHUNKtrimtrips($this->listings);
        $wanted = "Search_Text_With_Divs";
        print 'wanted:    ' . $wanted;
        $found = strstr($html, $wanted);
        print 'found:     ' . $found;
        print $html;
        $this->assertNotEquals(false, $found, 'Search_Text_With_Divs not found');
        //$this->assertEquals($num_opening_divs, $num_closing_divs, 'number of opening and closing divs differ');

    }

}
?>
