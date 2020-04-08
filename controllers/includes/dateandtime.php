<?php

class Dateandtime {

    public function getDate(){
        $today = date("d-m-Y H:i");
        return $today;
    }

    public function getTime(){
        $time = date("G:i");
        return $time;
    }

    public function startTasktoUnix($timeStart){
        
        $startArray = explode(":", $timeStart);
        $todayDate = date("d/m/Y");
        $dateArray = explode("/", $todayDate);
        $year = intval($todayDate[2]);
        $unixStartTime = mktime($startArray[0], $startArray[1], 0, $todayDate[0], $todayDate[1], $year);

        return $unixStartTime;
    }

    public function endTasktoUnix($timeEnd){
        
        $endArray = explode(":", $timeEnd);
        $todayDate = date("d/m/Y");
        $dateArray = explode("/", $todayDate);
        $year = intval($todayDate[2]);
        $unixStartTime = mktime($endArray[0], $endArray[1], 0, $todayDate[0], $todayDate[1], $year);
        
        return $unixEndTime;
    }

    public function timeCalculate($unixStartTime, $unixEndTime){

        $workTime = ($unixEndTime - $unixStartTime);
        // $workTime = $workTime - 3600;
        
        return $workTime;
    }

    public function convertTimeFromUnix($unixtime){ 

        $timeToshow = ($unixtime / 3600);
        $hours = floor($timeToshow);
        $mins = round(($timeToshow - $hours) * 60);
        
        return $hours ."h " . $mins . "min";
    }
}