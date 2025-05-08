<?php
// Include database connection
require_once 'db.php';

// Initialize variables
$email = $password = "";
$error_message = "";
$conn = mysqli_connect( "localhost", "root",  "",  "smart_gym"); 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate input
    if (empty($email) || empty($password)) {
        $error_message = "Both email and password are required!";
    } else {
        // Fetch user from database
        $sql = "SELECT id, password FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // Fetch user data
            $user = $result->fetch_assoc();
            $hashed_password = $user['password'];

            // Verify password
            if (password_verify($password, $hashed_password)) {
                // Start session and redirect to dashboard
                session_start();
                $_SESSION['user_id'] = $user['id'];
                header("Location: dashboard.html");
                exit;
            } else {
                $error_message = "Invalid password. Please try again.";
            }
        } else {
            $error_message = "No account found with this email.";
        }

        $stmt->close();
    }
}

// Close database connection
$conn->close();
?>