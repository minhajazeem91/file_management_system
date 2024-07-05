<?php
session_start();
include_once 'config.php'; // Include database connection
include_once 'fetch_files.php';
include_once 'Counts.php'; // Include Counts class

// Check if user is logged in
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

// Create Counts object
$counts = new Counts($conn);

$userCount = $counts->getUserCount();
$downloadCount = $counts->getDownloadCount();
$uploadCount = $counts->getUploadCount();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once  'head.php'; ?>
</head>

<body>
    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#dashboard">File Management System</a>
            <div class="collapse navbar-collapse">
                <div class="ms-auto"> <!-- ms-auto to push content to the right -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <span class="navbar-text me-1">
                                Welcome, <?php echo $username; ?>
                            </span>
                        </li>
                        <li class="nav-item">
                            <form class="d-flex" action="logout.php">
                                <button class="btn btn-outline-danger" type="submit" style="padding-top: 0.25rem; padding-bottom: 0.25rem; font-size: 0.875rem;">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </nav>
    <!-- Left Sidebar -->
    <div id="content" class="flex h-screen">
        <div class="bg-blue-200 w-64 p-4">
            <!-- <a href="#dashboard" class="text-2xl font-semibold mb-4 block">File Management System</a> -->
            <ul id="sidebar" class="space-y-2">
                <li><a href="#dashboard" class="nav-link block p-2 rounded hover:bg-blue-400"><i class="fas fa-home" style="margin-right: 8px;"></i><strong>Dashboard</strong></a></li>
                <li><a href="#files" class="nav-link block p-2 rounded hover:bg-blue-300"><i class="fas fa-file" style="margin-right: 8px;"></i>Files</a></li>
                <li><a href="#activity" class="nav-link block p-2 rounded hover:bg-blue-300"><i class="fas fa-history" style="margin-right: 8px;"></i>Activity</a></li>
                <?php if ($_SESSION['role'] == 'admin') : ?>
                    <li><a href="#users" class="nav-link block p-2 rounded hover:bg-blue-300"><i class="fas fa-users" style="margin-right: 8px;"></i>Users</a></li>
                <?php endif; ?>
                <li><a href="#settings" class="nav-link block p-2 rounded hover:bg-blue-300"><i class="fas fa-cog" style="margin-right: 8px;"></i>Settings</a></li>
            </ul>
        </div>
        <!-- Page Content -->
        <div class="p-6 w-full">
            <!-- Dashboard Section -->
            <div id="dashboard" class="section">
                <div class="card shadow-md mb-4">
                    <div class="card-body">
                        <h2 class="text-xl font-semibold mb-4">Dashboard</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            <div class="p-4 bg-white rounded-lg shadow-md">
                                <h3 class="text-lg font-semibold">Uploaded Files</h3>
                                <p id="uploadcount" class="count-display" onclick="UploadFileGrid()">
                                    <?php echo htmlspecialchars($uploadCount); ?>
                                </p>
                            </div>
                            <div class="p-4 bg-white rounded-lg shadow-md">
                                <h3 class="text-lg font-semibold">Downloaded Files</h3>
                                <p id="downloadCount" class="count-display" onclick="showDownloadedFilesGrid()">
                                    <?php echo htmlspecialchars($downloadCount); ?>
                                </p>
                            </div>
                            <?php if ($_SESSION['role'] == 'admin') : ?>
                                <div class="p-4 bg-white rounded-lg shadow-md">
                                    <h3 class="text-lg font-semibold">Users</h3>
                                    <p class="count-display" onclick="showFileGrid(8)">
                                        <?php echo htmlspecialchars($userCount); ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Upload grid -->
                        <!-- <div id="fileGrid" class="file-details-grid hidden">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr>
                                        <th>S No</th>
                                        <th>File Name</th>
                                        <th>Uploaded Date</th>
                                    </tr>
                                </thead>
                                <tbody id="fileGridBody">
                                    <?php
                                    if ($uploadResult->num_rows > 0) {
                                        $sNo = $uploadOffset + 1;
                                        while ($row = $uploadResult->fetch_assoc()) {
                                            echo "<tr>
                                                <td>{$sNo}</td>
                                                <td>{$row['filename']}</td>
                                                <td>{$row['upload_date']}</td>
                                            </tr>";
                                            $sNo++;
                                        }
                                    } else {
                                        echo "<tr><td colspan='3' class='text-center'>No files found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <div class="upload-pagination">
                                <?php
                                if ($totalUploadPages > 1) {
                                    for ($i = 1; $i <= $totalUploadPages; $i++) {
                                        $activeClass = ($i == $currentUploadPage) ? 'active' : '';
                                        echo "<a href='?uploadPage=$i' class='pagination-link $activeClass'>$i</a>";
                                    }
                                }
                                ?>
                            </div>
                        </div> -->
                        <div id="fileGrid" class="file-details-grid hidden">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr>
                                        <th>S No</th>
                                        <th>File Name</th>
                                        <th>Uploaded Date</th>
                                    </tr>
                                </thead>
                                <tbody id="fileGridBody">
                                    <!-- Data will be populated by JavaScript -->
                                </tbody>
                            </table>
                            <div class="upload-pagination">
                                <!-- Pagination links will be populated by JavaScript -->
                            </div>
                        </div>

                        <!-- Download grid -->
                        <div id="downloadedFilesGrid" class="file-details-grid hidden mt-4">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr>
                                        <th>S No</th>
                                        <th>File Name</th>
                                        <th>Downloaded Time</th>
                                        <th>User</th>
                                    </tr>
                                </thead>
                                <tbody id="downloadedFilesGridBody">
                                    <?php
                                    if ($downloadResult->num_rows > 0) {
                                        $sNo = $downloadOffset + 1;
                                        while ($row = $downloadResult->fetch_assoc()) {
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
                                    ?>
                                </tbody>
                            </table>
                            <div class="download-pagination">
                                <?php
                                if ($totalDownloadPages > 1) {
                                    for ($i = 1; $i <= $totalDownloadPages; $i++) {
                                        $activeClass = ($i == $currentDownloadPage) ? 'active' : '';
                                        echo "<a href='?downloadPage=$i' class='pagination-link $activeClass'>$i</a>";
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Files Section -->
            <div id="files" class="section hidden">
                <div class="card shadow-md mb-4">
                    <div class="card-body">
                        <!-- <h2 class="text-xl font-semibold mb-4"></h2> -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 bg-white rounded-lg shadow-md">
                                <h3 class="text-lg font-semibold">Upload File</h3>
                                <form id="uploadForm" action="upload.php" method="post" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="fileToUpload" class="form-label">Select file to upload:</label>
                                        <input type="file" class="form-control" id="fileToUpload" name="fileToUpload">
                                        <small class="form-text text-muted">Accepted formats: JPEG, JPG, PNG, XLS, CSV</small>
                                    </div>
                                    <button type="button" onclick="uploadFile()" class="btn btn-primary">Upload File</button>
                                </form>
                                <div id="uploadMessage"></div>
                            </div>
                            <!-- Download Section -->
                            <div class="p-4 bg-white rounded-lg shadow-md">
                                <h3 class="text-lg font-semibold">Download File</h3>
                                <form id="downloadForm" action="download.php" method="get">
                                    <div class="mb-3">
                                        <label for="fileToDownload" class="form-label">Select file to download:</label><br>
                                        <select class="form-select select2" id="fileToDownload" name="file" style="width: 100%;">
                                            <option value="">Please Select</option>
                                            <?php
                                            // List all files in uploads directory for download selection
                                            $files = glob('files/uploads/*');
                                            foreach ($files as $file) {
                                                $filename = basename($file);
                                                echo "<option value='$filename'>$filename</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <button type="button" onclick="downloadFile()" class="btn btn-primary">Download File</button>
                                    <p id="downloadMessage" style="margin-top: 10px;"></p> <!-- Removed default color -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Section -->
            <div id="activity" class="section hidden">
                <div class="card shadow-md mb-4">
                    <div class="card-body">
                        <h2 class="text-xl font-semibold mb-4">Activity</h2>
                        <div id="activityContent">
                        </div>
                        <div id="pagination">
                        </div>
                        <div class="container">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="startDate">Start Date:</label>
                                    <input type="date" id="startDate" value="2024-01-01">
                                </div>
                                <div class="form-group">
                                    <label for="endDate">End Date:</label>
                                    <input type="date" id="endDate" value="2024-06-30">
                                </div>
                                <button class="generate-button" onclick="fetchAndRender()">Generate Graph</button>
                            </div>
                            <canvas id="activityChart" width="200" height="52"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users Section -->
            <div id="users" class="section">
                <div class="card shadow-md mb-4">
                    <div class="card-body">
                        <h2 class="text-xl font-semibold mb-4">Users</h2>
                        <!-- Users content -->
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Include database connection
                                    include_once 'config.php';

                                    // Fetch logged-in user's details
                                    $user_id = $_SESSION['id'];
                                    $query = "SELECT id, username, name, email, role, status FROM users WHERE id = $user_id";
                                    $result = $conn->query($query);

                                    if ($result && $result->num_rows > 0) {
                                        $user = $result->fetch_assoc();
                                        $role = $user['role'];
                                        $username = $user['username'];
                                        $name = $user['name'];
                                        $email = $user['email'];
                                        $status = $user['status'];
                                    } else {
                                        echo "<tr><td colspan='5' class='text-center'>No users found.</td></tr>";
                                        exit();
                                    }

                                    // Fetch users based on logged-in user's role
                                    if ($role == 'admin') {
                                        $query = "SELECT * FROM users";
                                        $result = $conn->query($query);
                                    } else {
                                        $query = "SELECT * FROM users WHERE id = $user_id";
                                        $result = $conn->query($query);
                                    }

                                    if ($result && $result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $id = $row['id'];
                                            $name = $row['name'];
                                            $email = $row['email'];
                                            $role = $row['role'];
                                            $status = $row['status']; // Assuming 'status' indicates active or blocked

                                            // Determine action based on status
                                            $action = ($status == 'active') ? 'Active' : 'Blocked';

                                            // Determine actions based on user role
                                            if ($role == 'admin') {
                                                $actions_html = "<option value='activate'>Activate</option>
                                                    <option value='block'>Block</option>
                                                    <option value='delete'>Delete</option>
                                                    <option value='edit'>Edit</option>";
                                            } else {
                                                $actions_html = "<option value='edit'>Edit</option>";
                                            }

                                            // Display each user row with corresponding action buttons
                                            echo "<tr id='user-row-$id'>
                                        <td>$name</td>
                                        <td>$email</td>
                                        <td>$role</td>
                                        <td id='user-status-$id'>$status</td>
                                        <td>
                                            <select name='action' class='form-select user-action-select' data-user-id='$id'>
                                                <option value='' selected disabled>Select Action</option>
                                                $actions_html
                                            </select>
                                        </td>
                                    </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5' class='text-center'>No users found.</td></tr>";
                                    }

                                    // $conn->close();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Section -->
            <?php
            $query = "SELECT name, username, email, role, status FROM users WHERE id = $user_id";
            $result = $conn->query($query);
            if ($result && $result->num_rows > 0) {
                $user = $result->fetch_assoc();
                $username = htmlspecialchars($user['username']);
                $name = htmlspecialchars($user['name']);
                $email = htmlspecialchars($user['email']);
                $role = htmlspecialchars($user['role']);
                $status = htmlspecialchars($user['status']);
            } else {
                // Handle case where user is not found
                $username = $name = $email = $role = $status = '';
            }
            ?>

            <div id="settings" class="section active">
                <div class="card shadow-md mb-4">
                    <div class="card-body">
                        <h2 class="text-xl font-semibold mb-4">Settings</h2>
                        <div id="alert_message">
                            <!-- Alert messages will be dynamically inserted here -->
                        </div>
                        <form id="updateForm" action="settings.php" method="post">
                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" id="username" name="username" class="form-control" value="<?php echo $username; ?>" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" id="name" name="name" class="form-control" value="<?php echo $name; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" id="email" name="email" class="form-control" value="<?php echo $email; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="role" class="form-label">Role</label>
                                        <input type="text" id="role" name="role" class="form-control" value="<?php echo $role; ?>" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <input type="text" id="status" name="status" class="form-control" value="<?php echo $status; ?>" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">New Password</label>
                                        <input type="password" id="new_password" name="new_password" class="form-control" minlength="8">
                                    </div>
                                </div>
                            </div>

                            <button id="updateBtn" type="button" class="btn btn-primary mt-3">Update</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Footer Section -->
            <footer class="footer mt-auto py-3 bg-light">
                <div class="container text-center">
                    <span>&copy; <span id="currentYear"></span> Powered & Developed by Minhaj Azeem.</span>
                </div>
            </footer>


        </div>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.user-action-select').change(function() {
                var userId = $(this).data('user-id');
                var action = $(this).val();

                // Perform AJAX request without confirmation
                if (action === 'activate' || action === 'block' || action === 'delete' || action === 'edit') {
                    $.ajax({
                        url: 'user_action.php',
                        type: 'POST',
                        data: {
                            user_id: userId,
                            action: action
                        },
                        dataType: 'json',
                        success: function(response) {
                            // Update status cell silently
                            $('#user-status-' + userId).text(response.status);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                            alert('Error updating user status.');
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#updateBtn').click(function() {
                var formData = $('#updateForm').serialize();
                $.ajax({
                    type: 'POST',
                    url: 'settings.php',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#alert_message').html('<div class="alert alert-success alert-dismissible fade show" role="alert">' + response.message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                        } else {
                            $('#alert_message').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">' + response.message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                        }
                        // Automatically hide alert after 5 seconds
                        setTimeout(function() {
                            $('.alert').alert('close');
                        }, 5000);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        $('#alert_message').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">Error: ' + xhr.responseText + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    }
                });
            });
        });
    </script>
    <script>
        // JavaScript to update the footer year dynamically
        document.addEventListener("DOMContentLoaded", function() {
            const currentYear = new Date().getFullYear();
            document.getElementById("currentYear").textContent = currentYear;
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
$(document).ready(function() {
    // Function to fetch and display uploads
    function fetchUploads(page = 1) {
        $.ajax({
            url: 'fetch_uploads.php',
            type: 'GET',
            data: { uploadPage: page },
            success: function(response) {
                // Clear the current table body
                $('#fileGridBody').empty();
                if (response.files && response.files.length > 0) {
                    response.files.forEach((file, index) => {
                        $('#fileGridBody').append(`
                            <tr>
                                <td>${(page - 1) * 6 + index + 1}</td>
                                <td>${file.filename}</td>
                                <td>${file.upload_date}</td>
                            </tr>
                        `);
                    });
                } else {
                    $('#fileGridBody').append(`<tr><td colspan='3' class='text-center'>No files found</td></tr>`);
                }

                // Update pagination
                $('.upload-pagination').empty();
                if (response.totalPages > 1) {
                    const totalPages = response.totalPages;
                    const currentPage = response.currentPage;

                    // Always show page 1
                    $('.upload-pagination').append(`<a href='#' class='pagination-link ${currentPage === 1 ? 'active' : ''}' data-page='1'>1</a>`);

                    // Show page 2 if there are more than 1 pages
                    if (totalPages > 1) {
                        $('.upload-pagination').append(`<a href='#' class='pagination-link ${currentPage === 2 ? 'active' : ''}' data-page='2'>2</a>`);
                    }

                    // Show page 3 if there are more than 2 pages
                    if (totalPages > 2) {
                        $('.upload-pagination').append(`<a href='#' class='pagination-link ${currentPage === 3 ? 'active' : ''}' data-page='3'>3</a>`);
                    }

                    // Handle middle pages and ellipsis
                    if (totalPages > 3) {
                        if (currentPage >= 3 && currentPage < totalPages - 1) {
                            $('.upload-pagination').append(`<a href='#' class='pagination-link ${currentPage === 4 ? 'active' : ''}' data-page='4'>4</a>`);
                        }

                        if (currentPage < totalPages - 1 && totalPages > 4) {
                            $('.upload-pagination').append(`<span class='pagination-ellipsis'>...</span>`);
                        }

                        // Show the last page
                        $('.upload-pagination').append(`<a href='#' class='pagination-link ${currentPage === totalPages ? 'active' : ''}' data-page='${totalPages}'>${totalPages}</a>`);
                    }
                }
            },
            error: function(error) {
                console.log('Error fetching uploads:', error);
            }
        });
    }

    // Initial fetch
    fetchUploads();

    // Handle pagination link click
    $(document).on('click', '.pagination-link', function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        fetchUploads(page);
    });
});
</script>





</body>

</html>