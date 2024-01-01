<?php
include '../../db_connect.php';

$start_date = '"' . $_GET['start_date'] . '"';
$end_date = '"' . $_GET['end_date'] . '"';

$payments = [];

$sql = "SELECT * FROM Payment where payment_date >= $start_date and  payment_date <= $end_date";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $payments[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Payments</title>
    <link rel="stylesheet" href="viewPayments.css">
</head>
<body>
 <main>
    <header>
        <h1>Car Rental System</h1>
        <h2>All Payments</h2>
    </header>

    <div class="payments-grid">
    <?php foreach ($payments as $payment): ?>
        <div class="payment-card">
            <p><strong>Amount:</strong> <span><?php echo $payment['amount']; ?></span></p>
            <p><strong>Payment Type:</strong> <span><?php echo $payment['payment_type']; ?></span></p>
            <p><strong>Payment Date:</strong> <span><?php echo $payment['payment_date']; ?></span></p>
            <p><strong>Number of days:</strong> <span><?php echo $payment['number_of_days']; ?></span></p>
            <p><strong>Plate Number:</strong> <span><?php echo $payment['plate_number']; ?></span></p>
            <p><strong>Customer Id:</strong> <span><?php echo $payment['customer_id'] ?></span></p>
        </div>
    <?php endforeach; ?>
</div>
</main>
    <footer>
        <p>&copy; 2023 Car Rental System</p>
    </footer>

</body>
</html>