<?php
session_start();

// Simple authentication check
function isAuthenticated() {
    return isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true;
}

// Admin login function
function adminLogin($username, $password) {
    global $conn;
    
    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, password FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();
        if (password_verify($password, $admin['password'])) {
            $_SESSION['authenticated'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['last_activity'] = time();
            return true;
        }
    }
    return false;
}

// Logout function
function logout() {
    session_unset();
    session_destroy();
}

// Check if user should be redirected to login
function requireAuth() {
    if (!isAuthenticated()) {
        header('Location: ../login.php');
        exit();
    }
    
    // Session timeout (30 minutes)
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
        logout();
        header('Location: ../login.php?timeout=1');
        exit();
    }
    $_SESSION['last_activity'] = time();
}

// CSRF protection
function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
?>