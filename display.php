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

// Query to select matric, name, and role from the users table
$sql = "SELECT matric, name, role FROM users";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['matric']); ?>!</h1>
    <p><a href="logout.php">Logout</a></p>

    <h2>Users List</h2>
    
    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Matric</th>
                <th>Name</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['matric']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['role']); ?></td>
                    <td>
                        <!-- Update Button -->
                        <a href="update.php?matric=<?php echo urlencode($row['matric']); ?>">Update</a> | 
                        <!-- Delete Button -->
                        <a href="delete.php?matric=<?php echo urlencode($row['matric']); ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No users found.</p>
    <?php endif; ?>

</body>
</html>
