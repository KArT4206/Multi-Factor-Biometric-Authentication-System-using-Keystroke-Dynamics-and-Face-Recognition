<?php
// auth.php
session_start();
header('Content-Type: text/plain');

function calculateTimingDiff($stored, $input) {
    if (empty($stored) || empty($input)) return 999;
    $minLen = min(count($stored), count($input));
    $sum = 0;
    for ($i = 0; $i < $minLen; $i++) {
        $sum += abs($stored[$i] - $input[$i]);
    }
    return $sum / $minLen;
}

$users = file_exists('users.txt') ? file('users.txt', FILE_IGNORE_NEW_LINES) : [];
$inputUsername = $_POST['username'] ?? '';
$inputPassword = $_POST['password'] ?? '';
$inputTimings = json_decode($_POST['timings'] ?? '{}', true);

foreach ($users as $line) {
    $user = json_decode($line, true);
    if (!$user) continue;

    // 1. CRYPTOGRAPHIC CHECK: Verify the hashed password
    if ($user['username'] === $inputUsername && password_verify($inputPassword, $user['password'])) {
        
        // 2. BIOMETRIC CHECK: Keystroke Dynamics
        $holdDiff = calculateTimingDiff($user['timings']['holds'] ?? [], $inputTimings['holds'] ?? []);
        $ddDiff = calculateTimingDiff($user['timings']['dds'] ?? [], $inputTimings['dds'] ?? []);
        $totalDiff = ($holdDiff + $ddDiff) / 2;

        // Threshold (Strict: 50ms)
        if ($totalDiff < 50) {
            $_SESSION['pending_user'] = $inputUsername;
            // Pass to the next gate: Face Verification
            header('Location: face_verify.html');
            exit;
        } else {
            echo "Access Denied: Keystroke rhythm mismatch.";
            exit;
        }
    }
}

echo "Access Denied: Invalid credentials.";
?>