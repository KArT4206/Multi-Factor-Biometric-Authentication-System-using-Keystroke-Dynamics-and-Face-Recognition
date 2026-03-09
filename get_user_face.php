<?php
// get_user_face.php
session_start();
$users = file('users.txt', FILE_IGNORE_NEW_LINES);
foreach ($users as $line) {
    $user = json_decode($line, true);
    if ($user['username'] === $_SESSION['temp_user']) {
        echo json_encode($user['faceDescriptor']);
        exit;
    }
}
?>