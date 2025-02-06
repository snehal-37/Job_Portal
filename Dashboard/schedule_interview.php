<?php
session_start();
include('../config.php');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

if (!isset($_GET['id'])) {
    die("Invalid request");
}

$application_id = $_GET['id'];
$query = "SELECT email_id FROM applications WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $application_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Candidate not found");
}

$row = $result->fetch_assoc();
$candidate_email = $row['email_id'];

$error_message = "";
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_email'])) {
    $message = $_POST['message'];
    $interview_date = $_POST['interview_date'];
    
    $mail = new PHPMailer(true);


    $uemail=''; //enter your email id here
    $upass=''; //enter your app password here

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Change this to your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = $uemail; 
        $mail->Password = $upass; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 25;

        $mail->setFrom('your emailaddress', 'HR Team');//enter your email id
        $mail->addAddress($candidate_email);
        $mail->Subject = 'Interview Scheduled';
        $mail->Body = "Dear Candidate,\n\nYou are invited for an interview on $interview_date.\n\nMessage from Employer: \n$message\n\nBest Regards,\nHR Team";

        $mail->send();
        $success_message = "Interview scheduled successfully and email sent.";
        $query = "UPDATE applications SET viewed = 3, Status = 'Interview Scheduled' WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $application_id);    
    if ($stmt->execute()) {
        header("Location:index.php");
        exit();

        } else {
            echo "Error scheduling interview: " . $conn->error;
        } 
    } catch (Exception $e) {
        $error_message = "Error sending email: " . $mail->ErrorInfo;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Interview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>
<body>
    <div class="container mt-5">
        <h3>Schedule Interview</h3>
        <?php if (!empty($error_message)) echo "<div class='alert alert-danger'>$error_message</div>"; ?>
        <?php if (!empty($success_message)) echo "<div class='alert alert-success'>$success_message</div>"; ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Candidate Email</label>
                <input type="email" class="form-control" value="<?php echo htmlspecialchars($candidate_email); ?>" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Interview Date</label>
                <input type="text" id="interview_date" name="interview_date" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Message</label>
                <textarea name="message" class="form-control" rows="5" required></textarea>
            </div>
            <button type="submit" name="send_email" class="btn btn-primary">Send</button>
        </form>
    </div>
    <script>
    flatpickr("#interview_date", { 
        enableTime: true, 
        dateFormat: "Y-m-d H:i",
        minDate: "today" // Prevents selection of past dates and times
    });
</script>

</body>
</html>
