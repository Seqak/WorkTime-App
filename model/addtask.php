<?php

class Addtask extends DBconnect{

    public function addNewTask($workTime, $unixAddTime, $projectId, $taskName, $unixStartTime, $unixEndTime){

        $pdo = $this->connect();

        try {

            $totalHoursQuery = $pdo->prepare("SELECT hours_total FROM projects WHERE id = :projectid");
            $totalHoursQuery->bindValue(":projectid", $projectId, PDO::PARAM_INT);
            $totalHoursQuery->execute();
            
            $totalHours = $totalHoursQuery->fetch();

            $updateHours = $totalHours['hours_total'] + $workTime;

            $stmtTask = $pdo->prepare("INSERT INTO time VALUES (NULL, :taskname, :worktime, :adddate, :starttime, :endtime, :projectid)");
            $stmtProject = $pdo->prepare("UPDATE projects SET hours_total = :updatehours WHERE id = :projectid"); // To update

            $pdo->beginTransaction();

            $stmtTask->bindValue(':taskname', $taskName, PDO::PARAM_STR);
            $stmtTask->bindValue(':worktime', $workTime, PDO::PARAM_INT);
            $stmtTask->bindValue(':adddate', $unixAddTime, PDO::PARAM_INT);
            $stmtTask->bindValue(':starttime', $unixStartTime, PDO::PARAM_INT);
            $stmtTask->bindValue(':endtime', $unixEndTime, PDO::PARAM_INT);
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

    public function editTask($workTime, $projectId, $taskName, $unixStartTime, $unixEndTime, $taskId)
    {
        $pdo = $this->connect();

        try
        {
            //SELECT total_Hours from Projects table.
            $totalHoursQuery = $pdo->prepare("SELECT hours_total FROM projects WHERE id = :projectid");
            $totalHoursQuery->bindValue(":projectid", $projectId, PDO::PARAM_INT);
            $totalHoursQuery->execute();

            $totalHours = $totalHoursQuery->fetch();

            //SELECT work_time from this specific task.
            $workTimeQuery = $pdo->prepare("SELECT work_time FROM time WHERE id = :taskid");
            $workTimeQuery->bindValue(":taskid", $taskId, PDO::PARAM_INT);
            $workTimeQuery->execute();

            $workTimeHours = $workTimeQuery->fetch();

            //Subtract work_time from total_hours.
            $totalHours['hours_total'] = $totalHours['hours_total'] - $workTimeHours['work_time'];

            //SET new total_hours.
            $updateHours = $totalHours['hours_total'] + $workTime;

            //PREPARE total_hours UPDATE
            $stmtProject = $pdo->prepare("UPDATE projects SET hours_total = :updatehours WHERE id = :projectid");

            //PREPARE task UPDATE
            $stmtTask = $pdo->prepare("UPDATE time SET task_name = :taskname, work_time = :worktime, start_time = :starttime, end_time = :endtime  WHERE id = :taskid");

            $pdo->beginTransaction();

            //Bind projects values
            $stmtProject->bindValue(':updatehours', $updateHours, PDO::PARAM_INT);
            $stmtProject->bindValue(':projectid', $projectId, PDO::PARAM_INT);
            $stmtProject->execute();

            //Bind task values
            $stmtTask->bindValue(':taskname', $taskName, PDO::PARAM_STR);
            $stmtTask->bindValue(':worktime', $workTime, PDO::PARAM_INT);
            $stmtTask->bindValue(':starttime', $unixStartTime, PDO::PARAM_INT);
            $stmtTask->bindValue(':endtime', $unixEndTime, PDO::PARAM_INT);
            $stmtTask->bindValue(':taskid', $taskId, PDO::PARAM_INT);
            $stmtTask->execute();

            $pdo->commit();


        } catch (\Throwable $e)
        {
            if ($pdo->inTransaction())
            {
                $pdo->rollback();
            }
            throw $e;
        }



    }

}