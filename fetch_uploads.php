<?php
// fetch_uploads.php
session_start();

header('Content-Type: application/json');

// Include database connection
include_once 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

// Pagination settings
$page = isset($_GET['uploadPage']) ? (int)$_GET['uploadPage'] : 1;
$pageSize = 6; // Number of rows per page
$offset = ($page - 1) * $pageSize;

// Query to get uploads
$sqlUploads = "SELECT id, filename, upload_date 
               FROM files 
               ORDER BY upload_date DESC 
               LIMIT $pageSize OFFSET $offset";
$resultUploads = $conn->query($sqlUploads);

$files = [];
if ($resultUploads->num_rows > 0) {
    while ($row = $resultUploads->fetch_assoc()) {
        $files[] = $row;
    }
}

// Query to get total number of records for pagination
$sqlTotal = "SELECT COUNT(*) as total FROM files";
$resultTotal = $conn->query($sqlTotal);
$totalRows = $resultTotal->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $pageSize);

$conn->close();

echo json_encode(['files' => $files, 'totalPages' => $totalPages, 'currentPage' => $page]);
?>
