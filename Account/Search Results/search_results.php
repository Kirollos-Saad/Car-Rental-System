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
    $cars = $conn->query($sql);

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Results</title>
    <link rel="stylesheet" href="search_results.css">
</head>

<body>
    <h1>Car Details</h1>
    <div id="carDetails"></div>

    <p>
        <?php

        if ($cars->num_rows == 0) {
            echo "No Results Found";
        }
        ?>
    </p>


    <div class="cars-grid">
    <?php foreach ($cars as $car): ?>
        <div class="car-card">
            <img src="<?php echo $car['image_path']; ?>" alt="Car Image">
            <p><strong>Plate Number:</strong> <span><?php echo $car['plate_number']; ?></span></p>
            <p><strong>Model Name:</strong> <span><?php echo $car['model_name']; ?></span></p>
            <p><strong>Manufacturer:</strong> <span><?php echo $car['manufacturer']; ?></span></p>
            <p><strong>Year:</strong> <span><?php echo $car['year_produced']; ?></span></p>
            <p><strong>Color:</strong> <span style="background-color: <?php echo $car['color']; ?>; display: inline-block; width: 20px; height: 20px;"></span> <span><?php echo $car['color']; ?></span></p>
            <p><strong>Transmission:</strong> <span><?php echo $car['is_automatic'] ? 'Automatic' : 'Manual'; ?></span></p>
            <p><strong>Price per day:</strong> <span><?php echo $car['price_per_day']; ?></span></p>
        </div>
    <?php endforeach; ?>
</div>



</body>

</html>