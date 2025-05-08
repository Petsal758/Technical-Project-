<?php

$conn = mysqli_connect( "localhost", "root",  "",  "smart_gym"); 

if (!isset($conn) || !$conn instanceof mysqli) {
    die("Database connection error.");
}

// Get the search query
$query = trim($_GET['query']);

// Sanitize input
$query = htmlspecialchars($query);

// Prepare the SQL query
$sql = "SELECT workout_name, workout_description FROM workouts WHERE workout_type = 'Chest|chest|chests|Chests' AND workout_name LIKE ? OR workout_description LIKE ?";
$searchTerm = '%' . $query . '%';
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

// Display results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='workout-card'>";
        echo "<h3>" . htmlspecialchars($row['workout_name']) . "</h3>";
        echo "<p>" . htmlspecialchars($row['workout_description']) . "</p>";
        echo "</div>";
    }
} else {
    echo "<p>No workouts found matching your search query.</p>";
}

// Close connection
$stmt->close();
$conn->close();
?>