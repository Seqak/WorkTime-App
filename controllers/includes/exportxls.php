<?php
session_start();
require_once('../../vendor/autoload.php');
require_once('../../model/dbconnect.php');
require_once('../../model/exportxlsfile.php');
require_once("dateandtime.php");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_GET['projectid'])) {
    $projectId = $_GET['projectid'];
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'TASK');
$sheet->setCellValue('B1', 'CZAS PRACY');

$styleArray = [
    'font' => [
        'bold' => true,
    ],
];

$export = new ExportXLS();
$tasksArray = $export->getData($projectId);

$date = new Dateandtime();

$spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);

if (!$tasksArray == null) {

    for ($i=0; $i < count($tasksArray) ; $i++) { 

        $sheet->setCellValue('A' . ($i+2), $tasksArray[$i]['task_name']);
    }

    for ($i=0; $i < count($tasksArray) ; $i++) { 

        $convertedTime = $date->convertTimeFromUnix($tasksArray[$i]['work_time']);
        $sheet->setCellValue('B' . ($i+2), $convertedTime);
    }
}


$spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);

$exportDate = date("dmY_Gi");
$filename = "export_" . $exportDate;

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '.xlsx "');

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
