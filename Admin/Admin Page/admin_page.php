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
        <h1>Office:</h1>
        <h2><?php echo "$office_country, $office_city"; ?></h2>
    </header>

    <section class="centered-section">
       <a href="admin_page.php" class="button">Add a Car</a> 
        <a href="admin_page.php" class="button">Delete a Car</a>
        <a href="admin_page.php" class="button">View Car Status</a>
        <a href="admin_page.php" class="button">View Reservations</a>
        <a href="admin_page.php" class="button">View Customer</a>
        <a href="admin_page.php" class="button">View Payments</a>
    </section>
</main>
    <footer>
        <p>&copy; 2023 Car Rental System</p>
    </footer>

</body>
</html>
