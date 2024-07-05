<?php
// Database connection details
include_once 'config.php';

// Pagination settings
$pageSize = 6; // Number of files per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page); // Ensure the page is at least 1
$offset = ($page - 1) * $pageSize;

// Query to fetch uploaded files with limit and offset
$sql = "SELECT id, filename, upload_date FROM files ORDER BY upload_date DESC LIMIT $pageSize OFFSET $offset";
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
                <td>{$row['filename']}</td>
                <td>{$row['upload_date']}</td>
            </tr>";
        $sNo++;
    }
} else {
    echo "<tr><td colspan='3' class='text-center'>No files found.</td></tr>";
}

$conn->close();
?>
