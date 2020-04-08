<?php

class GetProjects extends DBconnect{

    public function getAllProjects(){

        $query = $this->connect()->query("SELECT * FROM projects");
        $numRows = $query->rowCount();

        if ($numRows > 0) {
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $row;
            }
            return $data;
        }

    }

}