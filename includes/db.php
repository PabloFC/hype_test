<?php
// Reusable PDO connection

declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';

// Returns a singleton PDO connection with secure settings (prepared statements, no emulation)
function db_get_connection(): PDO {
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=%s', DB_HOST, DB_PORT, DB_NAME, DB_CHARSET);
    $options = [
        PDO::ATTR_ERRMODE => APP_DEBUG ? PDO::ERRMODE_EXCEPTION : PDO::ERRMODE_SILENT,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch (PDOException $e) {
        if (APP_DEBUG) {
            throw $e;
        }
        // In production, show generic message and log error if applicable
        exit('Database connection error.');
    }

    return $pdo;
}
