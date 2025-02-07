<?php
header('Content-Type: application/json'); // Set the content type to JSON

// Database connection parameters
$servername = "localhost";
$username = "root";  // replace with your MySQL username
$password = "";      // replace with your MySQL password
$dbname = "db_sdt"; // replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit; // Stop further execution
}

// Check if form data is sent via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize inputs
    $firstName = isset($_POST['firstName']) ? trim($_POST['firstName']) : '';
    $lastName = isset($_POST['lastName']) ? trim($_POST['lastName']) : '';
    $companyName = isset($_POST['companyName']) ? trim($_POST['companyName']) : '';
    $phoneNumber = isset($_POST['phoneNumber']) ? trim($_POST['phoneNumber']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $service = isset($_POST['servicesSelect']) ? trim($_POST['servicesSelect']) : '';

    // Validate inputs
    if (empty($firstName) || empty($lastName) || empty($companyName) || empty($phoneNumber) || empty($email) || empty($service)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email format.']);
        exit;
    }

    // Prepare SQL statement to insert form data into the database
    $stmt = $conn->prepare("INSERT INTO contacts (first_name, last_name, company_name, phone_number, email, service) VALUES (?, ?, ?, ?, ?, ?)");
    
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Error preparing statement: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param("ssssss", $firstName, $lastName, $companyName, $phoneNumber, $email, $service);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'New record created successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error executing statement: ' . $stmt->error]);
    }

    // Close statement and connection
    $stmt->close();
}

// Close the connection outside the if block
$conn->close();
?>
