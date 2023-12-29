<?php
include '../../db_connect.php'; // Include the database connection file

// Fetch all available cars
$cars = [];
$sql = "SELECT * FROM Car WHERE car_status = 'Active'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $cars[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Cars</title>
    <link rel="stylesheet" href="available.css">
</head>
<body>
 <main>
    <header>
        <h1>Car Rental System</h1>
        <h2>Available Cars:</h2>
    </header>

    <div class="cars-grid">
    <?php foreach ($cars as $car): ?>
        <div class="car-card">
            <!-- <img src="../../Car_images/1.jpg" alt="Car Image"> -->
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
</main>
    <footer>
        <p>&copy; 2023 Car Rental System</p>
    </footer>

</body>
</html>