<?php
session_start();
include '../config.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $job_id = $_POST['job_id'];
    $job_title = $_POST['job_title'];
    $job_description = $_POST['job_description'];
    $location = $_POST['location'];
    $min_salary = $_POST['min_salary'];
    $max_salary = $_POST['max_salary'];
    $deadline = $_POST['deadline'];

    // Handle Logo Upload
    if (!empty($_FILES['newLogo']['name'])) {
        $target_dir = "uploads/";
        $logo = basename($_FILES["newLogo"]["name"]);
        $target_file = $target_dir . $logo;
        move_uploaded_file($_FILES["newLogo"]["tmp_name"], $target_file);

        // Update query with logo
        $sql = "UPDATE jobs SET job_title=?, job_description=?, location=?, min_salary=?, max_salary=?, deadline=?, logo=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssddsds", $job_title, $job_description, $location, $min_salary, $max_salary, $deadline, $logo, $job_id);
    } else {
        // Update query without logo
        $sql = "UPDATE jobs SET job_title=?, job_description=?, location=?, min_salary=?, max_salary=?, deadline=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssddsd", $job_title, $job_description, $location, $min_salary, $max_salary, $deadline, $job_id);
    }

    if ($stmt->execute()) {
        $_SESSION['message'] = "Job updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating job.";
    }

    $stmt->close();
    header("Location: index.php"); // Redirect back to the dashboard
    exit();
}
?>
