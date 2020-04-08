<?php

class DBconnect{

    private $dbHost;
    private $dbUser;
    private $dbPassword;
    private $dbName;
    private $charset;

    protected function connect(){
    
        $this->dbHost = 'localhost';
        $this->dbUser = 'root';
        $this->dbPassword = '';
        $this->dbName = 'worktimeapp';
        $this->charset = 'utf8mb4';

        try {

            $dsn = "mysql:host=".$this->dbHost . ";dbname=".$this->dbName . ";charset=".$this->charset;
            $pdo = new PDO($dsn, $this->dbUser, $this->dbPassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $pdo;

        } catch (\Exception $e) {
            echo "Brak połączenia z bazą danych " . $e->getMessage() ;
        }
    }

}