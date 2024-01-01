<?php
session_start(); // Start the session
include '../../db_connect.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $platenumber = $_POST['car-plate-number'];

    //Check Car is not rented
    $sql = "SELECT * from Current_Renting where plate_number = $platenumber";
    $result1 = $conn->query($sql);

    if($result1->num_rows != 0){
        echo '<script type="text/javascript">
        var userResponse = confirm("Cannot Delete a Currently Rented Car !");
            window.location.href = "deleteCar.php";
        
      </script>';
      exit;
    }
    

    //Check Car is not already deleted
    $sql = "SELECT * from Car where date_deleted IS NOT NULL and plate_number = $platenumber";
    $result2 = $conn->query($sql);

    if($result2->num_rows != 0){
        echo '<script type="text/javascript">
        var userResponse = confirm("Cannot Delete an already Deleted Car !");
            window.location.href = "deleteCar.php";
        
      </script>';
      exit;

    }
    



    $sql = "UPDATE car SET car_status = 'out of service' , date_deleted = CURRENT_TIMESTAMP  where (plate_number = '$platenumber' and car_status != 'out of service');";
    if($conn->query($sql) === TRUE)
    {
        //if the plate number does not exist in the DB.
        if($conn->affected_rows == 0)
        {
            echo '<script type="text/javascript">
            var userResponse = confirm("This car plate number does not exist in the database, So it is not deleted!");
                window.location.href = "deleteCar.php";
            
          </script>';
        }

        else
        {
            echo '<script type="text/javascript">
            var userResponse = confirm("The car is successfully deleted!");
                window.location.href = "deleteCar.php";
            
          </script>';
        }
    }
     else {
        echo "The car is not deleted!";
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
    <title>Delete Car Page</title>
    <link rel="stylesheet" href="deleteCar.css">
</head>
<body>
 <main>
    <header>
        <h1>Car Rental System</h1>
    </header>

    <div class="form-container">
        <form id="deletecar-form" method = "post" action = "deleteCar.php">
                <label for="car-plate-number">Enter Plate Number:</label>
                <input type="text" id="car-plate-number" name="car-plate-number" required>

                <button type="submit">Delete Car</button>
    </form>
</div>

</main>
    <footer>
        <p>&copy; 2023 Car Rental System</p>
    </footer>

</body>
</html>