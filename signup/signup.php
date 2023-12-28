<?php
include '../db_connect.php'; // Include the database connection file

// Test database connection
$sql = "SELECT * FROM Customer LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Database connection successful.";
} else {
    echo "Database connection failed: " . $conn->error;
}

$conn->close(); // Close the database connection
?>