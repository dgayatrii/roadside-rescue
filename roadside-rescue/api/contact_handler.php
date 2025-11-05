<?php
require_once 'db_connect.php'; // In the same folder

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['userName'] ?? '');
    $email = trim($_POST['userEmail'] ?? '');
    $message_text = trim($_POST['userMessage'] ?? '');

    if (empty($name) || empty($email) || empty($message_text) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = "Error: Please fill all fields correctly.";
    } else {
        // Save to database (using the table from your .sql file)
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message_text);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Success: Thank you, $name! Your message has been sent.";
        } else {
            $_SESSION['message'] = "Error: Could not send message. Please try again.";
        }
        $stmt->close();
    }
} else {
    $_SESSION['message'] = "Error: Invalid request method.";
}

$conn->close();
// Redirect back to the contact page
header('Location: ../contact.php'); // Go up and out to contact.php
exit;
?>