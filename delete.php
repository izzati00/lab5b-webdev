<?php
// Start session to check if the user is logged in
session_start();

// Check if the user is logged in
if (!isset($_SESSION['matric'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'lab_5b', 3307);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Get the matric from the URL parameter
$matric = $_GET['matric'];

// Delete the user from the database
$delete_sql = "DELETE FROM users WHERE matric = '$matric'";

if ($conn->query($delete_sql)) {
    echo "User deleted successfully!";
    header('Location: display.php'); // Redirect to the display page after successful deletion
    exit();
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
