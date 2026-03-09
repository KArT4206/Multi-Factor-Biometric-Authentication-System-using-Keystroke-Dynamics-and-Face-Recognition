<?php
// get_stored_face.php
session_start();

if (!isset($_SESSION['pending_user'])) {
    echo json_encode(['error' => 'No session found']);
    exit;
}

$target = $_SESSION['pending_user'];
$users = file('users.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($users as $line) {
    $user = json_decode($line, true);
    if ($user['username'] === $target) {
        echo json_encode(['descriptor' => $user['faceDescriptor']]);
        exit;
    }
}

echo json_encode(['error' => 'User not found']);
?>