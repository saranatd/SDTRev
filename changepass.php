<?php
// Database connection parameters
$servername = "localhost";
$username = "root";  // replace with your MySQL username
$password = "";      // replace with your MySQL password
$dbname = "db_sdt"; // replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// New password
$newPassword = 'Standar@123';
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

// Update password for a specific user (e.g., admin)
$sql = "UPDATE users SET password = ? WHERE username = 'admin'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $hashedPassword);

if ($stmt->execute()) {
    echo "Password updated successfully.";
} else {
    echo "Error updating password: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
