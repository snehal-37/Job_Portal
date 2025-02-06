<?php
include('config.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $email = $conn->real_escape_string($_POST['email']);
    
    // Handle file upload
    $resume = $_FILES['resume'];
    $resume_name = $resume['name'];
    $resume_tmp_name = $resume['tmp_name'];
    $resume_error = $resume['error'];
    $resume_size = $resume['size'];

    // Check for file upload errors
    if ($resume_error === 0) {
        // Generate a unique name for the resume
        $resume_ext = pathinfo($resume_name, PATHINFO_EXTENSION);
        $resume_new_name = uniqid('', true) . "." . $resume_ext;
        $resume_destination = 'uploads/' . $resume_new_name;

        // Move the uploaded file to the uploads directory
        if (move_uploaded_file($resume_tmp_name, $resume_destination)) {
            // Prepare the SQL query to insert the data
            $sql = "INSERT INTO job_applications (full_name, phone_number, email_id, resume) 
                    VALUES ('$full_name', '$phone', '$email', '$resume_new_name')";

            // Execute the query
            if ($conn->query($sql) === TRUE) {
                echo "Application submitted successfully!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "There was an error uploading the resume.";
        }
    } else {
        echo "Error with the file upload.";
    }
}

// Close the database connection
$conn->close();
?>
