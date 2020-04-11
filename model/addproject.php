<?php

class Addproject extends DBconnect{

    public function addNewProject($nameProject){

        $pdo = $this->connect();

        try {

            $projectNameCheck = $pdo->prepare("SELECT id FROM projects WHERE project_name = :project_name");
            $projectNameCheck->bindValue(':project_name', $nameProject, PDO::PARAM_STR);
            $projectNameCheck->execute();

            $nameExist = $projectNameCheck->fetch();

            if ($nameExist > 0 ) {
               
                return false;
                exit();
            }
            else{

                $stmtProject = $pdo->prepare("INSERT INTO projects VALUES (NULL, :project_name, 0, 0, 0)");
                $stmtProject->bindValue(':project_name', $nameProject, PDO::PARAM_STR);
                $stmtProject->execute();
                return true;
            }


        } catch (\Throwable $e) {
            throw $e;
        }

    }

}