<?php
// download.php

session_start();
include_once 'config.php';

// Replace this with your actual user identification logic
$user = isset($_SESSION['username']) ? $_SESSION['username'] : 'guest'; // Use 'guest' as default if user info is not available

if (isset($_GET['file'])) {
    $file = basename($_GET['file']);
    $filePath = 'files/uploads/' . $file;
    $downloadFolder = 'files/downloads/'; // Directory where downloaded files will be saved

    if (file_exists($filePath)) {
        // Function to insert download record and activity log
        function insertDownloadAndActivityLog($conn, $file, $user) {
            
            // Insert download record into downloads table
            $sqlDownload = "INSERT INTO downloads (file_name, downloaded_time, user) 
                            VALUES ('$file', NOW(), '$user')";
            if ($conn->query($sqlDownload) === TRUE) {
                $downloadId = $conn->insert_id; // Get the last inserted ID if needed

                // Fetch user_id from users table
                $sqlSelectUser = "SELECT id FROM users WHERE username = '$user'";
                $resultSelectUser = $conn->query($sqlSelectUser);

                if ($resultSelectUser->num_rows > 0) {
                    $row = $resultSelectUser->fetch_assoc();
                    $user_id = $row['id'];

                    // Insert activity log into activity_logs table
                    $activityType = 'Download'; // Activity type (can be 'Upload' or 'Download')
                    $sqlActivity = "INSERT INTO activity_logs (type, user_id, username, filename, timestamp) 
                                    VALUES ('$activityType', '$user_id', '$user', '$file', NOW())";
                    if ($conn->query($sqlActivity) === TRUE) {
                        return true;
                    } else {
                        echo "Error inserting activity log: " . $conn->error;
                        return false;
                    }
                } else {
                    echo "User not found.";
                    return false;
                }
            } else {
                echo "Error inserting download record: " . $conn->error;
                return false;
            }
        }

        // Insert download record and activity log
        if (insertDownloadAndActivityLog($conn, $file, $user)) {
            // Download the file
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . $file);
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);

            // Save a copy of the downloaded file into downloads folder
            $downloadedFilePath = $downloadFolder . $file;
            copy($filePath, $downloadedFilePath);

            exit;
        } else {
            echo "Failed to insert download record or activity log.";
        }
    } else {
        echo "File not found.";
    }
} else {
    echo "No file specified.";
}

// Close database connection
$conn->close();
?>
