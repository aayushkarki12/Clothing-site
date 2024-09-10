
<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";
$port = 3307;

$conn = new mysqli($host, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    echo json_encode([
        'success' => false,
        'message' => 'Connection failed: ' . $conn->connect_error
    ]);
    exit(); // Ensure no further code is executed
}

// Get the JSON input data
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'])) {
    $itemId = $data['id'];

    // Prepare the DELETE SQL statement
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ?");
    $stmt->bind_param('i', $itemId); // Bind the item ID

    if ($stmt->execute()) {
        // Return success response
        echo json_encode(['success' => true]);
    } else {
        // Return failure response
        echo json_encode(['success' => false, 'message' => 'Failed to remove item']);
    }
} else {
    // Return failure response if item ID is not provided
    echo json_encode(['success' => false, 'message' => 'Invalid item ID']);
}
?>

