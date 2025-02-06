<?php
include('config.php');

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $job_title = $conn->real_escape_string($_POST['job_title']);
    $company_name = $conn->real_escape_string($_POST['company_name']);
    $job_description = $conn->real_escape_string($_POST['job_description']);
    $job_type = $conn->real_escape_string($_POST['job_type']);
    $location = $conn->real_escape_string($_POST['location']);
    $salary_min = $conn->real_escape_string($_POST['salary_min']);
    $salary_max = $conn->real_escape_string($_POST['salary_max']);
    $application_deadline = $conn->real_escape_string($_POST['application_deadline']);

    // Handle file upload
    $upload_dir = "uploads/"; // Directory to store uploaded files
    $company_logo = $_FILES['company_logo']['name'];
    $target_file = $upload_dir . basename($company_logo);
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validate and upload the file
    if ($_FILES['company_logo']['size'] > 0) {
        list($width, $height) = getimagesize($_FILES['company_logo']['tmp_name']);
        if ($width > 400 || $height > 400) {
            die("Error: Image dimensions should not exceed 400x400 pixels.");
        }

        if (!move_uploaded_file($_FILES['company_logo']['tmp_name'], $target_file)) {
            die("Error uploading company logo.");
        }
    } else {
        die("Error: Company logo is required.");
    }

    // Insert data into the database
    $sql = "INSERT INTO jobs (job_title, company_name, job_description, job_type, location, min_salary, max_salary, deadline, logo)
            VALUES ('$job_title', '$company_name', '$job_description', '$job_type', '$location', $salary_min, $salary_max, '$application_deadline', '$target_file')";

    if ($conn->query($sql) === TRUE) {
        header("Location:index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>
