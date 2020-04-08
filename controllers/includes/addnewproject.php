<?php
session_start();
require('../../model/dbconnect.php');
require('../../model/addproject.php');


$nameProject = $_GET['nameProject'];

$addProject = new Addproject();
$projectAddStatus = $addProject->addNewProject($nameProject);

header('Location: ../index.php?projectAddStatus=' . $projectAddStatus);

