<?php

require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

class DbManager
{
    private $pdo;
    public function __construct(){
        $dbHost = $_ENV['DB_HOST'];
        $dbName = $_ENV['DB_NAME'];
        $dbUser = $_ENV['DB_USER'];
        $dbPassword = $_ENV['DB_PASSWORD'];
        try {
            $this->pdo = new PDO(
                "mysql:host=$dbHost;dbname=$dbName",
                $dbUser,
                $dbPassword,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]);
        } catch (PDOException $e) {
            echo 'DB connect error: ' . $e->getMessasge() . PHP_EOL;
        }
    }
}
