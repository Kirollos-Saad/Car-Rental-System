<?php
include '../../db_connect.php'; // Include the database connection file

// Fetch all cars regarding of their status
$customers = [];
$sql = "SELECT * FROM customer ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $customers[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Customers</title>
    <link rel="stylesheet" href="viewCustomers.css">
</head>
<body>
 <main>
    <header>
        <h1>Car Rental System</h1>
        <h2>All Customers</h2>
    </header>

    <div class="customers-grid">
    <?php foreach ($customers as $customer): ?>
        <div class="customer-card">
            <p><strong>Customer Id:</strong> <span><?php echo $customer['customer_id']; ?></span></p>
            <p><strong>Email:</strong> <span><?php echo $customer['email']; ?></span></p>
            <p><strong>Phone:</strong> <span><?php echo $customer['phone']; ?></span></p>
            <p><strong>Customer Name:</strong> <span><?php echo $customer['customer_name']; ?></span></p>
            <p><strong>Country:</strong> <span><?php echo $customer['country'] ?></span></p>
            <p><strong>City:</strong> <span><?php echo $customer['city']; ?></span></p>
        </div>
    <?php endforeach; ?>
</div>
</main>
    <footer>
        <p>&copy; 2023 Car Rental System</p>
    </footer>

</body>
</html>