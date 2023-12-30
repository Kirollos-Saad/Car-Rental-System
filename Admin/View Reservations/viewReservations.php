<?php
include '../../db_connect.php';


$start_date = '"' . $_GET['start_date'] . '"';
$end_date = '"' . $_GET['end_date'] . '"';

//These Queries Still need to be tested on some data


$returned_only = [];
//case 1:
$sql = "SELECT * FROM (reservation_history natural join customer) natural join car where reserve_date < $start_date and 
        return_date >= $start_date and return_date <= $end_date";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $returned_only[] = $row;
    }
}



$reserved_and_returned = [];
//case 2:
$sql = "SELECT * FROM (reservation_history natural join customer) natural join car where reserve_date >= $start_date and reserve_date <= $end_date 
        and return_date >= $start_date and return_date <= $end_date";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $reserved_and_returned[] = $row;
    }
}




$reserved_only = [];
//case 3: 
//get reserve date only from reservation history and current renting to make the union as they are different columns.
$sql = "SELECT car.*, customer.*, reserve_date  FROM (reservation_history natural join customer) natural join car where reserve_date <= $end_date 
        and return_date > $end_date
        UNION
        SELECT car.*, customer.*, reserve_date  FROM (Current_Renting natural join customer) natural join car where reserve_date <= $end_date ";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $reserved_only[] = $row;
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
            <h3>Returned Only</h3>
            <div class="returned-only-grid">
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
        </div>
    </main>
    <footer>
        <p>&copy; 2023 Car Rental System</p>
    </footer>

</body>

</html>