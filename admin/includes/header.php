<?php
/**
 * CleVista Group Limited - Admin Shared Layout Header
 * Verifies active session authorization, loads dependencies, and initializes panel body.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Access Control check
if (!isset($_SESSION['admin_user'])) {
    header("Location: login.php");
    exit();
}

require_once __DIR__ . '/../../includes/db.php';

// Redirect to login if database connections break
if ($pdo === null) {
    header("Location: login.php");
    exit();
}

$active_user = $_SESSION['admin_user'];
$active_email = $_SESSION['admin_email'] ?? 'admin@clevistagroup.com';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CleVista Admin Portal</title>
    
    <!-- Icons & Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Dashboard Stylesheet -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body class="admin-body">
<?php 
// Include the sidebar component directly into the layouts
include_once __DIR__ . '/sidebar.php'; 
?>
<main class="admin-main">
