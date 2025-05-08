<?php
// Start the session
session_start();

// Destroy the session
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session completely

// Redirect to the login page or homepage
header("Location: login.html");
exit();
?>