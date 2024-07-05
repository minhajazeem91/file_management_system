<?php
// fetch_files.php

// Database connection details
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "file_management_system";

// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// // Query to get files data
// $sql = "SELECT id, filename, upload_date FROM files ORDER BY upload_date DESC";
// $result = $conn->query($sql);

// $files = array();
// if ($result->num_rows > 0) {
//     while ($row = $result->fetch_assoc()) {
//         $files[] = $row;
//     }
// }

// $conn->close();

// // Output the files array as JSON
// header('Content-Type: application/json');
// echo json_encode($files);

include_once 'config.php';

                        // Function to fetch files from database
                        function fetchFiles($page, $pageSize)
                        {
                            global $conn;
                            $offset = ($page - 1) * $pageSize;
                            $sql = "SELECT * FROM files LIMIT $offset, $pageSize";
                            $result = $conn->query($sql);
                            $files = [];
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $files[] = $row;
                                }
                            }
                            return $files;
                        }

                        // Fetching first page initially
                        $page = 1;
                        $pageSize = 6;
                        $files = fetchFiles($page, $pageSize);

                        // Calculate total pages
                        $totalFilesCount = mysqli_num_rows($conn->query("SELECT id FROM files"));
                        $totalUploadPages = ceil($totalFilesCount / $pageSize);

                        // Pagination settings for the upload grid
                        $uploadPageSize = 8;
                        $currentUploadPage = isset($_GET['uploadPage']) ? max(1, intval($_GET['uploadPage'])) : 1; // Ensure page is at least 1
                        $uploadOffset = ($currentUploadPage - 1) * $uploadPageSize;
                        if ($uploadOffset < 0) $uploadOffset = 0; // Ensure offset is not negative

                        // Query to get total number of files for upload pagination
                        $totalUploadFilesQuery = "SELECT COUNT(*) AS total FROM files";
                        $totalUploadFilesResult = $conn->query($totalUploadFilesQuery);
                        $totalUploadFilesRow = $totalUploadFilesResult->fetch_assoc();
                        $totalUploadFiles = $totalUploadFilesRow['total'];
                        $totalUploadPages = ceil($totalUploadFiles / $uploadPageSize);

                        // Query to get files with upload pagination
                        $uploadQuery = "SELECT filename, upload_date FROM files ORDER BY upload_date DESC LIMIT $uploadPageSize OFFSET $uploadOffset";
                        $uploadResult = $conn->query($uploadQuery);

                        // Pagination settings for the download grid
                        $downloadPageSize = 8;
                        $currentDownloadPage = isset($_GET['downloadPage']) ? max(1, intval($_GET['downloadPage'])) : 1; // Ensure page is at least 1
                        $downloadOffset = ($currentDownloadPage - 1) * $downloadPageSize;
                        if ($downloadOffset < 0) $downloadOffset = 0; // Ensure offset is not negative

                        // Query to get total number of downloaded files for download pagination
                        $totalDownloadFilesQuery = "SELECT COUNT(*) AS total FROM downloads";
                        $totalDownloadFilesResult = $conn->query($totalDownloadFilesQuery);
                        $totalDownloadFilesRow = $totalDownloadFilesResult->fetch_assoc();
                        $totalDownloadFiles = $totalDownloadFilesRow['total'];
                        $totalDownloadPages = ceil($totalDownloadFiles / $downloadPageSize);

                        // Query to get downloaded files with download pagination
                        $downloadQuery = "SELECT id, file_name, downloaded_time, user FROM downloads ORDER BY downloaded_time DESC LIMIT $downloadPageSize OFFSET $downloadOffset";
                        $downloadResult = $conn->query($downloadQuery);
?>
