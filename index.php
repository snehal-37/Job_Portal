<?php
session_start();

// Check if either company_name or full_name is available
$user_name = isset($_SESSION['company_name']) ? $_SESSION['company_name'] : 
            (isset($_SESSION['full_name']) ? $_SESSION['full_name'] : null);
$company_name = isset($_SESSION['company_name']) ? $_SESSION['company_name'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JBoard</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha384-oWrsaq8VDZLvTroj5fL2T92+EnfUq1Ed0xOY8BQKqkZIK7Wa+GQ94P7Lf0A/QKP5" crossorigin="anonymous"></script>
    <!-- Include Quill script -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body{
            background-color:rgb(203, 213, 227);
        }
         .navbar {
            background: linear-gradient(90deg, rgb(50, 102, 181), rgb(62, 110, 181));
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand {
            font-size: 1.8rem;
            font-weight: bold;
            color: #fff;
        }
        .navbar-brand:hover {
            color: #ffc107;
        }
        .nav-link {
            font-size: 1.1rem;
            color: #fff;
            transition: color 0.3s ease;
        }
        .nav-link:hover {
            color: #ffc107;
        }
        .navbar-toggler {
            border: none;
        }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3E%3Cpath stroke='rgba%288, 8, 8, 0.9%29' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
        }
        .nav-item {
            margin: 0 10px;
        }
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.8) !important;
        }
         /* Hero Section Styling */
         .hero-section {
            background: linear-gradient(90deg,rgb(62, 110, 181),rgb(50, 102, 181));
            color: #fff;
            padding: 4rem 0;
        }
        .hero-section h1 {
            font-size: 3rem;
            font-weight: bold;
        }
        .hero-section p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
        }
        .hero-section .form-control {
            border-radius: 0.5rem;
            border: none;
        }
        .hero-section .btn-primary {
            background-color: #ffc107;
            border: none;
            color: #000;
            font-weight: bold;
        }
        .hero-section .btn-primary:hover {
            background-color: #e0a800;
        }
        .hero-section .form-select {
            border-radius: 0.5rem;
        }
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
        }
        .card .fa {
            color: #6610f2;
        }
        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #343a40;
        }
        .card-text {
            font-size: 1rem;
            color: #6c757d;
        }
        .btn-primary {
            background-color: #ffc107;
            border: none;
            color: #000;
            font-weight: bold;
            border-radius: 0.5rem;
        }
        .btn-primary:hover {
            background-color: #e0a800;
        } 
        footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
        }
        footer a {
            color: #17a2b8;
            text-decoration: none;
        }
        footer a:hover {
            text-decoration: underline;
        }

        /* General styling for the job card container */
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
}

.card:hover {
    transform: translateY(-5px);
}

.search-results-container .display {
    margin-top: 20px;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
}

.col {
    flex: 1 1 calc(33.333% - 20px);
    max-width: 33.333%;
}

@media (max-width: 768px) {
    .col {
        flex: 1 1 calc(50% - 20px); /* Two cards per row */
        max-width: calc(50% - 20px);
    }
}

@media (max-width: 576px) {
    .col {
        flex: 1 1 100%; /* Single card per row */
        max-width: 100%;
    }
    .job-card {
        margin: 0 auto;
        padding: 15px; /* Adds padding for better spacing */
    }
}

.apply-btn {
    margin-top: 15px;
    background-color: rgb(62, 110, 181);;
    color: #fff;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 0.9rem;
}

