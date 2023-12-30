<?php
session_start(); // Start the session
include '../../db_connect.php'; // Include the database connection file

// Check if user data exists in the session
if (isset($_SESSION['admin_email']) && isset($_SESSION['admin_office'])) {
    $office = $_SESSION['admin_office'];
    $sql = "SELECT car_status FROM car";
    $result = $conn->query($sql);
    $office_data = $result->fetch_assoc();
    $office_city = $office_data['city'];
    $office_country = $office_data['country'];

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

        <!--<div class="Active-grid">
            <h3>Active</h3>
            <div class="Rented-grid">
                <?php foreach ($returned_only as $reservation): ?>
                    <div class="reservation-card">
                        <img src="<?php echo $reservation['image_path']; ?>" alt="Car Image">
                        <p><strong>Plate Number:</strong> <span>
                                <?php echo $reservation['plate_number']; ?>
                            </span></p>
                        <p><strong>Customer Id:</strong> <span>
                                <?php echo $reservation['customer_id']; ?>
                            </span></p>
                        <p><strong>Returned On:</strong> <span>
                                <?php echo $reservation['return_date']; ?>
                            </span></p>

                    </div>
                <?php endforeach; ?>
            </div>

            <h3>Rented & Returned</h3>
            <div class="reserved-and-returned-grid">
                <?php foreach ($reserved_and_returned as $reservation): ?>
                    <div class="reservation-card">
                        <img src="<?php echo $reservation['image_path']; ?>" alt="Car Image">
                        <p><strong>Plate Number:</strong> <span>
                                <?php echo $reservation['plate_number']; ?>
                            </span></p>
                        <p><strong>Customer Id:</strong> <span>
                                <?php echo $reservation['customer_id']; ?>
                            </span></p>

                        <p><strong>Reserved On:</strong> <span>
                                <?php echo $reservation['reserve_date']; ?>
                            </span></p>
                        <p><strong>Returned On:</strong> <span>
                                <?php echo $reservation['return_date']; ?>
                            </span></p>
                    </div>
                <?php endforeach; ?>
            </div>

            <h3>Rented Only</h3>
            <div class="reserved-only-grid">
                <?php foreach ($reserved_only as $reservation): ?>
                    <div class="reservation-card">
                        <img src="<?php echo $reservation['image_path']; ?>" alt="Car Image">
                        <p><strong>Plate Number:</strong> <span>
                                <?php echo $reservation['plate_number']; ?>
                            </span></p>
                        <p><strong>Customer Id:</strong> <span>
                                <?php echo $reservation['customer_id']; ?>
                            </span></p>

                        <p><strong>Reserved On:</strong> <span>
                                <?php echo $reservation['reserve_date']; ?>
                            </span></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div> -->
    </main>
    <footer>
        <p>&copy; 2023 Car Rental System</p>
    </footer>

</body>

</html>