<?php
session_start();
require('../../model/dbconnect.php');
require('../../model/addproject.php');


if (!empty($_GET['nameProject'])) {
    $nameProject = $_GET['nameProject'];

    $addProject = new Addproject();
    $queryStatus = $addProject->addNewProject($nameProject);

    if ($queryStatus == true) {
        
        $_SESSION['toastType'] = "project"; 
        $_SESSION['toastStatus'] = "success";

        header('Location: ../index.php?stat=' . $stat);

    }
    else{
        $_SESSION['toastType'] = "project"; 
        $_SESSION['toastStatus'] = "danger";

        header('Location: ../index.php?stat=' . $stat);
    }

}
else{
    $_SESSION['toastType'] = "project"; 
    $_SESSION['toastStatus'] = "danger";
    header('Location: ../index.php');
}

