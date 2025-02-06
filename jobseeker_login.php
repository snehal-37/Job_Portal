<?php
session_start(); // Start the session

include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Retrieve user details from the database
    $sql = "SELECT id, full_name, email_id, password FROM jobseeker WHERE email_id = ?";
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
            $_SESSION['user_type'] = 'jobseeker'; // To differentiate between user types
            $_SESSION['full_name'] = $row['full_name'];
            $_SESSION['email'] = $row['email_id'];
            $_SESSION['user_id'] = $row['id']; // Optional: Store user ID for reference

            header("Location: index.php"); // Redirect to the dashboard
            exit();
        } else {
            echo "Incorrect password. Please try again.";
        }
    } else {
        echo "No account found with this email address.";
    }

    $stmt->close();
}
$conn->close();
?>
