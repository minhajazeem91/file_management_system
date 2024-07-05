<?php
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

// // Handle file upload
// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileToUpload"])) {
//     $file = $_FILES["fileToUpload"];
//     $filename = $file["name"];
//     $tempFilePath = $file["tmp_name"];

//     // Define upload directory
//     $uploadDirectory = "files/uploads/";

//     // Move uploaded file to the upload directory
//     $targetFilePath = $uploadDirectory . $filename;
//     if (move_uploaded_file($tempFilePath, $targetFilePath)) {
//         // Insert file details into database
//         $sql = "INSERT INTO files (filename, filepath, upload_date) VALUES (?, ?, NOW())";
//         $stmt = $conn->prepare($sql);
//         $stmt->bind_param("ss", $filename, $targetFilePath);
        
//         if ($stmt->execute()) {
//             echo "File uploaded successfully.";
//         } else {
//             echo "Error uploading file: " . $stmt->error;
//         }
//     } else {
//         echo "Error moving uploaded file.";
//     }
// }

// $conn->close();
?>

<?php
// upload.php

session_start();
include_once 'config.php';

// Replace this with your actual user identification logic
$user = isset($_SESSION['username']) ? $_SESSION['username'] : 'guest'; // Use 'guest' as default if user info is not available

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fileToUpload'])) {
    $file = $_FILES["fileToUpload"];
    $filename = $file["name"];
    $tempFilePath = $file["tmp_name"];

    // Define upload directory
    $uploadDirectory = "files/uploads/";

    // Move uploaded file to the upload directory
    $targetFilePath = $uploadDirectory . $filename;

    // Check if file is selected and uploaded successfully
    // if ($file['error'] === UPLOAD_ERR_OK) {
    //     $filePath = $uploadDir . $fileName;

        // Move uploaded file to uploads directory
        if (move_uploaded_file($tempFilePath, $targetFilePath)) {

            // Insert upload record into uploads table
            $sqlUpload = "INSERT INTO files (filename, filepath, upload_date) 
                          VALUES ('$filename', '$targetFilePath', NOW())";
            if ($conn->query($sqlUpload) === TRUE) {
                $uploadId = $conn->insert_id; // Get the last inserted ID if needed

                // Fetch user_id from users table
                $sqlSelectUser = "SELECT id FROM users WHERE username = '$user'";
                $resultSelectUser = $conn->query($sqlSelectUser);

                if ($resultSelectUser->num_rows > 0) {
                    $row = $resultSelectUser->fetch_assoc();
                    $user_id = $row['id'];

                    // Insert activity log into activity_logs table
                    $activityType = 'Upload'; // Activity type (can be 'Upload' or 'Download')
                    $sqlActivity = "INSERT INTO activity_logs (type, user_id, username, filename, timestamp) 
                                    VALUES ('$activityType', '$user_id', '$user', '$filename', NOW())";
                    if ($conn->query($sqlActivity) === TRUE) {
                        echo "File uploaded successfully.";

                        // Close database connection
                        $conn->close();
                        exit;
                    } else {
                        echo "Error inserting activity log: " . $conn->error;
                    }
                } else {
                    echo "User not found.";
                }
            } else {
                echo "Error inserting upload record: " . $conn->error;
            }

            // Close database connection
            $conn->close();
        } else {
            echo "Error moving uploaded file.";
        }
    // } else {
    //     echo "Error uploading file.";
    // }
} else {
    echo "No file uploaded or invalid request.";
}
?>
