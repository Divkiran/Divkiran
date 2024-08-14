<?php
include 'dbconn.php'; // Ensure this file contains a valid database connection

if (isset($_POST['Login'])) {
    $email = trim($_POST['Email']);
    $password = trim($_POST['Password']);

    // Validate email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address";
        exit;
    }

    // Check connection
    if ($connect->connect_error) {
        die("Connection failed: " . $connect->connect_error);
    }

    // Check if email exists
    $query = "SELECT * FROM signup WHERE email = ?";
    if ($stmt = $connect->prepare($query)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            echo "Email does not exist";
            exit;
        }

        // Fetch the user data
        $user_data = $result->fetch_assoc();

        // Verify the password
        if (!password_verify($password, $user_data['password'])) {
            echo "Password is incorrect";
            exit;
        }

        // Login successful, start the session
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['email'] = $email;
        $_SESSION['first_name'] = $user_data['first_name']; // Make sure column names match your database
        $_SESSION['last_name'] = $user_data['last_name']; // Make sure column names match your database
        header("Location: http://localhost/DBTEST/welcome.php");
        exit;
    } else {
        echo "Error: " . $connect->error;
    }

    $connect->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>
    <div class="container">
        <div class="sign_up">
            <div class="form1">
                <h1>Login</h1>
                <form method="post">
                    <input type="email" name="Email" placeholder="Email" required>
                    <input type="password" name="Password" placeholder="Password" required>
                    <button type="submit" name="Login">Login</button>
                </form>
                <a href="http://localhost/DBTEST/signup.php">Sign up</a>
            </div>
            <div class="photo">
                <img src="animate-removebg-preview.png" alt="robotpic" width="550px">
            </div>
        </div>
    </div>
</body>
</html>
