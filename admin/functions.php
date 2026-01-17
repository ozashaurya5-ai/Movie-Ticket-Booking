<?php
// Prevent function re-declaration
if (!function_exists('admin_check')) {
    function admin_check() {
        if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
        if (!isset($_SESSION['admin_id'])) {
            header("Location: login.php");
            exit;
        }
    }
}

if (!function_exists('admin_log')) {
    function admin_log($action, $details = '') {
        $logFile = __DIR__ . '/../admin/admin-log.txt';
        $entry = "[" . date('Y-m-d H:i:s') . "] $action - $details\n";
        file_put_contents($logFile, $entry, FILE_APPEND);
    }
}

// Optional helper to connect if config not already included
if (!isset($conn)) {
    include_once __DIR__ . '/../config.php';
}
?>