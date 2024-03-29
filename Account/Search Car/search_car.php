<?php
session_start(); // Start the session
include '../../db_connect.php'; // Include the database connection file

// Fetch office Locations
$office_locations = [];
$sql = "SELECT * FROM Office";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $office_locations[] = $row;
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="search_car.css">
    <title>Rent a Car</title>
    <script>
        function validateForm() {
            var maxPrice = document.getElementById("max-price").value;
            if (maxPrice < 0) {
                alert("Max price must be a positive number");
                location.reload();
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <main>
        <header>
            <h1>Please Choose Car Specifications</h1>
        </header>

        <form action="../Search Results/search_results.php" method="GET" onsubmit="return validateForm()">
            <label for="car-transmission">Transmission Type:</label>
            <select id="car-transmission" name="Manual/Auto">
                <option value="">Any</option>
                <option value="manual">Manual</option>
                <option value="auto">Automatic</option>
            </select>

            <label for="colors">Available Colors:</label>
            <select id="colors" name="colors">
                <option value="">Any Color</option>
                <?php
                $sql = "SELECT distinct color FROM Car";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    // Output data for each row
                    while ($row = $result->fetch_assoc()) {
                        // Create options for the dropdown menu
                        echo "<option value='" . $row['color'] . "'>" . $row['color'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No items found</option>";
                }
                ?>
            </select>

            <label for="manufacturers">Available Manufacturers:</label>
            <select id="manufacturers" name="manufacturers">
                <option value="">Any Manufacturer</option>
                <?php
                $sql = "SELECT DISTINCT manufacturer FROM Car";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    // Output data for each row
                    while ($row = $result->fetch_assoc()) {
                        // Create options for the dropdown menu
                        echo "<option value='" . $row['manufacturer'] . "'>" . $row['manufacturer'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No items found</option>";
                }
                ?>
            </select>

            <label for="years">Produced After:</label>
            <select id="years" name="years">
                <option value="">Any Year</option>
                <?php
                $sql = "SELECT DISTINCT year_produced FROM Car ORDER BY year_produced";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    // Output data for each row
                    while ($row = $result->fetch_assoc()) {
                        // Create options for the dropdown menu
                        echo "<option value='" . $row['year_produced'] . "'>" . $row['year_produced'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No items found</option>";
                }
                ?>
            </select>

            <label for="max-price">Max Price per Day:</label>
            <input type="number" id="max-price" name="max-price" placeholder="Enter maximum price">
            <label for="car-office-loc">Office Location:</label>
            <select id="car-office-loc" name="car-office-loc">
                <option value="">Any Location</option>
                <?php
                foreach ($office_locations as $office_location) {
                    echo "<option value='" . $office_location["office_id"] . "'>" ."Office Number " 
                    .$office_location["office_id"].": " .$office_location["country"].", " .$office_location["city"] . "</option>";
                }
                ?>
            </select>

            <br>
            <br>

            <button type="submit">Search</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2023 Car Rental System</p>
    </footer>

</body>

</html>