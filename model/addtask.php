<?php

class Addtask extends DBconnect{

    public function addNewTask($workTime, $unixAddTime, $projectId, $taskName){

        $pdo = $this->connect();

        try {

            $totalHoursQuery = $pdo->query("SELECT hours_total FROM projects WHERE id = '$projectId'");
            $totalHours = $totalHoursQuery->fetch();

            $updateHours = $totalHours['hours_total'] + $workTime;

            $stmtTask = $pdo->prepare("INSERT INTO time VALUES (NULL, :taskname, :worktime, :adddate, :projectid)");
            $stmtProject = $pdo->prepare("UPDATE projects SET hours_total = :updatehours WHERE id = :projectid"); // To update

            $pdo->beginTransaction();

            $stmtTask->bindValue(':taskname', $taskName, PDO::PARAM_STR);
            $stmtTask->bindValue(':worktime', $workTime, PDO::PARAM_INT);
            $stmtTask->bindValue(':adddate', $unixAddTime, PDO::PARAM_INT);
            $stmtTask->bindValue(':projectid', $projectId, PDO::PARAM_INT);
            $stmtTask->execute();

            $stmtProject->bindValue(':updatehours', $updateHours, PDO::PARAM_INT);
            $stmtProject->bindValue(':projectid', $projectId, PDO::PARAM_INT);
            $stmtProject->execute();

            $pdo->commit();
                
        } catch (\Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollback();
            }
            throw $e;
        }

    }


}