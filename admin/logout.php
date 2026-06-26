<?php
/**
 * CleVista Group Limited - Session Terminator
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Clear and destroy session variables
$_SESSION = [];
session_destroy();

header("Location: login.php");
exit();
