<?php
// Include database connection
require_once 'db.php';

// Initialize variables
$diet_plans = [];
$conn = mysqli_connect( "localhost", "root",  "",  "smart_gym"); 

$sql = "SELECT plan_name, diet_description, body_type FROM diet_plans";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch all diet plans
    while ($row = $result->fetch_assoc()) {
        $diet_plans[] = $row;
    }
} else {
    echo "No diet plans found.";
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diet Plans</title>
</head>
<body>
    <h1>Diet Plans</h1>
    <ul>
        <?php foreach ($diet_plans as $diet): ?>
            <li>
                <h3><?php echo htmlspecialchars($diet['plan_name']); ?></h3>
                <p>Body Type: <?php echo htmlspecialchars($diet['body_type']); ?></p>
                <p><?php echo htmlspecialchars($diet['diet_description']); ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>