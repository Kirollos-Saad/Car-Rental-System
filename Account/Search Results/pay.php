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
    $currentTimestamp = date("Y-m-d H:i:s"); 

    $sql = "INSERT INTO Payment (amount, payment_type, payment_date, number_of_days, plate_number, customer_id)
     VALUES   ('$total_payment', '$payment_type', '$currentTimestamp', '$number_days', '$plate_number', '$customer_id')";
    $conn->query($sql);

    header("Location: ../account.php");

}
?>
