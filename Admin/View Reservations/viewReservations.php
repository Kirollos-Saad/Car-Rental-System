<?php
include '../../db_connect.php'; // Include the database connection file

// Fetch all cars regarding of their status
$reservations = [];
$sql = "SELECT * FROM Reservation_History ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $reservations[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations History</title>
    <link rel="stylesheet" href="viewReservations.css">
</head>
<body>
 <main>
    <header>
        <h1>Car Rental System</h1>
        <h2>All Reservations</h2>
    </header>

    <div class="reservations-grid">
    <?php foreach ($reservations as $reservation): ?>
        <div class="reservation-card">
            <p><strong>Plate Number:</strong> <span><?php echo $reservation['plate_number']; ?></span></p>
            <p><strong>Customer Id:</strong> <span><?php echo $reservation['customer_id']; ?></span></p>
            <p><strong>Reserve Date:</strong> <span><?php echo $reservation['reserve_date']; ?></span></p>
            <p><strong>Return Date:</strong> <span><?php echo $reservation['return_date']; ?></span></p>
            <p><strong>Pickup Date:</strong> <span><?php echo $reservation['pickup_date']; ?></span></p>
        </div>
    <?php endforeach; ?>
</div>
</main>
    <footer>
        <p>&copy; 2023 Car Rental System</p>
    </footer>

</body>
</html>