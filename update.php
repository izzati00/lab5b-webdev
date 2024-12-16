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

// Fetch the user's current details
$sql = "SELECT matric, name, role FROM users WHERE matric = '$matric'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $role = $row['role'];
} else {
    die('User not found.');
}

// Handle form submission for updating
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $role = $_POST['role'];

    $update_sql = "UPDATE users SET name = '$name', role = '$role' WHERE matric = '$matric'";

    if ($conn->query($update_sql)) {
        echo "User updated successfully!";
        header('Location: display.php'); // Redirect to the display page after successful update
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Update User</h1>

    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required><br><br>

        <label for="role">Role:</label>
        <select name="role" required>
            <option value="Student" <?php if ($role == 'Student') echo 'selected'; ?>>Student</option>
            <option value="Lecturer" <?php if ($role == 'Lecturer') echo 'selected'; ?>>Lecturer</option>
        </select><br><br>

        <button type="submit">Update</button>
    </form>

</body>
</html>
