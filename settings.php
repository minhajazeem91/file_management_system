<?php
// settings.php

// Include database connection and session management
include_once 'config.php';

// Initialize session
session_start();

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Fetch logged-in user details securely
$user_id = $_SESSION['id'];
$query = $conn->prepare("SELECT id, username, name, email, role, status FROM users WHERE id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $username = $user['username'];
    $name = $user['name'];
    $email = $user['email'];
    $role = $user['role'];
    $status = $user['status'];
} else {
    $_SESSION['alert_message'] = "User not found.";
    header("Location: login.php");
    exit();
}

// Check if user is admin to determine permissions
if ($role !== 'admin') {
    $_SESSION['alert_message'] = "Access denied. You do not have permission to access this page.";
    header("Location: index.php"); // Redirect to home or appropriate page
    exit();
}

// Handle form submission for updating user details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure all required fields are present and valid
    if (isset($_POST['name'], $_POST['email'])) {
        // Sanitize input values
        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);

        // Optional: Handle role and status updates for admins
        if (isset($_POST['role'], $_POST['status'])) {
            $role = $conn->real_escape_string($_POST['role']);
            $status = $conn->real_escape_string($_POST['status']);
            $update_query = $conn->prepare("UPDATE users SET name = ?, email = ?, role = ?, status = ? WHERE id = ?");
            $update_query->bind_param("sssii", $name, $email, $role, $status, $user_id);
        } else {
            $update_query = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
            $update_query->bind_param("ssi", $name, $email, $user_id);
        }

        if ($update_query->execute()) {
            $_SESSION['alert_message'] = "User details updated successfully.";
            $response = [
                'success' => true,
                'message' => "User details updated successfully."
            ];
            echo json_encode($response);
            exit();
        } else {
            $_SESSION['alert_message'] = "Error updating user details: " . $conn->error;
            $response = [
                'success' => false,
                'message' => "Error updating user details: " . $conn->error
            ];
            echo json_encode($response);
            exit();
        }
    } else {
        $_SESSION['alert_message'] = "Missing required fields.";
        $response = [
            'success' => false,
            'message' => "Missing required fields."
        ];
        echo json_encode($response);
        exit();
    }
}

// Close database connection
$conn->close();
?>
