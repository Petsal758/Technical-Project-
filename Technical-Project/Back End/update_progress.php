<?php

$message = "";
$conn = mysqli_connect( "localhost", "root",  "",  "smart_gym"); 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $user_id = intval($_POST['user_id']); 
    $weight = floatval($_POST['weight']); 
    $calories_burned = floatval($_POST['calories_burned']); 

  
    if ($weight > 0 && $calories_burned >= 0) {
     
        $sql = "INSERT INTO progress (user_id, weight, calories_burned, date) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("idd", $user_id, $weight, $calories_burned);

        if ($stmt->execute()) {
            $message = "Progress updated successfully!";
        } else {
            $message = "Error updating progress: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $message = "Invalid weight or calories burned!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Progress</title>
</head>
<body>
    <h1>Update Progress</h1>
    <form method="POST" action="update_progress.php">
        <label for="weight">Weight (in kilograms):</label>
        <input type="number" step="0.01" id="weight" name="weight" required><br><br>

        <label for="calories_burned">Calories Burned:</label>
        <input type="number" step="0.01" id="calories_burned" name="calories_burned" required><br><br>

        <input type="hidden" name="user_id" value="1"> <!-- Replace with actual user ID -->
        <button type="submit">Update Progress</button>
    </form>

    <?php if (!empty($message)): ?>
        <p style="color: green;"><?php echo $message; ?></p>
    <?php endif; ?>
</body>
</html>