.apply-btn:hover {
    background-color: rgb(62, 110, 181);;
}
.modal-content {
            border-radius: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .modal-header {
            background-color: rgb(62, 110, 181);
            color: #fff;
            border-bottom: none;
            border-radius: 1rem 1rem 0 0;
        }
        .modal-title {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .btn-close {
            background-color: #fff;
            opacity: 0.8;
        }
        .btn-close:hover {
            opacity: 1;
        }
        .modal-body {
            padding: 2rem;
        }
        .form-label {
            font-weight: bold;
            color: #495057;
        }
        .form-control {
            border-radius: 0.5rem;
            border: 1px solid #ced4da;
            transition: box-shadow 0.3s ease;
        }
        .form-control:focus {
            box-shadow: 0 0 5px rgba(102, 16, 242, 0.5);
            border-color: rgb(62, 110, 181);;
        }
        .btn-primary {
            background-color: rgb(62, 110, 181);;
            border: none;
            border-radius: 0.5rem;
            font-weight: bold;
        }
        .btn-primary:hover {
            background-color: rgb(62, 110, 181);;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
            border-radius: 0.5rem;
            font-weight: bold;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .text-center button {
            margin: 0 10px;
        }
        #employerToggleLinks p {
            margin: 0.5rem 0;
            text-align: center;
        }
        #employerToggleLinks a {
            color: rgb(62, 110, 181);;
            font-weight: bold;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        #employerToggleLinks a:hover {
            color: rgb(62, 110, 181);;
            text-decoration: underline;
        }
        #toggleLinks p {
            margin: 0.5rem 0;
            text-align: center;
        }
        #toggleLinks a {
            color: rgb(62, 110, 181);;
            font-weight: bold;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        #toggleLinks a:hover {
            color: rgb(62, 110, 181);;
            text-decoration: underline;
        }
        .card-body i {
            color:rgb(62, 110, 181);;
        }
        .card.expired {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }

    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">JobPortal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#jobseekerModal">
                            <i class="fas fa-user"></i> Jobseeker
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#employerModal">
                            <i class="fas fa-briefcase"></i> Employer
                        </a>
                    </li>
                    <?php if (!isset($user_name)): ?>
        <li class="nav-item">
            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#continueModal">
                <i class="fas fa-right-to-bracket"></i> Login/Sign Up
            </a>
        </li>
    <?php else: ?>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($user_name); ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
        </li>
    <?php endif; ?>

                </ul>
            </div>
        </div>
    </nav>
<!-- Search -->
<?php
include('config.php');

$searchResults = ""; // Initialize search results variable

if (isset($_GET['query']) || isset($_GET['filter1']) || isset($_GET['filter2'])) {
    $searchQuery = isset($_GET['query']) ? $conn->real_escape_string(htmlspecialchars($_GET['query'])) : "";
    $searchFilter1 = isset($_GET['location']) ? $conn->real_escape_string(htmlspecialchars($_GET['location'])) : "";
    $searchFilter2 = isset($_GET['job_type']) ? $conn->real_escape_string(htmlspecialchars($_GET['job_type'])) : "";

    // Start building the SQL query
    $sql = "SELECT * FROM jobs WHERE 1=1";

    // Append search query if provided
    if (!empty($searchQuery)) {
        $sql .= " AND job_title LIKE '%$searchQuery%'";
    }

    // Append filter1 (location) if provided
    if (!empty($searchFilter1)) {
        $sql .= " AND (location LIKE '$searchFilter1,%' OR location = '$searchFilter1')";
    }

    // Append filter2 (job type) if provided
    if (!empty($searchFilter2)) {
        $sql .= " AND job_type = '$searchFilter2'";
    }

    $result = $conn->query($sql);

    // Prepare the search results
    if ($result->num_rows > 0) {
        $searchResults .= "<div class='search-results-container'>";
        $searchResults .= "<div class='display row g-4 justify-content-center'>";
        while ($row = $result->fetch_assoc()) {
            $currentDate = date('Y-m-d'); 

            $searchResults .= "
                <div class='col'>
                    <div class='card shadow-sm'>
                        <div class='job-card'>
                            <div class='card-body'>
                                <div class='job-id' style='display:none;'>" . htmlspecialchars($row['id']) . "</div>
                                <div class='job-title'>" . htmlspecialchars($row['job_title']) . "</div>
                                <div class='company-location' name='company_name'>" . htmlspecialchars($row['company_name']) . "<br>" . htmlspecialchars($row['location']) . "</div>
                                <div class='job-description'>" . htmlspecialchars($row['job_description']) . "</div>
                                <div class='deadline'>Job-Type: <strong>" . htmlspecialchars($row['job_type']) . "</strong></div>
                                <div class='job-type'>Application Deadline: <strong>" . htmlspecialchars($row['deadline']) . "</strong></div>";
            
                                if ($row['deadline'] >= $currentDate) {
                                    $searchResults .= "<button class='btn apply-btn'onclick='window.location.href=\"apply_page.php?job_id=" . htmlspecialchars($row['id']) . "\"'>Apply Now</button>";
                                } else {
                                    $searchResults .= "<button class='btn apply-btn' disabled>Application Closed</button>";
                                }
            
            $searchResults .= "
                            </div>
                        </div>
                    </div>
                </div>";           
        }
        $searchResults .= "</div></div>";
    } else {
        $searchResults = "<div class='alert alert-warning mt-3'>No results found. Try adjusting your filters.</div>";
    }
}
?>


