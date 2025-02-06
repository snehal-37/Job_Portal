<?php 
include('../config.php');
$job_id = isset($_GET['job_id']) ? intval($_GET['job_id']) : 0;

// Initialize variables
$company_name = '';
$job_title = '';
$description = '';
$location = '';
$min_salary = '';
$max_salary = '';
$deadline = '';
$logo = '';

// Fetch job details based on job_id
if ($job_id > 0) {
    $sql = "SELECT * FROM jobs WHERE id = $job_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $company_name = $row['company_name'];
        $job_title = $row['job_title'];
        $description = $row['job_description'];
        $location = $row['location'];
        $min_salary = $row['min_salary'];
        $max_salary = $row['max_salary'];
        $deadline = $row['deadline'];
        $logo = $row['logo'];
    } else {
        echo "Job not found.";
        exit;
    }
} else {
    echo "Invalid Job ID.";
    exit;
}
?>

<!doctype html>
<html lang="en">
    <head>
        <title>Edit Job Details</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    </head>

    <body>
        <main>
            <!-- Edit Job Modal -->
            <div class="modal fade" id="jobModal<?php echo $job_id; ?>" tabindex="-1" aria-labelledby="jobModalLabel<?php echo $job_id; ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="jobModalLabel<?php echo $job_id; ?>">Edit Job Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" id="cancelButton" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="update_job.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="job_id" value="<?php echo $job_id; ?>">
                                
                                <div class="mb-3">
                                    <label class="form-label">Job Title:</label>
                                    <input type="text" class="form-control" name="job_title" value="<?php echo $job_title; ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Description:</label>
                                    <textarea class="form-control" name="job_description" required><?php echo $description; ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Job Location:</label>
                                    <input type="text" class="form-control" name="location" value="<?php echo $location; ?>" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Minimum Salary:</label>
                                        <input type="number" class="form-control" name="min_salary" value="<?php echo $min_salary; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Maximum Salary:</label>
                                        <input type="number" class="form-control" name="max_salary" value="<?php echo $max_salary; ?>" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Application Deadline:</label>
                                    <input type="date" class="form-control" name="deadline" value="<?php echo $deadline; ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Current Logo:</label><br>
                                    <p><strong>Logo:</strong> <a href= '../<?php echo "$logo" ?>' target='_blank'>View logo</a></p>
                                    <label class="form-label mt-2">Upload New Logo:</label>
                                    <input type="file" class="form-control" name="newLogo" accept="image/*">
                                </div>

                                <button type="submit" class="btn btn-success" id="saveChangesBtn">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var jobModal = new bootstrap.Modal(document.getElementById('jobModal<?php echo $job_id; ?>'), {
                    backdrop: 'static',
                    keyboard: false
                });
                jobModal.show(); // Show the modal when the page loads
            });
        </script>
         <script>
    document.getElementById('cancelButton').addEventListener('click', function() {
        // Redirect to home page after closing the modal
        window.location.href = 'index.php';
    });
</script>

        <!-- Bootstrap JavaScript Libraries -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    </body>
</html>
