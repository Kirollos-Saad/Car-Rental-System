<?php
include '../../db_connect.php'; // Include the database connection file

// Fetch office IDs
$office_ids = [];
$sql = "SELECT office_id FROM Office";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $office_ids[] = $row["office_id"];
    }
}

// Retrieve data from the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $platenumber = $_POST['car-plate-number'];
    $color = $_POST['car-color'];
    $transmission_type = $_POST['car-transmission'];
    if ($transmission_type == "Automatic") {
        $is_automatic = 1;
    } else {
        $is_automatic = 0;
    }

    $price_per_day = $_POST['car-price-per-day'];
    $model_name = $_POST['car-model-name'];
    $manufacturer = $_POST['car-manufacturer'];
    $year_produced = $_POST['car-year-produced'];
    $status = $_POST['car-status'];
    $office_id = $_POST['office-id'];
    $image_path = $_POST['car-image-path'];

    $getDuplicate = "SELECT * FROM car where plate_number = '$platenumber' ";
    $check = $conn->query($getDuplicate);
    if ($check->num_rows !== 0){
        echo '<script type="text/javascript"> confirm("Plate Numbers cannot be Duplicated!");
                window.location.href = "addCar.php";
              </script>';
    }
    $sql = "INSERT INTO Car (plate_number, color, is_automatic, price_per_day, model_name, manufacturer,year_produced,car_status,date_deleted,office_id,image_path, date_added)
     VALUES ('$platenumber', '$color', '$is_automatic', '$price_per_day', '$model_name', '$manufacturer','$year_produced','$status',NULL,'$office_id','$image_path', NOW())";
    if ($conn->query($sql) === TRUE) {
        //echo "The car is inserted successfully.";
       header("Location: ../Available Cars/available.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

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

    <form id="addcar-form" method="post">
            <label for="car-plate-number">Plate Number:</label>
            <input type="text" id="car-plate-number" name="car-plate-number" required>

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
            <option value="Active">Active</option>
         </select>
       
    <label for="car-office-id">Office Id:</label>
    <select id="car-office-id" name="office-id" required>
    <option value="">office_Id</option>
    <?php
    foreach ($office_ids as $office_id) {
        echo "<option value='" . $office_id . "'>" . $office_id . "</option>";
    }
    ?>
    </select>

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
<?php
