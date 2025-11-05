<?php
require_once 'db_connect.php'; // In the same folder
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'user') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $service_id = intval($_POST['service_id'] ?? 0);
    $location = trim($_POST['location'] ?? '');
    $vehicle_details = trim($_POST['vehicle_details'] ?? '');
    $issue_description = trim($_POST['issue_description'] ?? '');

    if ($service_id <= 0 || empty($location) || empty($issue_description)) {
        echo json_encode(['success' => false, 'message' => 'Please fill all required fields.']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO bookings (user_id, service_id, location, vehicle_details, issue_description, status) VALUES (?, ?, ?, ?, ?, 'pending')");
    $stmt->bind_param("iisss", $user_id, $service_id, $location, $vehicle_details, $issue_description);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Booking created successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to create booking.']);
    }
    
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

$conn->close();
?>