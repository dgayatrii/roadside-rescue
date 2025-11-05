<?php
require_once '../db_connect.php'; // Goes up one level
header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'create':
        $service_name = trim($_POST['service_name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price = floatval($_POST['price'] ?? 0);
        $image_url = trim($_POST['image_url'] ?? 'images/default.png');
        
        $stmt = $conn->prepare("INSERT INTO services (service_name, description, price, image_url) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $service_name, $description, $price, $image_url);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Service added']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add service']);
        }
        $stmt->close();
        break;

    case 'getAll':
        $result = $conn->query("SELECT * FROM services ORDER BY id DESC");
        $services = [];
        while ($row = $result->fetch_assoc()) {
            $services[] = $row;
        }
        echo json_encode(['success' => true, 'data' => $services]);
        break;

    case 'get':
        $id = intval($_GET['id'] ?? 0);
        $stmt = $conn->prepare("SELECT * FROM services WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            echo json_encode(['success' => true, 'data' => $result->fetch_assoc()]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Service not found']);
        }
        $stmt->close();
        break;

    case 'update':
        $id = intval($_POST['id'] ?? 0);
        $service_name = trim($_POST['service_name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price = floatval($_POST['price'] ?? 0);
        $image_url = trim($_POST['image_url'] ?? 'images/default.png');
        $status = $_POST['status'] ?? 'active';

        $stmt = $conn->prepare("UPDATE services SET service_name = ?, description = ?, price = ?, image_url = ?, status = ? WHERE id = ?");
        $stmt->bind_param("ssdssi", $service_name, $description, $price, $image_url, $status, $id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Service updated']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update']);
        }
        $stmt->close();
        break;

    case 'delete':
        $id = intval($_GET['id'] ?? 0);
        $stmt = $conn->prepare("DELETE FROM services WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Service deleted']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete']);
        }
        $stmt->close();
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}
$conn->close();
?>