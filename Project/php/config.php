<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'projectuser'); // new safe user
define('DB_PASS', 'projectpass'); // matching password
define('DB_NAME', 'student_health_hub');

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8
$conn->set_charset("utf8");

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
