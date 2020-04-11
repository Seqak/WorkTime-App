<?php
session_start();
require('../../model/dbconnect.php');
require('../../model/addproject.php');


if (!empty($_GET['nameProject'])) {
    $nameProject = $_GET['nameProject'];

    $addProject = new Addproject();
    $addProject->addNewProject($nameProject);

    $_SESSION['toastType'] = "project"; 
    $_SESSION['toastStatus'] = "success";

    header('Location: ../index.php');
}
else{
    $_SESSION['toastType'] = "project"; 
    $_SESSION['toastStatus'] = "danger";
    header('Location: ../index.php');
}

