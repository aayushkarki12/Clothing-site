<?php
// Database connection parameters
$host = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";
$port = 3307;

// Create a new connection
$conn = new mysqli($host, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the POST data from the login form
$email = trim($_POST['email']);
$password2 = trim($_POST['password']);

// Prepare and execute a SQL statement to fetch the user data
$stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

// Check if the email exists
if ($stmt->num_rows == 1) {
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    echo"$hashed_password";
    
    // Output the hashed password and input password for debugging
    error_log("Stored hashed password: " . $hashed_password);
    error_log("Entered password: " . $password2);

    // Verify the password
    if (password_verify($password2, $hashed_password)) {
        // Password is correct, redirect to the success page
        header("Location: order_successful.html");
    } else {
        // Password is incorrect, redirect back to login with an error
        header("Location: order_sucessful.html");
    }
} else {
    // Email does not exist, redirect back to login with an error
    header("Location: login.html?error=invalid_email");
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
