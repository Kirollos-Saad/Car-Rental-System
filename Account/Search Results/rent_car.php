<?php

session_start(); // Start the session
include '../../db_connect.php'; // Include the database connection file

if (isset($_GET['plate_number'])) {

    $plateNumber = $_GET['plate_number'];

    $sql = "SELECT * FROM Car where plate_number = $plateNumber";
    $car = $conn->query($sql)->fetch_assoc();
    $is_automatic = $car['is_automatic']; // Assuming this variable holds your value

    // Set $transmission_type based on the value of $is_automatic
    if ($is_automatic) {
        $transmission_type = "Automatic";
    } else {
        $transmission_type = "Manual";
    }

    $office_id = $car['office_id'];

    $sql = "SELECT country, city FROM Office where office_id = $office_id";
    $office_location = $conn->query($sql)->fetch_assoc();

} else {
    header("Location: search_results.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent Car Details</title>
    <link rel="stylesheet" href="rent_car.css">
</head>

<body>
    <header>
        <h1>Car Rental System</h1>
        <h2>Rent Car</h2>
    </header>
    <main>
        <div class="carDetails">
            <div class="car-card">
                <div class="image-container">
                    <img src="<?php echo $car['image_path']; ?>" alt="Car Image">
                </div>
                <div class="car-info">
                    <p><strong>Plate Number:</strong> <span>
                            <?php echo $car['plate_number']; ?>
                        </span></p>
                    <p><strong>Manufacturer:</strong> <span>
                            <?php echo $car['manufacturer']; ?>
                        </span></p>
                    <p><strong>Model Name:</strong> <span>
                            <?php echo $car['model_name']; ?>
                        </span></p>
                    <p><strong>Color:</strong> <span>
                            <?php echo $car['color']; ?>
                        </span></p>
                    <p><strong>Transmission Type:</strong> <span>
                            <?php echo $transmission_type; ?>
                        </span></p>

                    <p><strong>Price Per Day:</strong> <span>
                            <?php echo '$' . $car['price_per_day']; ?>
                        </span></p>
                    <p><strong>Year Produced:</strong> <span>
                            <?php echo $car['year_produced']; ?>
                        </span></p>
                    <p><strong>Office Location:</strong> <span>
                            <?php echo $office_location['country'] . ',' . $office_location['city']; ?>
                        </span></p>


                </div>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; 2023 Car Rental System</p>
    </footer>
</body>

</html>