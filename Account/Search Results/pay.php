<?php
session_start(); 
include '../../db_connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userEmail = $_SESSION['user_email'];
    $plate_number = $_POST['plate_number'];
    $total_payment = $_POST['total_price_input'];
    $payment_type = $_POST['payment_options'];
    $number_days = $_POST['rent_days'];
    $sql = "SELECT customer_id FROM Customer where email = '$userEmail'";
    $customer = $conn->query($sql)->fetch_assoc();
    $customer_id = $customer['customer_id'];
    date_default_timezone_set('Africa/Cairo'); // Set timezone to 'Africa/Cairo'
    $currentTimestamp = date("Y-m-d H:i:s"); 

    $sql = "INSERT INTO Payment (amount, payment_type, payment_date, number_of_days, plate_number, customer_id)
     VALUES   ('$total_payment', '$payment_type', '$currentTimestamp', '$number_days', '$plate_number', '$customer_id')";
    $conn->query($sql);

    $sql = "UPDATE Car SET car_status = 'Rented' WHERE plate_number = '$plate_number'";
    $conn->query($sql);

    // Insert into Current_Renting table
    $sql = "INSERT INTO Current_Renting (plate_number, customer_id, reserve_date, pick_up_date)
     VALUES ('$plate_number', '$customer_id', '$currentTimestamp', '$currentTimestamp')";
    $conn->query($sql);

    echo "<script type='text/javascript'>alert('Payment was successful!'); window.location.href = '../account.php';</script>";
}
?>