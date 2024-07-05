<?php
class Counts {
    private $conn;

    // Constructor to initialize the database connection
    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Get User Count
    public function getUserCount() {
        $usersCount = 0; // Default value
        try {
            $query = "SELECT COUNT(*) AS user_count FROM users"; // Update 'users' to your actual users table name
            $result = $this->conn->query($query);
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $usersCount = $row['user_count'];
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
        return $usersCount;
    }

    // Get Download Count
    public function getDownloadCount() {
        $downloadCount = 0; // Default value
        try {
            $query = "SELECT COUNT(*) AS download_count FROM downloads"; // Update 'downloads' to your actual downloads table name
            $result = $this->conn->query($query);
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $downloadCount = $row['download_count'];
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
        return $downloadCount;
    }

    // Get Upload Count
    public function getUploadCount() {
        $uploadCount = 0; // Default value
        try {
            $query = "SELECT COUNT(*) AS upload_count FROM files"; // Update 'uploads' to your actual uploads table name
            $result = $this->conn->query($query);
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $uploadCount = $row['upload_count'];
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
        return $uploadCount;
    }
}
?>
