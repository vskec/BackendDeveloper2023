<?php

class DatabaseConnection
{
    private static $instance = null;
    private $pdo;

    private function __construct($host, $dbname, $username, $password)
    {
        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance($host, $dbname, $username, $password)
    {
        if (self::$instance === null) {
            self::$instance = new self($host, $dbname, $username, $password);
        }
        return self::$instance;
    }

    public function query($sql)
    {
        return $this->pdo->query($sql);
    }

    public function execute($sql, $params)
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}
