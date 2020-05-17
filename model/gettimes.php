<?php

class GetTimes extends DBconnect{

    public function getMonthHours($projectId){

        $pdo = $this->connect();

        $month = date("m");
        $year = date("Y");
        $monthHoursQuery = $pdo->prepare("SELECT SUM(work_time) FROM time WHERE project_id = :projectId AND MONTH(FROM_UNIXTIME(add_date)) = :month AND YEAR(FROM_UNIXTIME(add_date))= :year");
        
        $monthHoursQuery->bindVAlue(':projectId', $projectId, PDO::PARAM_INT);
        $monthHoursQuery->bindVAlue(':month', $month, PDO::PARAM_INT);
        $monthHoursQuery->bindVAlue(':year', $year, PDO::PARAM_INT);
        $monthHoursQuery->execute();

        
        $hoursAmount = $monthHoursQuery->fetch();
        $hoursAmount = $hoursAmount[0];

        return $hoursAmount;
    }

    public function getTodayHours($projectId){

        $pdo = $this->connect();

        $day = date("d");
        $month = date("m");
        $year = date("Y");

        $todayHoursQuery = $pdo->prepare("SELECT SUM(work_time) FROM time WHERE project_id = :projectId AND DAY(FROM_UNIXTIME(add_date)) = :day AND MONTH(FROM_UNIXTIME(add_date)) = :month AND YEAR(FROM_UNIXTIME(add_date))= :year");

        $todayHoursQuery->bindVAlue(':projectId', $projectId, PDO::PARAM_INT);
        $todayHoursQuery->bindVAlue(':day', $day, PDO::PARAM_INT);
        $todayHoursQuery->bindVAlue(':month', $month, PDO::PARAM_INT);
        $todayHoursQuery->bindVAlue(':year', $year, PDO::PARAM_INT);
        $todayHoursQuery->execute();

        $hoursAmount = $todayHoursQuery->fetch();
        $hoursAmount = $hoursAmount[0];

        return $hoursAmount;
    }

    public function getTodayTasks($projectId)
    {
        $pdo = $this->connect();

        $day = date("d");
        $month = date("m");
        $year = date("Y");

        $todayTasksStmt = $pdo->prepare("SELECT id, task_name, start_time, end_time FROM time WHERE project_id = :projectId AND DAY(FROM_UNIXTIME(add_date)) = :day AND MONTH(FROM_UNIXTIME(add_date)) = :month AND YEAR(FROM_UNIXTIME(add_date))= :year");

        $todayTasksStmt->bindVAlue(':projectId', $projectId, PDO::PARAM_INT);
        $todayTasksStmt->bindVAlue(':day', $day, PDO::PARAM_INT);
        $todayTasksStmt->bindVAlue(':month', $month, PDO::PARAM_INT);
        $todayTasksStmt->bindVAlue(':year', $year, PDO::PARAM_INT);
        $todayTasksStmt->execute();


        $numRows = $todayTasksStmt->rowCount();
        if ($numRows > 0) {
            while ($row = $todayTasksStmt->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $row;
            }
            return $data;
        }
    }

}