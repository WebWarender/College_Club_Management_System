<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
$is_logged_in = isset($_SESSION['user_id']);
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
$user_role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : '';
?>
