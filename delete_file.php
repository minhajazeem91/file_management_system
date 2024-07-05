<?php
// delete_file.php

// Ensure the request is a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the JSON data
    $data = json_decode(file_get_contents('php://input'), true);

    // Get the file name
    $fileName = $data['file'];

    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "file_management_system";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Delete the file record from the database
    $stmt = $conn->prepare("DELETE FROM files WHERE filename = ?");
    $stmt->bind_param("s", $fileName);
    $stmt->execute();
    $stmt->close();

    // Close the database connection
    $conn->close();

    // Delete the actual file from the server
    $filePath = 'files/uploads/' . $fileName;
    if (file_exists($filePath)) {
        unlink($filePath);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'File not found']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>
