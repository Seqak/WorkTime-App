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
}