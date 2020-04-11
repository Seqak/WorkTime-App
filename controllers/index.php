<?php
session_start();
require('../vendor/autoload.php');
include("includes/dateandtime.php");
require('../model/dbconnect.php');
require('../model/project.php');
require('../model/getprojects.php');
require_once("../model/gettimes.php");


if (isset($_SESSION['toastType']) && isset($_SESSION['toastStatus'])) {

    $toastType = $_SESSION['toastType']; 
    $toastStatus = $_SESSION['toastStatus'];

    unset($_SESSION['toastType']);
    unset($_SESSION['toastStatus']);
}

if ( isset( $_POST['projectSubmit'] )  &&  !empty( $_POST['nameProject'] ) ) {
    $nameProject = $_POST['nameProject'];
    header('Location: includes/addnewproject.php?nameProject=' . $nameProject);
}

if ( isset($_POST['taskSubmit']) ) {

    $timeStart = $_POST['timeStart'];
    $timeEnd = $_POST['timeEnd'];
    $taskName = htmlentities($_POST['taskName'], ENT_QUOTES, "UTF-8");
    $projectId = $_POST['projectId'];

    header('Location: includes/tasktime.php?timestart=' . $timeStart . '&timeend=' . $timeEnd . '&projectid=' . $projectId . '&taskname=' . $taskName);
}

$projects = new GetProjects();
$allProjects = $projects->getAllProjects();

if (!$allProjects == null) {
    for ($i=0; $i <= count($allProjects) -1 ; $i++) { 

        $projectsObj[] = new Project();
        $timeMonth = new GetTimes();
    
        $projectsObj[$i]->setId($allProjects[$i]['id']);
        $projectsObj[$i]->setProjectName($allProjects[$i]['project_name']);
        $projectsObj[$i]->setHoursTotal($allProjects[$i]['hours_total']);
    
        $monthAmount = $timeMonth->getMonthHours($allProjects[$i]['id']);
        $projectsObj[$i]->setHoursMonth($monthAmount);
    
        $dayAmount = $timeMonth->getTodayHours($allProjects[$i]['id']);
        $projectsObj[$i]->setHoursToday($dayAmount);
      
    } 
}

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader);

echo $twig->render('index.html', array(
    'projectAddStatus' => $projectAddStatus ?? null,
    'projects' => $projectsObj ?? null,
    'projectsAmount' => $allProjects ?? null,
    'toastType' => $toastType ?? null,
    'toastStatus' => $toastStatus?? null,

));

?>
