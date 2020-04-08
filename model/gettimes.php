<?php

class GetTimes extends DBconnect{

    public function getMonthHours($projectId){

        $pdo = $this->connect();

        $month = date("m");
        $year = date("Y");
        $monthHoursQuery = $pdo->query("SELECT SUM(work_time) FROM time WHERE project_id = '$projectId' AND MONTH(FROM_UNIXTIME(add_date)) = '$month' AND YEAR(FROM_UNIXTIME(add_date))= '$year'");
        $hoursAmount = $monthHoursQuery->fetch();
        $hoursAmount = $hoursAmount[0];

        return $hoursAmount;
    }

    public function getTodayHours($projectId){

        $pdo = $this->connect();

        $day = date("d");
        $month = date("m");
        $year = date("Y");
        $monthHoursQuery = $pdo->query("SELECT SUM(work_time) FROM time WHERE project_id = '$projectId' AND DAY(FROM_UNIXTIME(add_date)) = '$day' AND MONTH(FROM_UNIXTIME(add_date)) = '$month' AND YEAR(FROM_UNIXTIME(add_date))= '$year'");
        $hoursAmount = $monthHoursQuery->fetch();
        $hoursAmount = $hoursAmount[0];

        return $hoursAmount;
    }

}