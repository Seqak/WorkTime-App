<?php
session_start();
require_once('../../model/dbconnect.php');
require_once('../../model/deleteoldproject.php');

if (isset($_POST['id'])) {
    
    $projectId = $_POST['id'];
    
    $projectDelete = new DeleteProject();
    $stauZ = $projectDelete->deletePro($projectId);
    
    header('Location: ../index.php?projectDelStatus=' .  $stauZ);
}