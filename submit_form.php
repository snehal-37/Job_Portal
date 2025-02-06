<?php
include('config.php');

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $applicant_name = mysqli_real_escape_string($conn, $_POST['applicant_name']);
    $email_id = mysqli_real_escape_string($conn, $_POST['email_id']);
    $job_experience = mysqli_real_escape_string($conn, $_POST['job_experience']);
    $company_name = mysqli_real_escape_string($conn, $_POST['company_name']);
    $job_title = mysqli_real_escape_string($conn, $_POST['job_title']);

    // Handle file upload for resume
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == 0) {
        $resume = $_FILES['resume'];
        $resume_name = $resume['name'];
        $resume_tmp_name = $resume['tmp_name'];
        $resume_size = $resume['size'];
        $resume_ext = pathinfo($resume_name, PATHINFO_EXTENSION);

        // Specify allowed file extensions
        $allowed_extensions = ['pdf', 'doc', 'docx'];

        // Check file extension
        if (in_array(strtolower($resume_ext), $allowed_extensions)) {
            // Create a unique name for the file
            $resume_new_name = uniqid('', true) . '.' . $resume_ext;
            $resume_destination = 'uploads/' . $resume_new_name;

            // Move the file to the uploads directory
            if (move_uploaded_file($resume_tmp_name, $resume_destination)) {
                // Insert data into the database
                $sql = "INSERT INTO applications (applicant_name, email_id, job_experience, resume, company_name, job_title,Status) 
                        VALUES ('$applicant_name', '$email_id', '$job_experience', '$resume_new_name','$company_name','$job_title','NA')";

                if ($conn->query($sql) === TRUE) {
                    header("Location:index.php");
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Error uploading resume.";
            }
        } else {
            echo "Invalid file type. Only PDF, DOC, and DOCX files are allowed.";
        }
    } else {
        echo "No resume uploaded or there was an error with the file.";
    }
}

// Close the database connection
$conn->close();
?>
