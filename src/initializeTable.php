<?php

require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dbHost = $_ENV['DB_HOST'];
$dbName = $_ENV['DB_NAME'];
$dbUser = $_ENV['DB_USER'];
$dbPassword = $_ENV['DB_PASSWORD'];

try {
$pdo = new PDO(
    "mysql:host=$dbHost;dbname=$dbName",
    $dbUser,
    $dbPassword,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    echo 'DB connect error: ' . $e->getMessasge() . PHP_EOL;
}

$dropSql = 'DROP TABLE IF EXISTS employees';
try {
    $pdo->exec($dropSql);
    echo 'テーブルを削除しました' . PHP_EOL;
} catch (PDOException $e) {
    echo 'DBエラー: ' . $e->getMessasge() . PHP_EOL;
}

$createSql = <<<EOT
    CREATE TABLE employees
        (id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
        emp_no INTEGER NOT NULL UNIQUE,
        emp_name VARCHAR(100) NOT NULL,
        create_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) DEFAULT CHARSET=utf8mb4;
EOT;
try {
    $pdo->exec($createSql);
    echo 'テーブルを作成しました' . PHP_EOL;
} catch (PDOException $e) {
    echo 'DBエラー: ' . $e->getMessasge() . PHP_EOL;
}
