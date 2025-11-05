<?php
require_once '../db_connect.php'; // Goes up one level
header('Content-Type: application/json');

// Admin protection
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'getAll':
        // Use the 'booking_summary' VIEW from your SQL file
        $result = $conn->query("SELECT * FROM booking_summary");
        $bookings = [];
        while ($row = $result->fetch_assoc()) {
            $bookings[] = $row;
        }
        echo json_encode(['success' => true, 'data' => $bookings]);
        break;

    case 'update':
        $id = intval($_POST['id'] ?? 0);
        $status = trim($_POST['status'] ?? '');
        $mechanic = trim($_POST['mechanic_name'] ?? '');

        if ($id <= 0 || empty($status)) {
            echo json_encode(['success' => false, 'message' => 'Invalid data.']);
            exit;
        }

        $stmt = $conn->prepare("UPDATE bookings SET status = ?, mechanic_name = ? WHERE id = ?");
        $stmt->bind_param("ssi", $status, $mechanic, $id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Booking updated!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update booking.']);
        }
        $stmt->close();
        break;

    case 'delete':
        $id = intval($_GET['id'] ?? 0);
        if ($id <= 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid ID.']);
            exit;
        }
        
        $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Booking deleted.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete.']);
        }
        $stmt->close();
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action.']);
}
$conn->close();
?>