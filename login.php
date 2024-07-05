<?php
// login.php

// Include database connection and session management if needed
include_once 'config.php';

// Initialize session
session_start();

// Check if there's an existing alert message
$error_message = isset($_SESSION['alert_message']) ? $_SESSION['alert_message'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if user exists and retrieve status
    $stmt = $conn->prepare("SELECT id, username, name, password, role, status FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $username, $name, $hashed_password, $role, $status);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Check status of the user
            if ($status == 'blocked') {
                // User account is blocked
                $_SESSION['alert_message'] = "Your account is blocked. Please contact the administrator.";
                header("Location: login.php"); // Redirect to login page
                exit();
            } else {
                // User account is active, proceed with login
                $_SESSION['id'] = $user_id;
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role; // Assign role to session variable
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $name;
                // Redirect to dashboard or desired page
                header("Location: index.php");
                exit();
            }
        } else {
            // Invalid password
            $_SESSION['alert_message'] = "Incorrect password. Please try again.";
            header("Location: login.php"); // Redirect to login page
            exit();
        }
    } else {
        // User not found
        $_SESSION['alert_message'] = "User not found.";
        header("Location: login.php"); // Redirect to login page
        exit();
    }

    $stmt->close();
    $conn->close();
}

// Clear the session alert message after displaying it
unset($_SESSION['alert_message']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - File Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Login</h4>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($error_message)) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>
                        <form action="login.php" method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" id="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                        <div class="mt-3">
                            <p>Not registered yet? <a href="register.php">Register here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>