<script>
    // Disable search button if no value is entered
    function validateSearch() {
        var query = document.getElementById("query").value.trim();
        var filter1 = document.getElementById("location").value;
        var filter2 = document.getElementById("job_type").value;

        // If no search query and filters are empty, disable the search button
        if (query === "" && filter1 === "" && filter2 === "") {
            document.getElementById("searchButton").disabled = true;
            setTimeout(function() {
                document.getElementById("searchButton").disabled = false;
            }, 1000); // Re-enable the button after 1 second
            return false;
        }
        return true;
    }
    window.onload = function() {
    if (window.location.search) {
        // Remove query parameters from the URL
        history.replaceState(null, '', window.location.pathname);
    }
};

</script>
     <!-- Hero Section -->
     <section class="hero-section">
        <div class="container">
            <div class="text-center mb-4">
                <h1 class="display-5">Find Your Dream Job</h1>
                <p class="lead">Search for jobs by location and type</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form action="" method="GET" onsubmit="return validateSearch();">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="query" id="query" placeholder="Search for jobs" aria-label="Search for jobs" required>
                            <button class="btn btn-primary" type="submit" id="searchButton">Search</button>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <select class="form-select" name="location" id="location1">
                                    <option value="">Select Location</option>
                                    <option value="mumbai"<?php echo (isset($_GET['filter1']) && $_GET['filter1'] == 'Mumbai') ? 'selected' : ''; ?>>Mumbai</option>
                                    <option value="pune"<?php echo (isset($_GET['filter1']) && $_GET['filter1'] == 'Pune') ? 'selected' : ''; ?>>Pune</option>
                                    <option value="hydrabad"<?php echo (isset($_GET['filter1']) && $_GET['filter1'] == 'Hydrabad') ? 'selected' : ''; ?>>Hydrabad</option>
                                    <option value="bangalore"<?php echo (isset($_GET['filter1']) && $_GET['filter1'] == 'Bangalore') ? 'selected' : ''; ?>>Bangalore</option>
                                    <option value="chennai"<?php echo (isset($_GET['filter1']) && $_GET['filter1'] == 'Chennai') ? 'selected' : ''; ?>>Chennai</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <select class="form-select" name="job_type" id="job_type">
                                    <option value="">Select Job Type</option>
                                    <option value="full time"<?php echo (isset($_GET['filter2']) && $_GET['filter2'] == 'Full Time') ? 'selected' : ''; ?>>Full time</option>
                                    <option value="part time"<?php echo (isset($_GET['filter2']) && $_GET['filter2'] == 'Part Time') ? 'selected' : ''; ?>>Part Time</option>
                                    <option value="remote working"<?php echo (isset($_GET['filter2']) && $_GET['filter2'] == 'Remote Working') ? 'selected' : ''; ?>>Remote Working</option>
                                    <option value="internship"<?php echo (isset($_GET['filter2']) && $_GET['filter2'] == 'Internship') ? 'selected' : ''; ?>>Internship</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
<!-- Display search results below the search bar -->
<div class="search-results container">
    <?php 
    if (!empty($searchResults)) {
        echo $searchResults; 
    } else {
        echo "<div class='alert alert-success mt-3'>Start your search to see job listings!</div>";
    }
    ?>
</div>


