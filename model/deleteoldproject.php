<?php

class DeleteProject extends DBconnect{

    public function deletePro($projectId){
        
        $pdo = $this->connect();

        try {
            
            $stmtTime = $pdo->prepare("DELETE FROM time WHERE project_id = :id");
            $stmtProject = $pdo->prepare("DELETE FROM projects WHERE id = :id");

            $pdo->beginTransaction();

            $stmtTime->bindValue(':id', $projectId, PDO::PARAM_INT);
            $stmtTime->execute();

            $stmtProject->bindValue(':id', $projectId, PDO::PARAM_INT);
            $stmtProject->execute();

            $pdo->commit();

        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function deleteTask($taskId, $projectId){

        $pdo = $this->connect();

        try {
            // SELECT total_Hours from Projects table.
            $totalHoursQuery = $pdo->prepare("SELECT hours_total FROM projects WHERE id = :projectid");
            $totalHoursQuery->bindValue(":projectid", $projectId, PDO::PARAM_INT);
            $totalHoursQuery->execute();

            $totalHours = $totalHoursQuery->fetch();

            // SELECT current work_time
            $workTimeQuery = $pdo->prepare("SELECT work_time FROM time WHERE id = :taskid");
            $workTimeQuery->bindValue(":taskid", $taskId, PDO::PARAM_INT);
            $workTimeQuery->execute();

            $workTimeHours = $workTimeQuery->fetch();

            // DELETE work_time from total_hours
            $updateHours = $totalHours['hours_total'] - $workTimeHours['work_time'];

            $stmtProject = $pdo->prepare("UPDATE projects SET hours_total = :updatehours WHERE id = :projectid");
            $stmtTask = $pdo->prepare("DELETE FROM time WHERE id = :id");

            $pdo->beginTransaction();

            //Bind projects values
            $stmtProject->bindValue(':updatehours', $updateHours, PDO::PARAM_INT);
            $stmtProject->bindValue(':projectid', $projectId, PDO::PARAM_INT);
            $stmtProject->execute();

            $stmtTask->bindValue(':id', $taskId, PDO::PARAM_INT);
            $stmtTask->execute();

            $pdo->commit();

        } catch (\Throwable $e) {
            throw $e;
        }

    }
}