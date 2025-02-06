<?php 
include('../config.php');
$job_id = isset($_GET['job_id']) ? intval($_GET['job_id']) : 0;

// Fetch job title based on job_id to show in the modal
$job_title = '';
if ($job_id > 0) {
    $sql = "SELECT job_title FROM jobs WHERE id = $job_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $job_title = $row['job_title'];
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
        <title>Delete Job Confirmation</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    </head>

    <body>
        <main>
            <!-- Delete Job Confirmation Modal -->
            <div class="modal fade" id="deleteModal<?php echo $job_id; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $job_id; ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel<?php echo $job_id; ?>">Delete Job Confirmation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete the job titled "<strong><?php echo $job_title; ?></strong>"? This action cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                            <form action="delete_job.php" method="POST">
                                <input type="hidden" name="job_id" value="<?php echo $job_id; ?>">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelButton">Cancel</button>
                                <button type="submit" class="btn btn-danger">Delete Job</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal<?php echo $job_id; ?>'), {
                    backdrop: 'static',
                    keyboard: false
                });
                deleteModal.show(); // Show the modal when the page loads
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
