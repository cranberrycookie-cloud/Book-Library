<?php
require "vendor/autoload.php"
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//echo "Libarary berhasil di-load";

$ss = new Spreadsheet();
$sheetnya = $ss->getActiveSheet();

$sheetnya->setCellValue('A1','TRK 62 A2');
$sheetnya->setCellValue('A3','IPB University');
$sheetnya->setCellValue('A2','Sekolah Vokasi');

$Writernya = new Xlsx($ss);
$namaFilenya = 'file01.xlsx';
$Writernya->save($namaFilenya);

echo "Sebuah file spreadsheet &namaFilenya sudah berhasil dibuat";
?>
