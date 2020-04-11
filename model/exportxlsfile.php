<?php

class ExportXLS extends DBconnect{

    public function getData($projectId){

        $pdo= $this->connect();

        $month = date("m");
        $year = date("Y");

        $query = $pdo->prepare("SELECT task_name, work_time FROM time WHERE project_id = :projectId AND MONTH(FROM_UNIXTIME(add_date)) = :month AND YEAR(FROM_UNIXTIME(add_date))= :year");
        
        $query->bindValue(':projectId', $projectId, PDO::PARAM_INT);
        $query->bindValue(':month', $month, PDO::PARAM_INT);
        $query->bindValue(':year', $year, PDO::PARAM_INT);
        
        $query->execute();
        
        $numRows = $query->rowCount();

        if ($numRows > 0) {
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $row;
            }
            return $data;
        }
    }
}