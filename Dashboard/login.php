<?php
// Start session
session_start();
include('../config.php');

// Handle login request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $company_name = $_POST['company_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($company_name) && !empty($email) && !empty($password)) {
        $query = "SELECT * FROM employer WHERE company_name = ? AND email_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $company_name, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['loggedin'] = true;
                $_SESSION['company_name'] = $row['company_name'];
                $_SESSION['email'] = $row['email'];
                header("Location: index.php");
                exit;
            } else {
                $error_message = "Invalid password.";
            }
        } else {
            $error_message = "No account found with the provided details.";
        }
    } else {
        $error_message = "All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .login-card h3 {
            font-size: 1.75rem;
            margin-bottom: 20px;
            text-align: center;
            color: #343a40;
        }
        .form-control {
            margin-bottom: 15px;
        }
        .btn {
            width: 100%;
        }
        .btn-clear {
            background-color: #6c757d;
            border: none;
            color: white;
        }
        .btn-clear:hover {
            background-color: #5a6268;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h3>Admin Login</h3>
        <?php if (!empty($error_message)) echo "<div class='error-message'>$error_message</div>"; ?>
        <?php if (!empty($success_message)) echo "<div class='success-message'>$success_message</div>"; ?>
        <form method="POST" action="">
            <input type="hidden" name="login" value="1">
            <div class="mb-3">
                <label class="form-label">Company Name</label>
                <input type="text" class="form-control" name="company_name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

	