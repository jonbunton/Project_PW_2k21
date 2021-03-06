<?php
    session_start();
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $database = 'project_pw';
    $port = '3306';
    $dsn = "mysql:host=$host;dbname=$database";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
}