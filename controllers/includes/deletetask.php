<?php
session_start();
require_once('../../model/dbconnect.php');
require_once('../../model/deleteoldproject.php');

if (isset($_POST['taskId']) && $_POST['projectId']) {

    $taskId = $_POST['taskId'];
    $projectId = $_POST['projectId'];

    $projectDelete = new DeleteProject();
    $projectDelete->deleteTask($taskId, $projectId);

    $_SESSION['toastType'] = "project";
    $_SESSION['toastStatus'] = "deleted";

}