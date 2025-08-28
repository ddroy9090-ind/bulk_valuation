<?php
// Simple PDO connection helper
// $dsn = getenv('DB_DSN') ?: 'mysql:host=localhost;dbname=drel;charset=utf8mb4';
// $user = getenv('DB_USER') ?: 'root';
// $pass = getenv('DB_PASS') ?: 'India@123';
// $options = [
//     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
// ];

$dsn = 'mysql:host=localhost;dbname=drel_main;charset=utf8mb4';
$user = 'root';
$pass = ''; 
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    if ($e->getCode() == 1049 || strpos($e->getMessage(), 'Unknown database') !== false) {
        // Database does not exist yet; try to create it and load the schema
        $baseDsn = preg_replace('/;dbname=([^;]+)/', '', $dsn);
        $dbName = 'drel';
        if (preg_match('/dbname=([^;]+)/', $dsn, $matches)) {
            $dbName = $matches[1];
        }
        try {
            $pdo = new PDO($baseDsn, $user, $pass, $options);
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $pdo->exec("USE `$dbName`");
            $schemaPath = dirname(__DIR__) . '/schema.sql';
            if (file_exists($schemaPath)) {
                $pdo->exec(file_get_contents($schemaPath));
            }
        } catch (PDOException $inner) {
            die('DB initialization failed: ' . $inner->getMessage());
        }
    } else {
        die('DB connection failed: ' . $e->getMessage());
    }
}
?>
