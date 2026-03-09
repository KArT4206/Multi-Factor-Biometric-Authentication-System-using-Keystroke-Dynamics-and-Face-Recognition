<?php
session_start();

// Security Check: If they didn't pass the face scan, kick them out!
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: login.html");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Secure Buffer Zone</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background: #f0f2f5; }
        .box { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); text-align: center; }
        .user-name { color: #2196F3; font-weight: bold; }
        .logout { margin-top: 20px; display: inline-block; color: red; text-decoration: none; font-size: 0.9em; }
    </style>
</head>
<body>
    <div class="box">
        <h1>🔓 Access Granted</h1>
        <p>Welcome to the protected zone, <span class="user-name"><?php echo htmlspecialchars($_SESSION['username']); ?></span>.</p>
        <p>Your <b>Keystroke Dynamics</b> and <b>Facial Biometrics</b> have been verified.</p>
        <a href="logout.php" class="logout">Log Out</a>
    </div>
</body>
</html>