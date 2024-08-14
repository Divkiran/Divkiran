<?php
include 'dbconn.php'; // Ensure this file contains a valid database connection

if (isset($_POST['Signup'])) {
    $firstname = $_POST['first_name'];
    $lastname = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // Validate password and confirm password match
    if ($password !== $cpassword) {
        echo "Passwords do not match.";
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check connection
    if ($connect->connect_error) {
        die("Connection failed: " . $connect->connect_error);
    }

    $query = "INSERT INTO `signup` (`first_name`, `last_name`, `email`, `password`) VALUES (?, ?, ?, ?)";

    if ($stmt = $connect->prepare($query)) {
        $stmt->bind_param("ssss", $firstname, $lastname, $email, $hashedPassword);
        if ($stmt->execute()) {
            echo "Registration successful";
            header("Location: http://localhost/DBTEST/welcome.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
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
    <title>Sign up</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="signup.css">
</head>
<body>
    <div class="container">
        <div class="sign_up">
            <div class="form">
                <h1>Sign Up</h1>
                <form method="post">
                    <input type="text" name="first_name" Placeholder="First Name">
                    <input type="text" name="last_name" Placeholder="Last Name">
                    <input type="email" name="email" Placeholder="Email">
                    <input type="password" name="password" Placeholder="Create Password">
                    <input type="password" name="cpassword" Placeholder="Confirm Password">
                    <button type="submit" name="Signup">Sign up</button>

                </form>
                <a href="http://localhost/DBTEST/login.php">Login</a>
            </div>
            <div class="photo">
                <img src="animate-removebg-preview.png" alt="robotpic" width="550px">
            </div>
        </div>
    </div>
</body>
</html>