<?php
// This will handle updating the settings like password, system email, and notification preferences
session_start();
include '../config.php';

// Check if the company_name is set in the session
if (isset($_SESSION['company_name'])) {
    $company_name = $_SESSION['company_name'];
        
        // Proceed to update the settings only if the job id is found
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get form data
            $newPassword = $_POST['changePassword'];
            $systemEmail = $_POST['systemEmail'];
            $company_address = $_POST['companyAddress'];

            // Hash the password before saving it
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

            // Example query to update the settings (make sure it's updating the correct table)
            $sql = "UPDATE employer SET email_id = ?, password = ?, company_address = ? WHERE company_name = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssss', $systemEmail, $hashedPassword, $company_address, $company_name);  // Bind the parameters correctly

            if ($stmt->execute()) {
                $_SESSION['message'] = "Settings updated successfully!";
            } else {
                $_SESSION['error'] = "Error updating settings.";
            }

            $stmt->close();
            header("Location: index.php"); // Redirect to the home page
            exit();
        }

    $stmt->close();
} else {
    $_SESSION['error'] = "Company name not found in session.";
    header("Location: index.php");
    exit();
}
?>
