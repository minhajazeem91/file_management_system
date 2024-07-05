<?php
// Database connection details
include_once 'config.php';

// Pagination settings
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$pageSize = 8; // Number of rows per page
$page = max(1, $page); // Ensure the page is at least 1
$offset = ($page - 1) * $pageSize;

// Query to get downloaded files details with limit and offset
$sql = "SELECT id, file_name, downloaded_time, user FROM downloads ORDER BY downloaded_time DESC LIMIT $pageSize OFFSET $offset";
$result = $conn->query($sql);

if (!$result) {
    echo "Error: " . $conn->error;
    exit;
}

if ($result->num_rows > 0) {
    $sNo = $offset + 1; // Adjust serial number according to the current page
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$sNo}</td>
                <td>{$row['file_name']}</td>
                <td>{$row['downloaded_time']}</td>
                <td>{$row['user']}</td>
            </tr>";
        $sNo++;
    }
} else {
    echo "<tr><td colspan='4' class='text-center'>No downloads found.</td></tr>";
}

$conn->close();
?>
