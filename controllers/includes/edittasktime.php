<?php
session_start();
require_once("dateandtime.php");
require('../../model/dbconnect.php');
require('../../model/addtask.php');

if (!empty($_GET['timestart']) && !empty($_GET['timeend']) && !empty($_GET['projectid']) && !empty($_GET['taskname']))
{
    $timeStart = $_GET['timestart'];
    $timeEnd = $_GET['timeend'];
    $taskName = $_GET['taskname'];
    $taskName = htmlentities($taskName, ENT_QUOTES, "UTF-8");
    $projectId = $_GET['projectid'];
    $taskId = $_GET['taskid'];
}
elseif ( empty($_GET['timestart']) || empty($_GET['timeend']) || empty($_GET['taskname']) )
{
    $_SESSION['toastType'] = "task";
    $_SESSION['toastStatus'] = "danger";
    header('Location: ../index.php');
    exit();
}


$date = new Dateandtime();
$addTime = $date->getDate();

$unixStartTime = $date->startTasktoUnix($timeStart);
$unixEndTime = $date->startTasktoUnix($timeEnd);

if ($unixStartTime >= $unixEndTime)
{
    $_SESSION['toastType'] = "taskEdit";
    $_SESSION['toastStatus'] = "danger";
    header('Location: ../index.php' );
    exit();
}
else {
    $unixAddTime = strtotime($addTime);

    $workTime = $date->timeCalculate($unixStartTime, $unixEndTime);

    $addTaskObj = new Addtask();
    $addTaskObj->editTask($workTime, $projectId, $taskName, $unixStartTime, $unixEndTime, $taskId);

    $_SESSION['toastType'] = "taskEdit";
    $_SESSION['toastStatus'] = "success";

    header('Location: ../index.php');
}

