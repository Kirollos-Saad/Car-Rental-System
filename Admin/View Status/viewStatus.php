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
}

$date = '"' . $_GET['date'] . '"';
/*
old query
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
*/ 
//Get Out of Service Cars
$out_of_service = [];
$sql = "SELECT * FROM Car WHERE date_deleted IS NOT NULL AND $date >= date_deleted"; //Switch to query below it once date added gets added
//$sql = "SELECT * FROM Car WHERE (date_deleted IS NOT NULL AND $date >= date_deleted) or $date < date_added";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $out_of_service[] = $row;
    }
}


//Rented Cars

$rented = [];
$sql = "SELECT Car.* FROM (Reservation_History natural join Car) WHERE $date >= reserve_date and  $date <= return_date 
            UNION
            SELECT Car.* FROM (Current_Renting natural join Car) WHERE $date >= reserve_date ";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rented[] = $row;
    }
}


//Available Cars

$available = [];

$sql = "SELECT * FROM Car where plate_number not IN 
    (
        SELECT plate_number FROM Car WHERE date_deleted IS NOT NULL AND $date >= date_deleted

        UNION 

        SELECT plate_number FROM (Reservation_History natural join Car) WHERE $date >= reserve_date and  $date <= return_date 

        UNION

        SELECT plate_number FROM (Current_Renting natural join Car) WHERE $date >= reserve_date 
    )

";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $available[] = $row;
    }
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
        <div class="car-status-grid">
            <h3>Out of Service</h3>
            <div class="cars-grid">
                <?php foreach ($out_of_service as $car): ?>
                    <div class="car-card">
                        <img src="<?php echo $car['image_path']; ?>" alt="Car Image">
                        <p><strong>Plate Number:</strong> <span>
                                <?php echo $car['plate_number']; ?>
                            </span></p>
                        <p><strong>Status:</strong> <span>
                                <?php echo "Out of Service"; ?>
                            </span></p>

                    </div>
                <?php endforeach; ?>
            </div>

            <h3>Rented</h3>
            <div class="cars-grid">
                <?php foreach ($rented as $car): ?>
                    <div class="car-card">
                        <img src="<?php echo $car['image_path']; ?>" alt="Car Image">
                        <p><strong>Plate Number:</strong> <span>
                                <?php echo $car['plate_number']; ?>
                            </span></p>
                        <p><strong>Status:</strong> <span>
                                <?php echo "Rented"; ?>
                            </span></p>

                    </div>
                <?php endforeach; ?>
            </div>


            <h3>Available</h3>
            <div class="cars-grid">
                <?php foreach ($available as $car): ?>
                    <div class="car-card">
                        <img src="<?php echo $car['image_path']; ?>" alt="Car Image">
                        <p><strong>Plate Number:</strong> <span>
                                <?php echo $car['plate_number']; ?>
                            </span></p>
                        <p><strong>Status:</strong> <span>
                                <?php echo "Avaiable"; ?>
                            </span></p>

                    </div>
                <?php endforeach; ?>
            </div>
        </div>


    </main>
    <footer>
        <p>&copy; 2023 Car Rental System</p>
    </footer>

</body>

</html>