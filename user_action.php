<?php
// user_action.php

// Include database connection and session management if needed
include_once 'config.php';

// Initialize session
session_start();

// Check if user is logged in and retrieve user role
if (!isset($_SESSION['id'])) {
    echo json_encode(['alert_message' => 'User not logged in.']);
    exit;
}

$user_id = $_SESSION['id'];

// Fetch user role from the database
$stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($role);
$stmt->fetch();
$stmt->close();

// Check if user has admin privileges
if ($role !== 'admin') {
    echo json_encode(['alert_message' => 'Access denied. You do not have permission to perform this action.']);
    exit;
}

// Assume POST method is used to handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id']) && isset($_POST['action'])) {
    $user_id = $_POST['user_id'];
    $action = $_POST['action'];

    // Fetch username based on user_id
    $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($username);
    $stmt->fetch();
    $stmt->close();

    if (!$username) {
        echo json_encode(['alert_message' => 'User not found.']);
        exit;
    }

    // Prepare variables for JSON response
    $response = [
        'user_id' => $user_id,
        'status' => '',
        'alert_message' => ''
    ];

    // Determine SQL query and success message based on action
    switch ($action) {
        case 'activate':
            $query = "UPDATE users SET status = 'active' WHERE id = ?";
            $response['status'] = 'active';
            $response['alert_message'] = "User $username activated.";
            break;
        case 'block':
            $query = "UPDATE users SET status = 'blocked' WHERE id = ?";
            $response['status'] = 'blocked';
            $response['alert_message'] = "User $username blocked.";
            break;
        case 'delete':
            $query = "UPDATE users SET status = 'deleted' WHERE id = ?";
            $response['status'] = 'deleted';
            $response['alert_message'] = "User $username deleted.";
            break;
        case 'edit':
            $response['status'] = ''; // Placeholder status
            $response['alert_message'] = "Edit action not implemented for User $user_id."; // Placeholder alert message
            break;
        default:
            $response['alert_message'] = "Invalid action.";
            break;
    }

    // Prepare and execute SQL query
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo json_encode($response); // Send success message back to AJAX
    } else {
        echo json_encode(['alert_message' => 'Error updating user status.']); // Send error message back to AJAX
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['alert_message' => 'Invalid request.']); // Handle cases where POST data is incomplete or action is not valid
}
?>
