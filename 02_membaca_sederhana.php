<?php

require "vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
$ss = IOFactory::load('file01.xlsx');

$sheet = $ss->getActiveSheet();

$isiA1 = $sheet->getCell('A1')->getValue();
echo "isi di kolom A baris 1: ".$isiA1;
echo "<hr>";
$x = $sheet->getCell('A3')->getValue();
echo "isi di kolom A baris 3: ".$x;

$barisTerbesar = $sheet->getHighestRow();
echo"<hr>";
for($i=1;$i<=$barisTerbesar ;$i++){
    $str = $sheet->getCell('A'.$i)->getValue();
    echo $str."<br>";
}

?>