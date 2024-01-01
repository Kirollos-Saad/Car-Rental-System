<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // Start the session
include '../../db_connect.php'; // Include the database connection file

// Check if user data exists in the session
if (isset($_SESSION['admin_email']) && isset($_SESSION['admin_office'])) {
    // Check if date GET parameter is set
    if (!isset($_GET['date'])) {
        echo "Date not set";
        exit();
    }

    $office = $_SESSION['admin_office'];
    $date = $_GET['date'];

    $sql = "SELECT Car.plate_number, Car.car_status, Car.image_path,
            CASE
                WHEN Current_Renting.plate_number IS NOT NULL AND Current_Renting.reserve_date <= ? AND (Current_Renting.pick_up_date >= ? OR Current_Renting.pick_up_date IS NULL) THEN 'Rented'
                WHEN Car.car_status = 'Out of Service' THEN 'Out of Service'
                ELSE 'Active'
            END AS rental_status
            FROM Car 
            LEFT JOIN Current_Renting ON Car.plate_number = Current_Renting.plate_number 
            WHERE Car.office_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $date, $date, $office);
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
                    <p><strong>Plate Number:</strong> <span>
                            <?php echo $car['plate_number']; ?>
                        </span></p>
                    <p><strong>Status:</strong> <span>
                            <?php echo $car['rental_status']; ?>
                        </span></p>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
    <footer>
        <p>&copy; 2023 Car Rental System</p>
    </footer>

</body>

</html>