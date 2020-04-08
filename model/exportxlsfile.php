<?php

class ExportXLS extends DBconnect{

    public function getData($projectId){

        $pdo= $this->connect();

        $query = $pdo->query("SELECT task_name, work_time FROM time WHERE project_id = '$projectId'");
        $numRows = $query->rowCount();

        if ($numRows > 0) {
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $row;
            }
            return $data;
        }
    }
}