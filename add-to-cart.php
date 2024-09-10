<?php
// add-to-cart.php

header('Content-Type: application/json');

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";
$port = 3307;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    echo json_encode([
        'success' => false,
        'message' => 'Connection failed: ' . $conn->connect_error
    ]);
    exit(); // Ensure no further code is executed
}

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

$productId = $data['productId'] ?? '';
$size = $data['size'] ?? '';
$quantity = $data['quantity'] ?? '';

// Validate data
if (empty($productId) || empty($size) || empty($quantity) || !is_numeric($quantity)) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid input'
    ]);
    exit();
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO cart (product_id, size, quantity) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $productId, $size, $quantity);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Product added to cart successfully!'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>
