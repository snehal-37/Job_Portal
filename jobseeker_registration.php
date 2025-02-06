<?php
session_start(); // Start the session

include('config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if email already exists
    $email_check_sql = "SELECT id FROM jobseeker WHERE email_id = ?";
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

    // Insert into database
    $sql = "INSERT INTO jobseeker (full_name, email_id, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $full_name, $email, $hashed_password);

    if ($stmt->execute()) {
        // Set session variables
        $_SESSION['loggedin'] = true;
        $_SESSION['user_type'] = 'jobseeker'; // To differentiate between user types
        $_SESSION['full_name'] = $full_name;
        $_SESSION['email'] = $email;
        $mail = new PHPMailer(true);

        $uemail=''; //enter your email id here
        $upass=''; //enter your app password here

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $uemail; 
            $mail->Password = $upass; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 25;
    
            $mail->setFrom('Your emailaddress', 'Job Portal');//enter your email address here
            $mail->addAddress($email);
            $mail->Subject = 'Registartion Successful';
            $mail->Body = "Dear Candidate,\n\nYou are successfully register with Job Portal\n\n\n\nRegards,\nJob Portal";
    
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
