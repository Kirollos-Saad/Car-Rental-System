<?php
session_start(); 
include '../../db_connect.php';
$userEmail = $_SESSION['user_email'];
$sql = "SELECT customer_id FROM Customer where email = '$userEmail'"; //as email is unique in our DDl
$customer = $conn->query($sql)->fetch_assoc();
$customer_id = $customer['customer_id'];

// Fetch all rented cars for this customer
$cars = [];
// to retrieve all car columns we used Car.* instead of *
$sql = "SELECT Car.* FROM Car JOIN Current_Renting ON Car.plate_number = Current_Renting.plate_number WHERE Current_Renting.customer_id = '$customer_id'";
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
    <title>Current Rented Cars</title>
    <link rel="stylesheet" href="currentRented.css">
</head>
<body>
 <main>
    <header>
        <h1>Car Rental System</h1>
        <h2>Current Rented Cars:</h2>
    </header>

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
</main>
    <footer>
        <p>&copy; 2023 Car Rental System</p>
    </footer>

</body>
</html>