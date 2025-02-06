<?php
session_start();
include '../config.php';

// Fetch company name from the session
$company_name = $_SESSION['company_name'];

$sql = "SELECT COUNT(*) as total_applications FROM applications WHERE company_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $company_name);
$stmt->execute();
$stmt->bind_result($applications);
$stmt->fetch();
$stmt->close();

if (isset($_GET['section'])) {
    $section = $_GET['section'];
    
    switch ($section) {
        case 'Job_Postings':
            echo "<div class='jobs-table mt-4'>
                <h4>Job Postings</h4>

                <div class='table-responsive'>
                    <table class='table table-striped'>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Job Title</th>
                                <th>Location</th>
                                <th>Job Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>";
            $sql = "SELECT * FROM jobs WHERE company_name = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $company_name);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $counter = 1;
                while ($row = $result->fetch_assoc()) {
                    $job_title = htmlspecialchars($row['job_title']);
                    $location = htmlspecialchars($row['location']);
                    $description = htmlspecialchars($row['job_description']);
                    $min_salary = htmlspecialchars($row['min_salary']);
                    $max_salary = htmlspecialchars($row['max_salary']);
                    $deadline = htmlspecialchars($row['deadline']);
                    $logo = htmlspecialchars($row['logo']);
                    $job_id = $row['id'];

                    echo "<tr>
                            <td>{$counter}</td>
                            <td>{$job_title}</td>
                            <td>{$location}</td>
                            <td>{$description}</td>
                            <td>
                                <button class='btn btn-sm btn-outline-info' onclick='window.location.href=\"modify_job_modal.php?job_id=" . htmlspecialchars($row['id']) . "\"'>Modify</button>
                                <button class='btn btn-sm btn-outline-danger' onclick='window.location.href=\"delete_job_modal.php?job_id=" . htmlspecialchars($row['id']) . "\"'>Delete</button>
                            </td>
                          </tr>";
                        $counter++;
                }
            } else {
                echo "<tr><td colspan='4'>No Jobs found for this company.</td></tr>";
            }

            echo "</tbody>
                    </table>
                </div>
            </div>";

            break;

            case 'Settings':
                if ($section == 'Settings') {
                    // Fetch the job id and other details using the company_name from the jobs table
    $sql = "SELECT * FROM employer WHERE company_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $company_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc(); 
        echo '
        <div class="container mt-4">
            <h2>Profile Settings</h2>
            <div class="row">
                <!-- Left section: Form to update settings -->
                <div class="col-md-8">
                    <form action="update_settings.php" method="POST">
                        <div class="mb-3">
                            <label for="companyName" class="form-label">Company Name</label>
                            <input type="text" class="form-control" id="companyName" name="companyName" value="' . htmlspecialchars($user['company_name']) . '" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="companyAddress" class="form-label">Company Address</label>
                            <input type="text" class="form-control" id="companyAddress" name="companyAddress" value="' . htmlspecialchars($user['company_address']) . '">
                        </div>

                        <div class="mb-3">
                            <label for="companyEmail" class="form-label">Company Email</label>
                            <input type="email" class="form-control" id="companyEmail" name="companyEmail" value="' . htmlspecialchars($user['email_id']) . '">
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Save Settings</button>
                    </form>
                </div>

                <!-- Right section: Company logo display and upload -->
                <div class="col-md-4">
                    <div class="text-center">
            
                    </div>
                </div>
            </div>
        </div>
        ';
    } else {
        echo '<p>No profile found for the company.</p>';
    }

    $stmt->close();
}
                break;
            
        
        default:
            echo "<p>Invalid Section</p>";
            break;
    }
}
?>
