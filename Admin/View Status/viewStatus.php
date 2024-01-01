<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // Start the session
include '../../db_connect.php'; // Include the database connection file

// Check if user data exists in the session
if (isset($_SESSION['admin_email'])) {
    // Check if date GET parameter is set
    if (!isset($_GET['date'])) {
        echo "Date not set";
        exit();
    }

    $date = $_GET['date'];
    
    $sql = "
        SELECT Car.*, 
        CASE
            WHEN (Current_Renting.plate_number IS NOT NULL AND ? BETWEEN Current_Renting.reserve_date AND IFNULL(Current_Renting.pick_up_date, ?))
            OR (Current_Renting.plate_number IS NULL AND Reservation_History.plate_number IS NOT NULL AND ? BETWEEN Reservation_History.reserve_date AND Reservation_History.return_date) THEN 'Rented'
            WHEN Car.car_status = 'Out of Service' THEN 'Out of Service'
            ELSE 'Active'
        END AS rental_status
        FROM Car 
        LEFT JOIN Current_Renting ON Car.plate_number = Current_Renting.plate_number
        LEFT JOIN Reservation_History ON Car.plate_number = Reservation_History.plate_number
    ";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $date, $date, $date);
    $stmt->execute();
    $result = $stmt->get_result();

    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $date, $date, $date);
    $stmt->execute();
    $result = $stmt->get_result();
 

    // Check if the SQL query returned any results
    if ($result->num_rows > 0) {
        $cars = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        echo "No results found";
        exit();
    }
} else {
    header("Location: ../Admin/admin.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cars Status History</title>
    <link rel="stylesheet" href="viewStatus.css">
</head>

<body>
    <main>
        <header>
            <h1>Car Rental System</h1>
            <h2>All cars status</h2>
        </header>

        <div class="car-grid">
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
                    <p><strong>Status:</strong> <span><?php echo $car['rental_status']; ?></span></p>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
    <footer>
        <p>&copy; 2023 Car Rental System</p>
    </footer>

</body>

</html>
