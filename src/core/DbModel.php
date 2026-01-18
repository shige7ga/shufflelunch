<?php

class DbModel
{
    protected $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function fetchAll($sql)
    {
        try {
            $stmt = $this->pdo->query($sql);
        } catch (PDOExcepiton $e) {
            echo 'エラー発生：' . $e->getMessage() . PHP_EOL;
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function execute($sql, $params)
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            if ($params) {
                foreach ($params as $param) {
                    $stmt->bindparam(...$param);
                }
            }
            return $stmt->execute();
        } catch (PDOException $e) {
            echo 'エラー発生：' . $e->getMessage() . PHP_EOL;
        }
    }
}
