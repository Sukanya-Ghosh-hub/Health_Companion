<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'config.php';

// Fetch all appointments
$sql = "SELECT * FROM appointments ORDER BY appointment_date DESC, appointment_time DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appointments Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Appointments Dashboard</h2>
    <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Student ID</th>
                <th>Service Type</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Notes</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['student_id'] ?></td>
                        <td><?= htmlspecialchars($row['service_type']) ?></td>
                        <td><?= $row['appointment_date'] ?></td>
                        <td><?= $row['appointment_time'] ?></td>
                        <td>
                            <span class="badge bg-<?= match($row['status']) {
                                'scheduled' => 'primary',
                                'completed' => 'success',
                                'cancelled' => 'danger',
                                'no-show' => 'warning',
                                default => 'secondary'
                            } ?>">
                                <?= $row['status'] ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($row['notes']) ?></td>
                        <td><?= $row['created_at'] ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="8" class="text-center text-muted">No appointments found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
