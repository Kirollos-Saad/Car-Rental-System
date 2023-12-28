<?php
session_start(); 
include '../db_connect.php'; // Include the database connection file

// Retrieve email and password from the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['admin-email'];
    $password =md5 ($_POST['admin-password']);

    
    $sql = "SELECT * FROM Admin WHERE email='$email' AND password_hash='$password'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // Fetch user data
        $adminData = $result->fetch_assoc();
        
        // Store user data in session variables
        $_SESSION['admin_email'] = $adminData['email'];
        $_SESSION['admin_office'] = $adminData['office_id'];

        header("Location: Admin Page/admin_page.php");
        //exit();
    } else {
        header("Location: admin.html?login=failed");
        //exit();
    }
}

$conn->close(); // Close the database connection
?>