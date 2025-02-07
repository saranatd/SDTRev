<?php
session_start();
$_SESSION = array(); // Clear session data
session_destroy(); // Destroy the session
header("Location: loginxsdt.html"); // Redirect to login page
exit;
?>