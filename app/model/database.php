<?php

namespace App\model;

use PDO;
use PDOException;


class Database {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $databasename = "legous_db";
    protected $conn = null;

    public function connection_database() {
        try {
            $conn = new PDO(
                "mysql:host=$this->servername;dbname=$this->databasename",
                $this->username,
                $this->password
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw $e;
        }
        return $conn;
    }

    public function close_connection() {
        $this->conn = null;
    }

    public function pdo_queryAll($sql) {
        $stmt = $this->connection_database()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    public function pdo_queryOne($sql) {
        $stmt = $this->connection_database()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    }

    public function pdo_query_value($sql) {
        $stmt = $this->connection_database()->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return array_values($row)[0];
    }

    public function pdo_execute($sql) {
        $stmt = $this->connection_database()->prepare($sql);
        $stmt->execute();
    }

    
}



































































































