<?php
session_start(); // Start the session
include '../../db_connect.php'; // Include the database connection file

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
                window.location.href = "returnCar.php";
      
          </script>';
        }
        else
        {
            $sql1 = "SELECT * FROM Current_Renting WHERE plate_number = '$platenumber';";
            $result = $conn->query($sql1);

            if($result !== FALSE)
            {
                //if the plate number does not exist in the DB.
                if($conn->affected_rows == 0)
                {
                    echo '<script type="text/javascript">
                    var userResponse = confirm("This car is not currently rented, it is active!");
                        window.location.href = "returnCar.php";
                  
                  </script>';
                }
                else
                {   
                    $row = $result->fetch_assoc();
                    $reservedate = $row['reserve_date'];
                    $pickupdate = $row['pick_up_date'];
                    $customerid = $row['customer_id'];
                    date_default_timezone_set("Africa/Cairo");
                    $returndate = date("Y-m-d");
                    $sql2 = "DELETE FROM Current_Renting WHERE plate_number = '$platenumber';";
                    $query1 = "INSERT INTO Reservation_History VALUES($platenumber , $customerid , $reservedate , $returndate , $pickupdate );";
                    $query2 = "UPDATE car SET car_status = 'active' where (plate_number = '$platenumber'); ";
                    if($conn->query($sql2) == TRUE && $conn->query($query1) == TRUE && $conn->query($query2) == TRUE)
                    {
                    echo '<script type="text/javascript">
                    var userResponse = confirm("The car is successfully returned!");
                        window.location.href = "returnCar.php";
                  
                  </script>'; 
                    }
                    else{
                        echo "Error in delete or insert query!";
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

$conn->close(); // Close the database connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Car Page</title>
    <link rel="stylesheet" href="returnCar.css">
</head>
<body>
<header>
        <h1>Car Rental System</h1>
    </header>
 <main>
  
    <div class="form-container">
        <form id="returncar-form" method = "post" action = "returnCar.php">
                <label for="car-plate-number">Enter Plate Number:</label>
                <input type="text" id="car-plate-number" name="car-plate-number" required>

                <button type="submit">Confirm return</button>
    </form>
</div>

</main>
    <footer>
        <p>&copy; 2023 Car Rental System</p>
    </footer>

</body>
</html>