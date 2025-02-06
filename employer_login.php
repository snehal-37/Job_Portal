<?php
session_start(); // Start the session

include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Retrieve user details from the database
    $sql = "SELECT id, company_name, email_id, password, logo FROM employer WHERE email_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Set session variables
            $_SESSION['loggedin'] = true;
            $_SESSION['company_name'] = $row['company_name'];
            $_SESSION['email'] = $row['email_id'];
            $_SESSION['logo'] = $row['logo'];
            
            header("Location: index.php");
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No account found with that email address.";
    }

    $stmt->close();
}
$conn->close();
?>
