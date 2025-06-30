<?php
require_once 'config.php';

header('Content-Type: application/json');

$student_id = isset($_GET['student_id']) ? (int) $_GET['student_id'] : 0;

if ($student_id <= 0) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT id, service_type, appointment_date, appointment_time, status 
        FROM appointments 
        WHERE student_id = ? 
        AND (appointment_date >= CURDATE() OR status = 'scheduled')
        ORDER BY appointment_date ASC, appointment_time ASC
        LIMIT 5";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

$appointments = [];
while ($row = $result->fetch_assoc()) {
    $appointments[] = $row;
}

echo json_encode($appointments);

$stmt->close();
$conn->close();
?>