<?php
require_once 'php/auth.php';

// Regenerate session ID to prevent session fixation
session_regenerate_id(true);

// Destroy all session data
$_SESSION = array();

// Delete session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Redirect to login page with logout message
header('Location: login.php?logout=1');
exit();
?>