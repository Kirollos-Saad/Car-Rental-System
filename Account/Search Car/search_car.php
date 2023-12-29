<?php
session_start(); // Start the session
include '../../db_connect.php'; // Include the database connection file
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="search_car.css">
    <title>Rent a Car</title>
</head>

<body>
    <main>
        <header>
            <h1>Please Choose Car Specifications</h1>
        </header>

        <form action="../Search Results/search_results.php" method="GET">
        <label for="car-transmission">Transmission Type:</label>
<select id="car-transmission" name="Manual/Auto" >
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

            <label for="years">Produced Afer:</label>
            <select id="years" name="years">
                <option value="">Any Year</option>
                <?php
                // Your database connection code here (assume $conn is your database connection)
                
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