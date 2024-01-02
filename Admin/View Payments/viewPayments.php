<?php
include '../../db_connect.php';

$start_date = '"' . $_GET['start_date'] . '"';
$end_date = '"' . $_GET['end_date'] . '"';

$payments = [];

$sql = "SELECT DATE(payment_date) AS payment_day, SUM(amount) AS total_amount
        FROM Payment
        WHERE DATE(payment_date) >= $start_date and  DATE(payment_date) <= $end_date
        GROUP BY DATE(payment_date);";

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
                    <p><strong>Day:</strong> <span>
                            <?php echo $payment['payment_day']; ?>
                        </span></p>
                    <p><strong>Total Amount:</strong> <span>
                            <?php echo $payment['total_amount']; ?>
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