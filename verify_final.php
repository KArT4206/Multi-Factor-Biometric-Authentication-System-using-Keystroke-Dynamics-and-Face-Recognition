<?php
session_start();

// This script is called by face_verify.html when the face matches
if (isset($_SESSION['pending_user'])) {
    // Promote user from 'pending' to 'authenticated'
    $_SESSION['authenticated'] = true;
    $_SESSION['username'] = $_SESSION['pending_user'];
    unset($_SESSION['pending_user']); // Clean up

    echo json_encode(['status' => 'success', 'redirect' => 'dashboard.php']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No active session']);
}
?>