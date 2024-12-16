<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli('localhost', 'root', '', 'lab_5b', 3307);

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $role = $_POST['role'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (matric, name, role, password) VALUES ('$matric', '$name', '$role', '$password')";
    if ($conn->query($sql)) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form method="POST" action="register.php">
        <label for="matric">Matric:</label>
        <input type="text" name="matric" required><br><br>
        
        <label for="name">Name:</label>
        <input type="text" name="name" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>
        
        <label for="role">Role:</label>
        <select name="role" required>
            <option value="" disabled selected>Please select</option>
            <option value="Student">Student</option>
            <option value="Lecturer">Lecturer</option>
        </select><br><br>
       
        <button type="submit">Register</button>
    </form>
</body>
</html>