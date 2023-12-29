<?php

session_start(); // Start the session
include '../../db_connect.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $manual_auto = $_GET["Manual/Auto"];
    $colors = $_GET['colors'];
    $manufacturers = $_GET['manufacturers'];
    $year_produced = $_GET['years'];
    $maxPrice = $_GET['max-price'];


    // Check each parameter and add conditions accordingly
    if (empty($colors)) {
        $conditions[] = "color = color";
    } else {
        $conditions[] = "color = '$colors'";
    }

    if (!empty($manual_auto)) {
        if ($manual_auto == "auto") {
            $conditions[] = "is_automatic = TRUE";
        } else {
            $conditions[] = "is_automatic = FALSE";
        }
    }

    if (!empty($manufacturers)) {
        $conditions[] = "manufacturer = '$manufacturers'";
    }

    if (!empty($year_produced)) {
        $conditions[] = "year_produced >= '$year_produced'";
    }

    if (!empty($maxPrice)) {
        $conditions[] = "price_per_day <= $maxPrice";
    }

    // Construct the WHERE clause
    $whereClause = '';
    if (!empty($conditions)) {
        $whereClause = 'WHERE ' . implode(' AND ', $conditions);
    }

    $sql = "SELECT * FROM Car $whereClause AND car_status = 'Active'";
    $result = $conn->query($sql);

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Results</title>
</head>

<body>
    <h1>Car Details</h1>
    <div id="carDetails"></div>

    <p>
        <?php

        if ($result->num_rows == 0) {
            echo "No Results Found";
        }
        ?>
    </p>


    <script>
        // PHP array to JavaScript object conversion
        const cars = <?php
        if ($result && $result->num_rows > 0) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            echo json_encode($data);
        }
        ?>;

        // Displaying the car details as JavaScript objects
        const carDetailsContainer = document.getElementById('carDetails');
        cars.forEach(car => {
            const carDetails = document.createElement('div');
            carDetails.textContent = JSON.stringify(car);
            carDetailsContainer.appendChild(carDetails);
        });
    </script>



</body>

</html>