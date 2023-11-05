<?php

class Model
{
    private $conn;

    public function __construct()
    {
        $this->setConn();
    }

    public function insertUrl(string $url, string $hash): bool 
    {
        try {
            $sql =  "INSERT INTO urls (url, hash) VALUES (:url, :hash)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':url', $url);
            $stmt->bindValue(':hash', $hash);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getUrlByHash(string $hash)
    {
        try {
            $sql  = "SELECT url FROM urls WHERE hash = :hash AND vence_em  NOW()  LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':hash', $hash);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            return [];
        }
    }


    private function setConn()
    {
        try {
            $this->conn = new PDO("mysql:host=" . getenv('SERVER') . ";dbname=" . getenv('DATABASE'), getenv('USERNAME'), getenv('PASSWORD'));
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            return false;
        }
    }
}
