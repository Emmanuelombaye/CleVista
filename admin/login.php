<?php
/**
 * CleVista Group Limited - Admin login interface
 * Handles administrative access authentication.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../includes/db.php';

$error = null;

// Redirect if already logged in
if (isset($_SESSION['admin_user'])) {
    header("Location: index.php");
    exit();
}

// Check database setup status
$db_not_ready = ($pdo === null);

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$db_not_ready) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password_hash'])) {
            // Authentication successful, establish session variables
            $_SESSION['admin_user'] = $user['username'];
            $_SESSION['admin_email'] = $user['email'];
            
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid username or password configuration.";
        }
    } catch (PDOException $e) {
        $error = "Database error during query execution: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CleVista Group | Administrator Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body class="admin-body admin-login-wrapper">

    <div class="admin-login-card">
        <div style="text-align: center; margin-bottom: 24px;">
            <a href="../index.php" style="font-family: 'Outfit'; font-size: 1.5rem; font-weight: 800; color: #fff; letter-spacing: 1px;">CLEVISTA</a>
            <p style="color: var(--admin-accent); text-transform: uppercase; font-size: 0.75rem; letter-spacing: 2px; font-weight: 600;">Control Console</p>
        </div>

        <?php if ($db_not_ready): ?>
            <div class="alert alert-error" style="border-radius: 6px;">
                <i class="fa-solid fa-triangle-exclamation"></i> Database is not configured. 
                <a href="setup.php" style="color: #fff; text-decoration: underline; font-weight: 600;">Run database setup tool now</a>.
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-error" style="border-radius: 6px; padding: 12px 16px;">
                <i class="fa-solid fa-circle-exclamation"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" required <?php echo $db_not_ready ? 'disabled' : ''; ?>>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required <?php echo $db_not_ready ? 'disabled' : ''; ?>>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 16px;" <?php echo $db_not_ready ? 'disabled' : ''; ?>>Sign In <i class="fa-solid fa-right-to-bracket"></i></button>
        </form>
        
        <div style="text-align: center; margin-top: 24px; font-size: 0.8rem;">
            <a href="../index.php" style="color: var(--admin-text-muted);"><i class="fa-solid fa-arrow-left"></i> Return to Site Home</a>
        </div>
    </div>

</body>
</html>
