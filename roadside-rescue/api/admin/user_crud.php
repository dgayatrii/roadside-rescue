<?php
require_once '../db_connect.php'; // Goes up one level
header('Content-Type: application/json');

// Admin protection
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

$action = $_GET['action'] ?? '';

if ($action === 'getAll') {
    $result = $conn->query("SELECT id, fullname, email, phone, vehicle, role FROM users ORDER BY id DESC");
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    echo json_encode(['success' => true, 'data' => $users]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

$conn->close();
?>