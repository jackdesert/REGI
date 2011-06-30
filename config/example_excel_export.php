<?php


// From PHP 4.3.0 onward, you can use the following,
// which especially useful on shared hosts:
//   /home/hbboston/pear/pear/php/Spreadsheet/Excel

set_include_path('/home/hbboston/pear/pear/php' . PATH_SEPARATOR
                 . get_include_path());



// include package
//include 'Spreadsheet/Excel/Writer.php';
include 'Spreadsheet/Excel/Writer.php';

// spreadsheet data
$data = array(
  array('', 'Math', 'Literature', 'Science'),
  array('John', 24, 54, 38),
  array('Mark', 67, 22, 57),
  array('Tim', 69, 32, 58),
  array('Sarah', 81, 78, 68),
  array('Susan', 16, 44, 38),
);



// Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

// sending HTTP headers
$workbook->send('test.xls');

// Creating a worksheet
$worksheet =& $workbook->addWorksheet('My first worksheet');

// add data to worksheet
$rowCount=0;
foreach ($data as $row) {
  foreach ($row as $key => $value) {
    $worksheet->write($rowCount, $key, $value);
  }
  $rowCount++;
}

// Let's send the file
$workbook->close();
?>
