<?php
// Database connection details
include_once 'config.php';

// Pagination settings
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$pageSize = isset($_GET['pageSize']) ? (int)$_GET['pageSize'] : 8;
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;

// Query to get total number of downloaded files
$sqlTotal = "SELECT COUNT(*) AS total FROM downloads";
$resultTotal = $conn->query($sqlTotal);
$totalFiles = $resultTotal->fetch_assoc()['total'];
$totalPages = ceil($totalFiles / $pageSize);

// Query to get downloaded files details with limit and offset
$sql = "SELECT id, file_name, downloaded_time, user FROM downloads ORDER BY downloaded_time DESC LIMIT $pageSize OFFSET $offset";
$result = $conn->query($sql);

$response = [
    'files' => [],
    'totalPages' => $totalPages,
];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $response['files'][] = [
            'file_name' => $row['file_name'],
            'downloaded_time' => $row['downloaded_time'],
            'user' => $row['user'],
        ];
    }
} else {
    // No files found
    $response['files'] = [];
}

$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
