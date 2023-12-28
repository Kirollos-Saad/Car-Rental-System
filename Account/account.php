<?php
session_start(); // Start the session

// Check if user data exists in the session
if (isset($_SESSION['user_email']) && isset($_SESSION['user_name'])) {
    $userEmail = $_SESSION['user_email'];
    $userName = $_SESSION['user_name'];
} else {
    // Redirect to signin.html or handle the case where user data is not available in the session
    header("Location: signin.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <link rel="stylesheet" href="account.css">
</head>
<body>
 <main>
    <header>
        <h1><?php echo $userName; ?></h1>
    </header>

    <section class="centered-section">
       <a href="account.php" class="button">Rent a Car</a> 
        <a href="account.php" class="button">Currently Rented</a>
    </section>
</main>
    <footer>
        <p>&copy; 2023 Car Rental System</p>
    </footer>

</body>
</html>
