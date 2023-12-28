<?php
session_start(); // Start the session
include '../../db_connect.php'; // Include the database connection file

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
// Retrieve data from the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $platenumber = $_POST['car-plate-number'];
    $color = $_POST['car-color'];
    $transmission = $_POST['car-transmission'];
    $price_per_day = $_POST['car-price-per-day'];
    $model_name = $_POST['car-model-name'];
    $manufacturer = $_POST['car-manufacturer'];
    $year_produced = $_POST['car-year-produced'];
    $status = $_POST['car-status'];
    $office_id = $_POST['office-id'];


    if (strtolower($transmission) !== "automaitc" || strtolower($transmission) !== "Manual" ) {
        echo "Transmission type must be either automatic or manual!";
        return;
    }

    if (strtolower($status) !== "active" || strtolower($status) !== "out of serive" || strtolower($status) !== "rented" ) {
        echo "Car Status must be either active or out of service or rented !";
        return;
    }
    

    $sql = "INSERT INTO Car (plate_number, color, is_automatic, price_per_day, model_name, manufacturer,year_produced,car_status,date_deleted,office_id,image_path)
     VALUES ('$platenumber', '$color', '$transmission', '$price_per_day', '$model_name', '$manufacturer','$year_produced','$status','NULL','$office_id','NULL')";
    if ($conn->query($sql) === TRUE) {
        echo "The car is inserted successfully.";
        header("Location: ../Admin Page/admin_page.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
    //header("Location: admin_page.php");
    //exit();
    $conn->close(); // Close the database connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Car Page</title>
    <link rel="stylesheet" href="addCar.css">
</head>
<body>
 <main>
    <header>
        <h1>Car Rental System</h1>
        <h2>Enter Car Specifications:</h2>
    </header>

    <form id="addcar-form">
            <label for="car-plate-number">Plate Number:</label>
            <input type="text" id="car-plate-number" name="signin-car-plate-number" required>

            <label for="car-color">Color:</label>
            <input type="text" id="car-color" name= "car-color" required>

            <label for="car-transmission">Transmission Type:</label>
            <select id="car-transmission" name="car-transmission" required>
            <option value=""></option>
            <option value="Automatic">Automatic</option>
            <option value="Manual">Manual</option>
            </select>

            <label for="car-price-per-day">Price per day:</label>
            <input type="text" id="car-price-per-day" name= "car-price-per-day" required>

            <label for="car-model-name">Model Name:</label>
            <input type="text" id="car-model-name" name= "car-model-name" required>

            <label for="car-manufacturer">Manufacturer:</label>
            <input type="text" id="car-manufacturer" name= "car-manufacturer" required>

            <label for="car-year-produced">Year Produced:</label>
            <input type="text" id="car-year-produced" name= "car-year-produced" required>

            <label for="car-status">Car Status:</label>
            <select id="car-status" name="car-status" required>
            <option value=""></option>
            <option value="Active">Active</option>
            <option value="Out of service">Out of service</option>
            <option value="Rented">Rented</option>
        </select>

            <label for="car-office-id">Office Id:</label>
            <input type="text" id="car-office-id" name= "car-office-id" required>

            <label for="car-image-path">Car Image Path:</label>
            <input type="text" id="car-image-path" name= "car-image-path" required>

            <button type="submit">Add Car</button>
        </form>
</main>
    <footer>
        <p>&copy; 2023 Car Rental System</p>
    </footer>

</body>
</html>