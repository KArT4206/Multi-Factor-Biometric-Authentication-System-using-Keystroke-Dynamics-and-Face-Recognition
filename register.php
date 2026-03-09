<?php
// register.php
$file = __DIR__ . '/users.txt';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Get raw input
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $timings = $_POST['timings'] ?? '[]';
    $faceDescriptor = $_POST['faceDescriptor'] ?? '[]';

    // 2. CRYPTOGRAPHY: Hash the password (One-way encryption)
    // This makes the password unreadable in users.txt
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // 3. Prepare data structure
    $userData = [
        'username' => $username,
        'password' => $hashedPassword, // Save the HASH, not the text
        'timings' => json_decode($timings, true),
        'faceDescriptor' => json_decode($faceDescriptor, true),
        'created_at' => date('Y-m-d H:i:s')
    ];

    // 4. Save to file
    $jsonLine = json_encode($userData) . PHP_EOL;
    
    if (file_put_contents($file, $jsonLine, FILE_APPEND | LOCK_EX)) {
        echo "Registration Secure & Complete. Redirecting to Login...";
        header("Refresh: 2; url=login.html");
    } else {
        echo "Error: Could not write to security file.";
    }
}
?>