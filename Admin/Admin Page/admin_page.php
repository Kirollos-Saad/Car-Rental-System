<?php
session_start(); // Start the session
include '../../db_connect.php'; // Include the database connection file

// Check if user data exists in the session
if (isset($_SESSION['admin_email']) && isset($_SESSION['admin_office'])) {
    $office = $_SESSION['admin_office'];
    $sql = "SELECT * FROM Office WHERE office_id='$office'";
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
    <title>Admin Page</title>
    <link rel="stylesheet" href="admin_page.css">
</head>
<body>
 <main>
    <header>
        <h1>Car Rental System</h1>
        <h2>Office:</h2>
        <h2><?php echo "$office_country, $office_city"; ?></h2>
    </header>

    <section class="centered-section">
       <a href="../Add Car Page/addCar.php" class="button">Add a Car</a> 
        <a href="../Delete Car Page/deleteCar.php" class="button">Delete a Car</a>
        <a href="../Available Cars/available.php" class="button">View all available cars</a>
        <a href="../All Cars/all.php" class="button">View All Cars </a>
        <a href="../Customer History/history.php" class="button">Customer Rental History All Cars </a>
        <a href="../view reservations/viewReservations.html" class="button">View Reservations</a>
        <a href="../view Customers/viewCustomers.php" class="button">View Customer</a>
        <a href="../view Payments/viewPayments.html" class="button">View Payments</a>
        <a href="../view Status/viewStatus.html" class="button">View Cars Status</a>
        <a href="../Return Car/returnCar.php" class="button">Return Car</a>
    </section>
</main>
    <footer>
        <p>&copy; 2023 Car Rental System</p>
    </footer>

</body>
</html>