<!-- Cards Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <!-- Jobseeker Card -->
            <div class="col-sm-12 col-md-6 col-lg-5">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-user fa-3x mb-3 mt-3"></i>
                        <h5 class="card-title">Jobseeker</h5>
                        <p class="card-text">Looking for your next opportunity? Find jobs tailored to your skills and preferences.</p>
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#continueModal">Find Jobs</a>
                    </div>
                </div>
            </div>
            <!-- Employer Card -->
            <div class="col-sm-12 col-md-6 col-lg-5">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-briefcase fa-3x mb-3 mt-3"></i>
                        <h5 class="card-title">Employer</h5>
                        <p class="card-text">Looking to hire? Post jobs and find the right candidates for your company.</p>
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#continueModal">Post Jobs</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

        <!-- Jobseeker Modal -->
        <div class="modal fade" id="jobseekerModal" tabindex="-1" aria-labelledby="jobseekerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jobseekerModalLabel">Apply for a Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="apply.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="fullName" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="fullName" name="full_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email ID</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="resume" class="form-label">Upload Resume</label>
                            <input type="file" class="form-control" id="resume" name="resume" accept=".pdf,.doc,.docx" required>
                        </div>
                        <div class="text-center">
                        <button type="submit" class="btn btn-primary"style="width:100px">Submit</button>
                        <button type="submit" class="btn btn-secondary"style="width:100px">Clear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Employer Modal -->
<div class="modal fade" id="employerModal" tabindex="-1" aria-labelledby="employerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="employerModalLabel">Post a Job</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="post_job.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="jobTitle" class="form-label">Job Title (Max 100 characters)</label>
                        <input type="text" class="form-control" id="jobTitle" name="job_title" maxlength="100" required>
                    </div>
                    <div class="mb-3">
                        <label for="companyName" class="form-label">Company Name</label>
                        <input type="text" class="form-control" id="companyName" name="company_name" value="<?php echo htmlspecialchars($company_name); ?>" readonly required>
                    </div>
                    <div class="mb-3">
                        <label for="jobDescription" class="form-label">Job Description</label>
                        <div id="jobDescriptionEditor" class="form-control" style="height: 150px;"></div>
                        <input type="hidden" id="jobDescription" name="job_description">
                    </div>
                    <div class="mb-3">
                        <label for="jobType" class="form-label">Job Type</label>
                        <select class="form-control" id="jobType" name="job_type" required>
                            <option value="full_time">Full Time</option>
                            <option value="part_time">Part Time</option>
                            <option value="remote_working">Remote Working</option>
                            <option value="internship">Internship</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="location2" name="location" required>
                    </div>
                    <div class="mb-3">
                        <label for="salaryRange" class="form-label">Salary Range</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="salaryMin" name="salary_min" placeholder="Minimum" required>
                            <span class="input-group-text">-</span>
                            <input type="number" class="form-control" id="salaryMax" name="salary_max" placeholder="Maximum" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="applicationDeadline" class="form-label">Application Deadline</label>
                        <input type="date" class="form-control" id="applicationDeadline" name="application_deadline" min="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="companyLogo" class="form-label">Upload Company Logo (Max 400x400)</label>
                        <input type="file" class="form-control" id="companyLogo2" name="company_logo" accept="image/*" required>
                        <small class="form-text text-muted">Logo size must not exceed 400x400 pixels.</small>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" style="width:100px">Post Job</button>
                        <button type="reset" class="btn btn-secondary" style="width:100px">Clear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Continue as Employer or Jobseeker Modal -->
