<?php
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

// Query to get uploaded files count
$sql = "SELECT COUNT(*) AS total FROM files";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $uploadedFilesCount = $row['total'];
    echo $uploadedFilesCount;
} else {
    echo "0"; // Default to 0 if no files found (optional)
}

$conn->close();
?>
