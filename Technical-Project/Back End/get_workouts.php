<?php
// Include database connection
require_once 'db.php';

// Initialize variables
$workouts = [];
$conn = mysqli_connect( "localhost", "root",  "",  "smart_gym"); 

$sql = "SELECT workout_name, workout_description, type FROM workouts";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch all workouts
    while ($row = $result->fetch_assoc()) {
        $workouts[] = $row;
    }
} else {
    echo "No workouts found.";
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workouts</title>
</head>
<body>
    <h1>Workouts</h1>
    <ul>
        <?php foreach ($workouts as $workout): ?>
            <li>
                <h3><?php echo htmlspecialchars($workout['workout_name']); ?></h3>
                <p>Type: <?php echo htmlspecialchars($workout['workout_type']); ?></p>
                <p><?php echo htmlspecialchars($workout['workout_description']); ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>