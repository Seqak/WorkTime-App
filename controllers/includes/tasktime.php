<?php
session_start();
require_once("dateandtime.php");
require('../../model/dbconnect.php');
require('../../model/addtask.php');

if (isset($_GET['timestart']) && isset($_GET['timeend']) && isset($_GET['projectid']) && isset($_GET['taskname'])) {

    $timeStart = $_GET['timestart'];
    $timeEnd = $_GET['timeend'];   
    $taskName = $_GET['taskname'];
    $taskName = htmlentities($taskName, ENT_QUOTES, "UTF-8");
    $projectId = $_GET['projectid'];
}
$date = new Dateandtime();
$addTime = $date->getDate();

$unixStartTime = $date->startTasktoUnix($timeStart);
$unixEndTime = $date->startTasktoUnix($timeEnd);

if ($unixStartTime >= $unixEndTime) {
    header('Location: ../index.php?time=badHours' );
}
else{

    $unixAddTime = strtotime($addTime);

    $workTime = $date->timeCalculate($unixStartTime, $unixEndTime);

    $addTaskObj = new Addtask();
    $addTaskObj->addNewTask($workTime, $unixAddTime, $projectId, $taskName);

    header('Location: ../index.php?time=' . $workTime);
}


