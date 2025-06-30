<?php
require_once 'config.php';

ini_set('display_errors', 1);

// TEMPORARILY DISABLE CSRF CHECK FOR DEBUGGING

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Manually set a valid student ID for testing
    $student_id = 1;

    // Get and sanitize input data
    $service_type = $conn->real_escape_string($_POST['serviceType'] ?? '');
    $appointment_date = $conn->real_escape_string($_POST['appointmentDate'] ?? '');
    $appointment_time = $conn->real_escape_string($_POST['appointmentTime'] ?? '');
    $notes = $conn->real_escape_string($_POST['appointmentNotes'] ?? '');

    // Check required fields
    if (empty($service_type) || empty($appointment_date) || empty($appointment_time)) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit;
    }

    // Debug print inputs
    // echo json_encode(compact('student_id', 'service_type', 'appointment_date', 'appointment_time', 'notes')); exit;

    $sql = "INSERT INTO appointments (student_id, service_type, appointment_date, appointment_time, notes, status, created_at) 
            VALUES (?, ?, ?, ?, ?, 'scheduled', NOW())";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param("issss", $student_id, $service_type, $appointment_date, $appointment_time, $notes);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Appointment booked successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error booking appointment: ' . $stmt->error]);
}


    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?>
