<?php
session_start();
include '../config.php';

if (isset($_POST['job_id'])) {
    $job_id = intval($_POST['job_id']); // Ensure job_id is an integer

    // Check if the job_id is valid
    if ($job_id > 0) {
        // Prepare SQL query to delete the job from the database
        $sql = "DELETE FROM jobs WHERE id = ?";
        $stmt = $conn->prepare($sql);

        // Check if prepare() was successful
        if ($stmt === false) {
            $_SESSION['error'] = "Error preparing SQL query.";
            header("Location: index.php");
            exit();
        }

        $stmt->bind_param("i", $job_id); // Use "i" for integer binding

        if ($stmt->execute()) {
            $_SESSION['message'] = "Job deleted successfully!";
        } else {
            $_SESSION['error'] = "Error deleting job.";
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = "Invalid job ID.";
    }
} else {
    $_SESSION['error'] = "Job ID not provided.";
}

header("Location: index.php");
exit();
?>