<div class="modal fade" id="continueModal" tabindex="-1" aria-labelledby="continueModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="continueModalLabel">Choose Your Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p>Do you want to continue as:</p>
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <!-- Employer Option -->
                    <div class="role-option" id="employerOption" style="cursor: pointer;"data-bs-toggle="modal" data-bs-target="#employerRegistrationModal">
                        <i class="fas fa-briefcase fa-3x" style="color:rgb(62, 110, 181);"></i>
                        <h5 style="color:rgb(62, 110, 181);">Employer</h5>
                    </div>

                    <!-- OR Keyword -->
                    <div class="my-3">
                        <span class="text-muted" style="font-weight:700">OR</span>
                    </div>

                    <!-- Jobseeker Option -->
                    <div class="role-option" id="jobseekerOption" style="cursor: pointer;"data-bs-toggle="modal" data-bs-target="#jobseekerRegistrationModal">
                        <i class="fas fa-user fa-3x" style="color:rgb(62, 110, 181);"></i>
                        <h5 style="color:rgb(62, 110, 181);">Jobseeker</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Employer Registration Form Modal -->
<div class="modal fade" id="employerRegistrationModal" tabindex="-1" aria-labelledby="employerRegistrationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="employerRegistrationModalLabel">Employer Registration</h5>
                <button type="button" class="btn-close" id="cancelButton" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Employer Registration Form -->
                <div id="employerRegistrationForm">
                    <form action="employer_registration.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="companyLogo" class="form-label">Upload Company Logo (Max 400x400)</label>
                            <input type="file" class="form-control" id="companyLogo1" name="company_logo" accept="image/*" required>
                            <small class="form-text text-muted">Logo size must not exceed 400x400 pixels.</small>
                        </div>
                        <div class="mb-3">
                            <label for="employerName" class="form-label">Company Name</label>
                            <input type="text" class="form-control" id="employerName" name="company_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="employerAddress" class="form-label">Company Address</label>
                            <textarea class="form-control" name="company_address" id="employerAddress" rows=5 required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="employerEmail" class="form-label">Email ID</label>
                            <input type="email" class="form-control" id="employerEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="employerPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="employerPassword" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Register</button>
                        <button type="button" class="btn btn-secondary" onclick="clearEmployerForm()">Clear</button>
                    </form>
                </div>

                <!-- Employer Login Form -->
                <div id="employerLoginForm" style="display:none;">
                    <form action="employer_login.php" method="POST">
                        <div class="mb-3">
                            <label for="employerLoginEmail" class="form-label">Email ID</label>
                            <input type="email" class="form-control" id="employerLoginEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="employerLoginPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="employerLoginPassword" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                        <button type="submit" class="btn btn-secondary">Clear</button>
                    </form>
                </div>

                <!-- Toggle Links -->
                <div id="employerToggleLinks">
                    <p id="employerRegisterLink" style="display:none;"><a href="javascript:void(0)" onclick="toggleEmployerForm('register')">Don't have an account? Register here</a></p>
                    <p id="employerLoginLink"><a href="javascript:void(0)" onclick="toggleEmployerForm('login')">Already have an account? Login here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleEmployerForm(formType) {
        if (formType === 'register') {
            document.getElementById('employerRegistrationForm').style.display = 'block';
            document.getElementById('employerLoginForm').style.display = 'none';
            document.getElementById('employerRegisterLink').style.display = 'none';
            document.getElementById('employerLoginLink').style.display = 'block';
        } else if (formType === 'login') {
            document.getElementById('employerRegistrationForm').style.display = 'none';
            document.getElementById('employerLoginForm').style.display = 'block';
            document.getElementById('employerRegisterLink').style.display = 'block';
            document.getElementById('employerLoginLink').style.display = 'none';
        }
    }

    function clearEmployerForm() {
        document.getElementById('companyLogo').value = '';
        document.getElementById('employerName').value = '';
        document.getElementById('employerAddress').value = '';
        document.getElementById('employerEmail').value = '';
        document.getElementById('employerPassword').value = '';
    }

    // Set initial state
    toggleEmployerForm('register');
</script>


