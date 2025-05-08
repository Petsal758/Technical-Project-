<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'db.php'; // Include database connection
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $conn = new mysqli("localhost", "root", "", "smart_gym");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve and sanitize user input
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $age = filter_var($_POST['age'], FILTER_VALIDATE_INT);
    $gender = trim($_POST['gender']);
    $height = filter_var($_POST['height'], FILTER_VALIDATE_FLOAT);
    $weight = filter_var($_POST['weight'], FILTER_VALIDATE_FLOAT);

    // Validate input
    if (!$username || !$email || !$password || !$age || !$gender || !$height || !$weight) {
        die("Error: All fields are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Error: Invalid email format.");
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO users (username, password, email, age, gender, height, weight) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("SQL Prepare Error: " . $conn->error);
    }

    // Bind parameters and execute
    $stmt->bind_param("sssisdd", $username, $hashed_password, $email, $age, $gender, $height, $weight);
    if ($stmt->execute()) {
        header("Location: login.html"); // Redirect after successful signup
        $stmt->close();
        $conn->close();
        exit();
    } else {
        die("SQL Execution Error: " . $stmt->error);
    }
}
?>