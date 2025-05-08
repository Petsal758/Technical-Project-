<?php
// Include database connection
require_once 'db.php';

// Initialize variables
$bmi = 0.0;
$message = "";
$conn = mysqli_connect( "localhost", "root",  "",  "smart_gym"); 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $height = floatval($_POST['height']); // Height in meters
    $weight = floatval($_POST['weight']); // Weight in kilograms
    $user_id = intval($_POST['user_id']); // User ID from the session or form

    // Validate input
    if ($height > 0 && $weight > 0) {
        // Calculate BMI
        $bmi = $weight / ($height * $height);
        $bmi = round($bmi, 2); // Round to 2 decimal places
 
        // Insert into database
        $sql = "INSERT INTO progress (user_id, weight, body_fat_percentage, date) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("idd", $user_id, $weight, $bmi);

        if ($stmt->execute()) {
            $message = "BMI calculated and saved successfully!";
        } else {
            $message = "Error saving BMI: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $message = "Invalid height or weight!";
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMI Calculator</title>
</head>
<body>
    <h1>BMI Calculator</h1>
    <form method="POST" action="bmi_calculator.php">
        <label for="height">Height (in meters):</label>
        <input type="number" step="0.01" id="height" name="height" required><br><br>

        <label for="weight">Weight (in kilograms):</label>
        <input type="number" step="0.01" id="weight" name="weight" required><br><br>

        <input type="hidden" name="user_id" value="1"> <!-- Replace with actual user ID -->
        <button type="submit">Calculate BMI</button>
    </form>

    <?php if (!empty($message)): ?>
        <p style="color: green;"><?php echo $message; ?></p>
    <?php endif; ?>
</body>
</html>