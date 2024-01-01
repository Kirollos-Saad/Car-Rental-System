<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // Start the session
include '../../db_connect.php'; // Include the database connection file

// Check if user data exists in the session
if (isset($_SESSION['admin_email']) && isset($_SESSION['admin_office'])) {
    // Check if start_date and end_date GET parameters are set
    if (!isset($_GET['start_date']) || !isset($_GET['end_date'])) {
        echo "Start date or end date not set";
        exit();
    }

    $office = $_SESSION['admin_office'];
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];

    $sql = "SELECT Car.plate_number, Car.car_status, Car.image_path, Current_Renting.reserve_date, Reservation_History.return_date 
            FROM Car 
            LEFT JOIN Current_Renting ON Car.plate_number = Current_Renting.plate_number 
            LEFT JOIN Reservation_History ON Car.plate_number = Reservation_History.plate_number 
            WHERE Car.office_id = ? AND ((Current_Renting.reserve_date BETWEEN ? AND ?) OR (Reservation_History.return_date BETWEEN ? AND ?))";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $office, $start_date, $end_date, $start_date, $end_date);
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
                            <?php echo $car['car_status']; ?>
                        </span></p>
                    <p><strong>Reserved On:</strong> <span>
                            <?php echo $car['reserve_date']; ?>
                        </span></p>
                    <p><strong>Returned On:</strong> <span>
                            <?php echo $car['return_date']; ?>
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