<div class="modal fade" id="jobseekerRegistrationModal" tabindex="-1" aria-labelledby="jobseekerRegistrationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="jobseekerRegistrationModalLabel">Jobseeker Registration</h5>
                <button type="button" class="btn-close" id="cancelButton" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Registration Form -->
                <div id="registrationForm">
                    <form action="jobseeker_registration.php" method="POST">
                        <div class="mb-3">
                            <label for="jobseekerName" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="jobseekerName" name="full_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="jobseekerEmail" class="form-label">Email ID</label>
                            <input type="email" class="form-control" id="jobseekerEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="jobseekerPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="jobseekerPassword" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Register</button>
                        <button type="button" class="btn btn-secondary" onclick="clearForm()">Clear</button>
                    </form>
                </div>
                
                <!-- Login Form -->
                <div id="loginForm" style="display:none;">
                    <form action="jobseeker_login.php" method="POST">
                        <div class="mb-3">
                            <label for="loginEmail" class="form-label">Email ID</label>
                            <input type="email" class="form-control" id="loginEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="loginPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="loginPassword" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                        <button type="submit" class="btn btn-secondary">Clear</button>
                    </form>
                </div>
                
                <!-- Toggle Links -->
                <div id="toggleLinks">
                    <p id="registerLink" style="display:none;"><a href="javascript:void(0)" onclick="toggleForm('register')">Don't have an account? Register here</a></p>
                    <p id="loginLink"><a href="javascript:void(0)" onclick="toggleForm('login')">Already have an account? Login here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Login Required Modal -->
<div class="modal fade" id="loginAlertModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Access Denied</h5>
                <button type="button" id="cancelButton" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Please login or register as a employer to post a job.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="cancelButton" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>


<script>
    function toggleForm(formType) {
        if (formType === 'register') {
            document.getElementById('registrationForm').style.display = 'block';
            document.getElementById('loginForm').style.display = 'none';
            document.getElementById('registerLink').style.display = 'none';
            document.getElementById('loginLink').style.display = 'block';
        } else if (formType === 'login') {
            document.getElementById('registrationForm').style.display = 'none';
            document.getElementById('loginForm').style.display = 'block';
            document.getElementById('registerLink').style.display = 'block';
            document.getElementById('loginLink').style.display = 'none';
        }
    }

    function clearForm() {
        document.getElementById('jobseekerName').value = '';
        document.getElementById('jobseekerEmail').value = '';
        document.getElementById('jobseekerPassword').value = '';
    }

    // Set initial state
    toggleForm('register');
</script>


<script>
    // Handle Employer and Jobseeker Modal Options
    document.getElementById('employerOption').addEventListener('click', function () {
        $('#continueModal').modal('hide');  // Close the initial modal
        $('#employerRegistrationModal').modal('show');  // Show the employer registration modal
    });

    document.getElementById('jobseekerOption').addEventListener('click', function () {
        $('#continueModal').modal('hide');  // Close the initial modal
        $('#jobseekerRegistrationModal').modal('show');  // Show the jobseeker registration modal
    });

    document.getElementById('cancelButton').addEventListener('click', function() {
        // Redirect to home page after closing the modal
        window.location.href = 'index.php';
    });
</script>
     <!-- Footer Section -->
     <footer>
        <div class="container text-center">
            <div class="mt-3">
                <p>&copy; 2025 JobPortal. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
    <script>
   document.addEventListener("DOMContentLoaded", function () {
    // Initialize Quill editor
    const quill = new Quill("#jobDescriptionEditor", { theme: "snow" });

    // Select the hidden input
    const hiddenInput = document.getElementById("jobDescription");

    // Ensure hidden input exists
    if (!hiddenInput) {
     console.error("Hidden input jobDescription not found!");
       return;
    }

    // Update hidden input when Quill content changes
    quill.on("text-change", function () {
        hiddenInput.value = quill.getText().trim();
       
    });

    // Ensure value is set before form submission
    document.querySelector("form").addEventListener("submit", function (event) {
        hiddenInput.value = quill.getText().trim(); 
      
    });
});  
</script>
<script>
   document.addEventListener("DOMContentLoaded", function () {
    var employerModal = document.getElementById("employerModal");
    
    employerModal.addEventListener("show.bs.modal", function (event) {
        <?php if (!$company_name): ?>
            event.preventDefault(); // Stop modal from opening
            event.stopImmediatePropagation(); // Prevents further execution
            var loginAlert = new bootstrap.Modal(document.getElementById("loginAlertModal"));
            loginAlert.show();
        <?php endif; ?>
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
