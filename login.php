<?php
// Start session to store user login status
session_start();

// Check if the user is already logged in (optional)
if (isset($_SESSION['matric'])) {
    header('Location: display.php'); // Redirect to display.php if already logged in
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'lab_5b', 3307);

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Get user inputs
    $matric = $_POST['matric'];
    $password = $_POST['password'];

    // Query to find the user in the database
    $sql = "SELECT matric, password FROM users WHERE matric = '$matric'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, verify password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, start session and redirect to display.php
            $_SESSION['matric'] = $row['matric'];
            header('Location: display.php');
            exit();
        } else {
            // Password incorrect
            $error = "Invalid username or password, please try again.";
        }
    } else {
        // User not found
        $error = "Invalid username or password, please try again.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css"> <!-- External CSS link -->
</head>
<body>

    <h1>Login</h1>

    <?php if (isset($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <label for="matric">Matric:</label>
        <input type="text" name="matric" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register here</a></p>

</body>
</html>
