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

// Pagination settings
$pageSize = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $pageSize;

// Fetch files with pagination
$sql = "SELECT * FROM files LIMIT $start, $pageSize";
$result = $conn->query($sql);

$files = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $files[] = $row;
    }
}

// Return files as JSON
header('Content-Type: application/json');
echo json_encode($files);

$conn->close();
?>
