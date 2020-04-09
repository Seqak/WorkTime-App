<?php
session_start();
require_once('../../model/dbconnect.php');
require_once('../../model/deleteoldproject.php');

if (isset($_POST['id'])) {
    
    $projectId = $_POST['id'];
    
    $projectDelete = new DeleteProject();
    $projectDelete->deletePro($projectId);

    $_SESSION['toastType'] = "project"; 
    $_SESSION['toastStatus'] = "deleted";

}

    