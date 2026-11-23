<?php
/**
 * =============================================================================
 * Database Connection (db_connect.php)
 * Employee Record Tracking System
 * =============================================================================
 */

date_default_timezone_set('Asia/Manila');

// Check if running locally (XAMPP) or deployed online (InfinityFree)
$is_local = in_array($_SERVER['SERVER_NAME'] ?? 'localhost', ['localhost', '127.0.0.1', '::1'])
            || (php_sapi_name() === 'cli');

if ($is_local) {
    // -------------------------------------------------------------------------
    // LOCAL XAMPP SETTINGS
    // -------------------------------------------------------------------------
    $host = '127.0.0.1';
    $db   = 'employee_tracker_db';
    $user = 'root';
    $pass = ''; // Default XAMPP password is empty

    // Try connecting (auto-handles blank password or '1234')
    try {
        $pdo = new PDO("mysql:host={$host};port=3306;dbname={$db};charset=utf8mb4", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    } catch (PDOException $e) {
        try {
            $pdo = new PDO("mysql:host={$host};port=3306;dbname={$db};charset=utf8mb4", $user, '1234', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e2) {
            die("Database Connection Error: " . $e2->getMessage());
        }
    }
} else {
    // -------------------------------------------------------------------------
    // INFINITYFREE HOSTING SETTINGS
    // (Update these with your credentials from InfinityFree Control Panel)
    // -------------------------------------------------------------------------
    $host = 'sql202.infinityfree.com';                     // InfinityFree MySQL Hostname
    $user = 'if0_43496270';                         // InfinityFree Username
    $pass = 'CS7zXSRxjNi83B';           // InfinityFree Password
    $db   = 'if0_43496270_employee_tracker_db';     // InfinityFree Database Name

    try {
        $pdo = new PDO("mysql:host={$host};port=3306;dbname={$db};charset=utf8mb4", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    } catch (PDOException $e) {
        die("InfinityFree Database Connection Error: " . $e->getMessage());
    }
}
