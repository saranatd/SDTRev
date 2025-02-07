<?php
session_start();

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

// Check if form data is sent via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user from the database
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Check if the user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            header("Location: contacts.php"); // Redirect to contacts page
            exit();
        } else {
            echo '<script>
                    alert("Invalid username or password.");
                    window.location.href = "login.html";
                  </script>';
            exit();
        }
    } else {
        echo '<script>
                alert("Invalid username or password.");
                window.location.href = "login.html";
              </script>';
        exit();
    }
}
?>
