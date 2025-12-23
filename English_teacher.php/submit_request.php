<?php
// ================================
// submit_request.php
// Handles contact / lesson requests
// ================================

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
    exit;
}

// Retrieve and sanitize input data
$full_name  = trim($_POST['full_name'] ?? '');
$email      = trim($_POST['email'] ?? '');
$service_id = intval($_POST['service_id'] ?? 0);
$message    = trim($_POST['message'] ?? '');

// Basic validation
if ($full_name === '' || $email === '' || $service_id === 0) {
    echo json_encode(['status' => 'error', 'message' => 'All required fields must be filled out.']);
    exit;
}

// Prepare SQL statement
$sql = "INSERT INTO requests (full_name, email, service_id, message) VALUES (:full_name, :email, :service_id, :message)";
$stmt = $pdo->prepare($sql);

// Bind parameters
$stmt->bindParam(':full_name', $full_name);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':service_id', $service_id);
$stmt->bindParam(':message', $message);

// Execute and check
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Your request has been submitted successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to submit your request. Please try again.']);
}
?>