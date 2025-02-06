<?php
session_start(); // Start the session

include('config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $company_name = mysqli_real_escape_string($conn, $_POST['company_name']);
    $company_address = mysqli_real_escape_string($conn, $_POST['company_address']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);


    $email_check_sql = "SELECT id FROM employer WHERE email_id = ?";
    $email_check_stmt = $conn->prepare($email_check_sql);
    $email_check_stmt->bind_param("s", $email);
    $email_check_stmt->execute();
    $email_check_stmt->store_result();

    if ($email_check_stmt->num_rows > 0) {
        echo "Error: An account with this email already exists. Please use a different email.";
        $email_check_stmt->close();
        $conn->close();
        exit();
    }

    $email_check_stmt->close();

    $company_name_sql = "SELECT id FROM employer WHERE company_name = ?";
    $company_check_stmt = $conn->prepare($company_name_sql);
    $company_check_stmt->bind_param("s", $company_name);
    $company_check_stmt->execute();
    $company_check_stmt->store_result();

    if ($company_check_stmt->num_rows > 0) {
        echo "Error: An account with this company name already exists.";
        $company_check_stmt->close();
        $conn->close();
        exit();
    }

    $company_check_stmt->close();

    // File upload handling
    if (isset($_FILES['company_logo']) && $_FILES['company_logo']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['company_logo']['tmp_name'];
        $file_name = $_FILES['company_logo']['name'];
        $file_size = $_FILES['company_logo']['size'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array(strtolower($file_ext), $allowed_extensions)) {
            die("Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.");
        }
        if ($file_size > 2 * 1024 * 1024) {
            die("File size exceeds the 2MB limit.");
        }

        $uploads_dir = 'uploads/';
        if (!is_dir($uploads_dir)) {
            mkdir($uploads_dir, 0777, true);
        }

        $new_file_name = uniqid('logo_', true) . '.' . $file_ext;
        $destination = $uploads_dir . $new_file_name;
        if (!move_uploaded_file($file_tmp, $destination)) {
            die("Failed to upload the file.");
        }
    } else {
        die("Error uploading file.");
    }

    // Insert into database
    $sql = "INSERT INTO employer (logo, company_name, company_address, email_id, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $new_file_name, $company_name, $company_address, $email, $hashed_password);

    if ($stmt->execute()) {
        // Set session variables
        $_SESSION['loggedin'] = true;
        $_SESSION['company_name'] = $company_name;
        $_SESSION['email'] = $email;
        $_SESSION['logo'] = $new_file_name;

        $mail = new PHPMailer(true);

        $uemail='';  //enter your email id here
        $upass='';   //enter your app password here

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $uemail; 
            $mail->Password = $upass;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 25;
    
            $mail->setFrom('youremailaddress', 'Job Portal');//write your email id
            $mail->addAddress($email);
            $mail->Subject = 'Registartion Successful';
            $mail->Body = "Dear Employer,\n\nYou are successfully register with Job Portal\n\n\n\nRegards,\nJob Portal";
    
            $mail->send();
            header("Location:index.php");
        }catch(Exception $e){
            $error_message = "Error sending email: " . $mail->ErrorInfo;
        }
       
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
