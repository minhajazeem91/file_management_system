<?php
// fetch_activity.php
session_start();

header('Content-Type: application/json');

// Database connection details
include_once 'config.php';

if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
    $username = $_SESSION['username'];
    $name = $_SESSION['name'];
    $role = $_SESSION['role'];
    $email = $_SESSION['email'];
} else {
    // Redirect to login if user is not logged in
    header("Location: login.php");
    exit;
}
// Pagination settings
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$pageSize = 3; // Number of rows per page
$offset = ($page - 1) * $pageSize;

// Date filtering (assuming you pass startDate and endDate)
$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : '';
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : '';

$dateCondition = '';
if (!empty($startDate) && !empty($endDate)) {
    $dateCondition = " AND timestamp BETWEEN '$startDate' AND '$endDate'";
} elseif (!empty($startDate)) {
    $dateCondition = " AND timestamp >= '$startDate'";
} elseif (!empty($endDate)) {
    $dateCondition = " AND timestamp <= '$endDate'";
}

// Query to get activity logs with limit, offset, and date filter
$sql = "SELECT type, username, filename, timestamp FROM activity_logs 
        WHERE 1 $dateCondition
        ORDER BY timestamp DESC 
        LIMIT $pageSize OFFSET $offset";
$result = $conn->query($sql);

$logs = '';
if ($result->num_rows > 0) {
    $logs .= "<div class='activity-log'><ul>"; // Start the unordered list

    while ($row = $result->fetch_assoc()) {
        $logs .= "<li><strong>User:</strong> " . htmlspecialchars($row['username']) . " 
            <strong>Type:</strong> " . htmlspecialchars($row['type']) . " 
            <strong>File:</strong> " . htmlspecialchars($row['filename']) . " 
            <span class='timestamp'>" . htmlspecialchars($row['timestamp']) . "</span>
        </li>";
    }

    $logs .= "</ul></div>"; // End the unordered list
} else {
    $logs = "<p>No activity logs found.</p>";
}


// Query to get total number of records for pagination with date filter
$sqlTotal = "SELECT COUNT(*) as total FROM activity_logs WHERE 1 $dateCondition";
$resultTotal = $conn->query($sqlTotal);
$totalRows = $resultTotal->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $pageSize);

// Generate pagination links
$pagination = "<div class='pagination' id='pagination'>";
$visiblePages = 3; // Number of visible pages in pagination

$startPage = max(1, min($page - 1, $totalPages - $visiblePages + 1)); // Adjusted start page calculation
$endPage = min($totalPages, $startPage + $visiblePages - 1); // End page number

// Show ellipsis before the start pages if needed
if ($startPage > 1) {
    $pagination .= "<a href='#' class='pagination-link' data-page='1'>1</a>";
    if ($startPage > 2) {
        $pagination .= "<span class='pagination-ellipsis'>...</span>";
    }
}

// Display the page numbers within the range
for ($i = $startPage; $i <= $endPage; $i++) {
    $activeClass = ($i == $page) ? 'active' : '';
    $pagination .= "<a href='#' class='pagination-link $activeClass' data-page='$i'>$i</a>";
}

// Show ellipsis after the end pages if needed
if ($endPage < $totalPages) {
    if ($endPage < $totalPages - 1) {
        $pagination .= "<span class='pagination-ellipsis'>...</span>";
    }
    $pagination .= "<a href='#' class='pagination-link' data-page='$totalPages'>$totalPages</a>";
}

$pagination .= "</div><br>";

// Date filtering (assuming you pass startDate and endDate)
$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : '';
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : '';

$dateCondition = '';
if (!empty($startDate) && !empty($endDate)) {
    $dateCondition = " AND timestamp BETWEEN '$startDate' AND '$endDate'";
} elseif (!empty($startDate)) {
    $dateCondition = " AND timestamp >= '$startDate'";
} elseif (!empty($endDate)) {
    $dateCondition = " AND timestamp <= '$endDate'";
}

// Query to get upload and download counts within the date range
$sqlUploads = "SELECT COUNT(*) AS uploadCount FROM activity_logs WHERE type = 'Upload' $dateCondition";
$sqlDownloads = "SELECT COUNT(*) AS downloadCount FROM activity_logs WHERE type = 'Download' $dateCondition";

$resultUploads = $conn->query($sqlUploads);
$resultDownloads = $conn->query($sqlDownloads);

$uploadCount = $resultUploads->fetch_assoc()['uploadCount'];
$downloadCount = $resultDownloads->fetch_assoc()['downloadCount'];

$conn->close();

echo json_encode(['logs' => $logs, 'pagination' => $pagination, 'uploadCount' => $uploadCount, 'downloadCount' => $downloadCount]);
?>
