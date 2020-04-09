<?php
session_start();
require('../../model/dbconnect.php');
require('../../model/addproject.php');


$nameProject = $_GET['nameProject'];

$addProject = new Addproject();
$addProject->addNewProject($nameProject);

$_SESSION['toastType'] = "project"; 
$_SESSION['toastStatus'] = "success";

header('Location: ../index.php');

