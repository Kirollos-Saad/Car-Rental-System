<?php
session_start(); 
include '../../db_connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $platenumber = $_POST['car-plate-number'];

    $checkCarExistSql = "SELECT * FROM car WHERE plate_number = '$platenumber';";
    $carExistResult = $conn->query($checkCarExistSql);

    if($carExistResult !== FALSE)
    {
        if($conn->affected_rows == 0)
        {
            echo '<script type="text/javascript">
            var userResponse = confirm("This car plate number does not exist in the database!");
                window.location.href = "pickupCar.php";
      
          </script>';
        }
        else
        {
            $carRow = $carExistResult->fetch_assoc();
            if($carRow['car_status'] == 'out of service') {
                echo '<script type="text/javascript">
                var userResponse = confirm("This car is currently out of service!");
                    window.location.href = "pickupCar.php";
              
              </script>';
            } else {
                $sql1 = "SELECT * FROM Current_Renting WHERE plate_number = '$platenumber' and pick_up_date is NULL;";
                $result = $conn->query($sql1);

                if($result !== FALSE)
                {
                    //if the plate number does not exist in the DB or pickup date is already set.
                    if($conn->affected_rows == 0)
                    {
                        echo '<script type="text/javascript">
                        var userResponse = confirm("Pickup already exists for this car or the car is not currently rented!");
                            window.location.href = "pickupCar.php";
                      
                      </script>';
                    }
                    else
                    {   
                        date_default_timezone_set("Africa/Cairo");
                        $currentDate = '"' .date("Y-m-d"). '"';
                        $sql2 = "UPDATE Current_Renting SET pick_up_date = $currentDate where (plate_number = '$platenumber' and pick_up_date is NULL);";
                        if($conn->query($sql2) !== FALSE)
                        {
                
                        echo '<script type="text/javascript">
                        var userResponse = confirm("The car is successfully picked up!");
                            window.location.href = "pickupCar.php";
                      
                      </script>'; 
                        }
                        else{
                            echo "Error in delete or insert query!";
                            echo "Error: " . $sql2 . "<br>" . $conn->error;
                        }
                    }
                }
                else {
                    echo "The car is not deleted!";
                    echo "Error: " . $sql1 . "<br>" . $conn->error;
                    
                }
            }
        }
    }
}

$conn->close(); // Close the database connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pick up Car Page</title>
    <link rel="stylesheet" href="pickupCar.css">
</head>
<body>
<header>
        <h1>Car Rental System</h1>
    </header>
 <main>
  
    <div class="form-container">
        <form id="pickupcar-form" method = "post" action = "pickupCar.php">
                <label for="car-plate-number">Enter Plate Number:</label>
                <input type="text" id="car-plate-number" name="car-plate-number" required>

                <button type="submit">Confirm pick up</button>
    </form>
</div>

</main>
    <footer>
        <p>&copy; 2023 Car Rental System</p>
    </footer>

</body>
</html>