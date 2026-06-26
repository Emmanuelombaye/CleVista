<?php
// CleVista Group Limited - Database Connection Configuration
// Configure these values to match your web host's MySQL settings.

define('DB_HOST', 'localhost');
define('DB_NAME', 'website_diani');
define('DB_USER', 'root');
define('DB_PASS', 'password');

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    // Database connection could not be established. 
    // We set $pdo to null and handle it gracefully on user pages, or redirect in the admin panel.
    $pdo = null;
    $db_connection_error = $e->getMessage();
}
