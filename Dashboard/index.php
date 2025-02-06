<?php
// Start session
session_start();

include('../config.php');

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}
// Fetch company name from the session
$company_name = $_SESSION['company_name'];

// Fetch the total job postings for the company
$sql = "SELECT COUNT(*) as total_jobs FROM jobs WHERE company_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $company_name);
$stmt->execute();
$stmt->bind_result($total_jobs);
$stmt->fetch();
$stmt->close();


$sql = "SELECT COUNT(*) as total_applications FROM applications WHERE company_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $company_name);
$stmt->execute();
$stmt->bind_result($applications);
$stmt->fetch();
$stmt->close();

$sql = "SELECT COUNT(*) as total_interviews FROM applications WHERE company_name = ? AND Status ='Interview Scheduled'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $company_name);
$stmt->execute();
$stmt->bind_result($interviews);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
     <!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            color: #212529;
        }
        .sidebar {
            background-color: #343a40;
            color: #fff;
            min-height: 100vh;
            padding: 20px;
        }
        .sidebar a {
            color: #ddd;
            text-decoration: none;
        }
        .sidebar a:hover {
            color: #fff;
        }
        .dashboard-header {
            padding: 15px;
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .dashboard-header h2 {
            margin: 0;
            font-size: 1.5rem;
        }
        .custom-card {
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        .custom-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        .custom-card .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }
        .custom-card .card-text {
            font-size: 1.5rem;
        }
        .filter-section {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .applications-table .table {
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .applications-table .table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .applications-table .badge {
            padding: 6px 12px;
            border-radius: 12px;
        }
        .modal-body a{
            color: rgb(62, 110, 181);;
            font-weight: bold;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        body { background-color: #f8f9fa; color: #212529; }
        .sidebar { background-color: #343a40; color: #fff; min-height: 100vh; padding: 20px; }
        .sidebar a { color: #ddd; text-decoration: none; display: block; padding: 10px; }
        .sidebar a:hover { color: #fff; background: #495057; }
        .dashboard-header { padding: 15px; background-color: #fff; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; }
        .custom-card { border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out; }
        .custom-card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2); }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
<!-- Header -->
<header class="col-12 dashboard-header">
    <button
        class="btn btn-primary d-md-none"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#sidebarMenu"
        aria-controls="sidebarMenu"
        aria-expanded="false"
        aria-label="Toggle navigation"
    >
        <i class="fas fa-bars"></i>
    </button>
    <h2><?php echo htmlspecialchars($company_name); ?> Dashboard</h2>
    <!-- Logout Icon -->
    <a href="logout.php" class="btn btn-outline-danger ms-3">
        <i class="fas fa-sign-out-alt"></i>
    </a>
</header>

            <!-- Sidebar -->
            <nav class="col-md-2 collapse show sidebar" id="sidebarMenu">
                <div class="p-3">
                    <h4 class="text-white">Dashboard</h4>
                    <ul class="nav flex-column mt-3">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="Job_Postings">Job Postings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="Settings">Settings</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-10 ms-sm-auto px-md-4" id="main-content">
                <!-- Overview Cards -->
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card bg-primary text-white custom-card">
                            <div class="card-body">
                                <h5 class="card-title">Total Job Postings</h5>
                                <p class="card-text"><?php echo $total_jobs; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white custom-card">
                            <div class="card-body">
                                <h5 class="card-title">Applications Received</h5>
                                <p class="card-text"><?php echo $applications; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-info text-white custom-card">
                            <div class="card-body">
                                <h5 class="card-title">Interview Scheduled</h5>
                                <p class="card-text"><?php echo $interviews; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
               <!-- Filter Section -->
<div class="filter-section mt-4">
    <h4>Filter Applications</h4>
    <form method="GET">
        <div class="row g-3">
            <div class="col-md-6">
                <select class="form-select" name="status_filter">
                    <option value="">Status: All</option>
                    <option value="New" <?= isset($_GET['status_filter']) && $_GET['status_filter'] === 'New' ? 'selected' : '' ?>>New</option>
                    <option value="Reviewed" <?= isset($_GET['status_filter']) && $_GET['status_filter'] === 'Reviewed' ? 'selected' : '' ?>>Reviewed</option>
                    <option value="Rejected" <?= isset($_GET['status_filter']) && $_GET['status_filter'] === 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                    <option value="Interview Scheduled" <?= isset($_GET['status_filter']) && $_GET['status_filter'] === 'Interview Scheduled' ? 'selected' : '' ?>>Interview Scheduled</option>
                </select>
            </div>
            <div class="col-md-6">
                <button class="btn btn-primary w-100" type="submit">Apply Filter</button>
            </div>
        </div>
    </form>
</div>

<!-- Applications Table -->
<div class="applications-table mt-4">
    <h4>Applications</h4>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Applicant Name</th>
                    <th>Job Title</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Base SQL query
                $sql = "SELECT * FROM applications WHERE company_name = '$company_name'";

                // Apply filter based on selected status
                if (isset($_GET['status_filter']) && $_GET['status_filter'] !== '') {
                    $status_filter = $_GET['status_filter'];

                    if ($status_filter === 'New') {
                        $sql .= " AND viewed = 0"; // Unviewed applications
                    } elseif ($status_filter === 'Reviewed') {
                        $sql .= " AND viewed = 1"; // Viewed applications
                    } elseif ($status_filter === 'Rejected'){
                        $sql .= " AND viewed = 2"; //Rejected applications 
                    }elseif ($status_filter === 'Interview Scheduled'){
                        $sql .= " AND viewed = 3"; //Interview Scheduled 
                    }
                }

                // Sort by applied_date (latest first)
                $sql .= " ORDER BY applied_date DESC";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $counter = 1;
                    while ($row = $result->fetch_assoc()) {
                        $applicant_name = htmlspecialchars($row['applicant_name']);
                        $job_title = htmlspecialchars($row['job_title']);
                        $email_id = htmlspecialchars($row['email_id']);
                        $job_experience = htmlspecialchars($row['job_experience']);
                        $resume = htmlspecialchars($row['resume']);
                        $viewed = $row['viewed'];
                        $status = $row['Status'];
                        $application_id = $row['id'];

                        // Determine status dynamically
                        if($viewed==3 && $status=='Interview Scheduled'){
                            $status_text='Interview Scheduled';
                            $badge_class='bg-info';
                        } else if ($viewed==1 && $status=='NA') {
                            $status_text='Reviewed';
                            $badge_class='bg-warning';
                        } else if($viewed==2 && $status=='Rejected'){
                            $status_text='Rejected';
                            $badge_class='bg-danger';
                        }else{
                            $status_text='New'; 
                            $badge_class='bg-primary';     
                        }
                        // $status_text = $viewed ? 'Reviewed' : 'New';
                        // $badge_class = $viewed ? 'bg-warning' : 'bg-primary';

                        echo "<tr>
                                <td>{$counter}</td>
                                <td>{$applicant_name}</td>
                                <td>{$job_title}</td>
                                <td><span class='badge {$badge_class}'>{$status_text}</span></td>
                                <td>
                                    <button class='btn btn-sm btn-outline-secondary' data-bs-toggle='modal' data-bs-target='#viewModal{$application_id}'>View</button>
                                    <button class='btn btn-sm btn-outline-danger' data-bs-toggle='modal' data-bs-target='#continueModal{$application_id}'>Delete</button>
                                </td>
                              </tr>";

                            // Modal for Viewing Application
                        echo "
                        <div class='modal fade' id='viewModal{$application_id}' tabindex='-1' aria-labelledby='viewModalLabel' aria-hidden='true'>
                            <div class='modal-dialog modal-lg'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='viewModalLabel'>Application Details</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <p><strong>Applicant Name:</strong> {$applicant_name}</p>
                                        <p><strong>Email:</strong> {$email_id}</p>
                                        <p><strong>Job Experience:</strong> {$job_experience}</p>
                                        <p><strong>Job Title:</strong> {$job_title}</p>
                                        <p><strong>Resume:</strong> <a href='../uploads/{$resume}' target='_blank'>View Resume</a></p>
                                    </div>
                                    <div class='modal-footer'>
                                        <form method='POST' action='handle_application.php'>
                                            <input type='hidden' name='application_id' value='{$application_id}'>
                                            <button type='submit' name='action' value='review' class='btn btn-warning'>Review</button>
                                            <button type='submit' name='action' value='schedule' class='btn btn-info'>Schedule Interview</button>
                                            <button type='submit' name='action' value='reject' class='btn btn-danger'>Reject</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>";

                        //Model for asking deletion
                        echo "
                        <div class='modal fade' id='continueModal{$application_id}' tabindex='-1' aria-labelledby='viewModalLabel' aria-hidden='true'>
                            <div class='modal-dialog modal-lg'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='continueModalLabel'>Application Details</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <p class='text-center'><strong>Do you want to delete application?</p>
                                    </div>
                                    <div class='modal-footer text-center'>
                                        <form method='POST' action='handle_application.php'>
                                            <input type='hidden' name='application_id' value='{$application_id}'>
                                            <button type='submit' name='action' value='delete' class='btn btn-danger'>Delete</button>
                                            <button type='submit' name='action' value='cancel' class='btn btn-info'>Cancel</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>";
				
                        $counter++;
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No applications found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

            </main>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // When a section is clicked, load content via AJAX
            $('#Job_Postings').click(function() {
                loadContent('Job_Postings');
            });

            $('#Settings').click(function() {
                loadContent('Settings');
            });

            // Function to load content into the main content area
            function loadContent(section) {
                $.ajax({
                    url: 'load_content.php', // PHP file to handle the request
                    method: 'GET',
                    data: { section: section },
                    success: function(response) {
                        $('#main-content').html(response); // Update the content of the main page
                    },
                    error: function() {
                        $('#main-content').html('<p>Error loading content.</p>');
                    }
                });
            }
        });
    </script>
   
<!-- Bootstrap 5 JS (for modal functionality) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
