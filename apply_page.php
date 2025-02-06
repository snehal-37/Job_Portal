<?php 
include('config.php');
$job_id = isset($_GET['job_id']) ? intval($_GET['job_id']) : 0;

// Initialize company_name as an empty string
$company_name = '';

// Fetch company name based on the job id
if ($job_id > 0) {
    // Query to fetch company name from the jobs table based on job_id
    $sql = "SELECT * FROM jobs WHERE id = $job_id";
    $result = $conn->query($sql);

    // Check if the query returned any rows
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $company_name = $row['company_name'];
        $job_title = $row['job_title'];
    } else {
        echo "Job not found.";
        exit;  // Terminate if the job is not found
    }
} else {
    echo "Invalid Job ID.";
    exit;  // Exit if no job ID is provided
}

?>

<!doctype html>
<html lang="en">
    <head>
        <title>Apply Job</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    </head>

    <body>
        <main>
            <!-- Apply Job Modal -->
 <div class="modal fade" id="applyModal" tabindex="-1" aria-labelledby="applyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="applyModalLabel">Application Form</h5>
                    <button type="button" class="btn-close" id="cancelButton" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="submit_form.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="applicant_name" class="form-label">Applicant's Name</label>
                            <input type="text" class="form-control" id="applicant_name" name="applicant_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email_id" class="form-label">Email ID</label>
                            <input type="email" class="form-control" id="email_id" name="email_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="job_experience" class="form-label">Experienced</label>
                            <select class="form-control" id="job_experience" name="job_experience" required>
                                <option value="Fresher">Fresher</option>
                                <option value="1 year">1 year</option>
                                <option value="2 years">2 years</option>
                                <option value="3 years">3 years</option>
                                <option value="more than 3 years">more than 3 years</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="resume" class="form-label">Upload Resume</label>
                            <input type="file" class="form-control" id="resume" name="resume" accept=".pdf,.doc,.docx" required>
                        </div>
                        <div class="mb-3" style="display:none";>
                            <input type="text" class="form-control" id="company_name" name="company_name" value="<?php echo $company_name ?>">
                        </div>
                        <div class="mb-3" style="display:none";>
                            <input type="text" class="form-control" id="job_title" name="job_title" value="<?php echo $job_title ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Apply</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
        </main>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
            var applyModal = new bootstrap.Modal(document.getElementById('applyModal'),{
                backdrop: 'static', 
                keyboard: false 
            });
                applyModal.show(); // Show the modal when the page loads
                
            });

            document.getElementById('cancelButton').addEventListener('click', function() {
            // Redirect to home page after closing the modal
            window.location.href = 'index.php';
        });

        </script>
        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
