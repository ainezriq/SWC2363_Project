<?php
session_start();
include('header.php');

// Connection to the server
$connect = mysqli_connect("localhost", "root", "", "anthea");

if (!$connect) {
    die('ERROR: ' . mysqli_connect_error());
}

if (isset($_POST['signin'])) {
    // Capture form data
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);

    // Query to check if admin exists
    $query = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($connect, $query);
    
    if (mysqli_num_rows($result) == 1) {
        // Successful login
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['username'] = $username; // Store username in session

        // Redirect to admin dashboard
        header('Location: admin_dashboard.php');
        exit();
    } else {
        // If credentials are incorrect
        $_SESSION['message'] = "Invalid username or password!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sign In</title>
    <link rel="stylesheet" href="antheas.css">
</head>
<body>
    <header>
        <div class="menu-panel" onclick="toggleMenu()">&#9776;</div>
        <div class="logo">
            <a href="index.php">
                <img src="./images/antheaLogo3.png" alt="Anthea Logo">
            </a>
        </div>
        <div class="cart" onclick="toggleCart()">&#128722;<span id="cartCount">0</span></div>
    </header>

    <div class="signin-container">
        <h2>Admin Sign In</h2>
        <form action="signin.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>

            <button type="submit" name="signin" class="btn">Sign In</button>
        </form>

        <?php
        // Display error message if login fails
        if (isset($_SESSION['message'])) {
            echo "<p class='error'>" . $_SESSION['message'] . "</p>";
            unset($_SESSION['message']); // Clear message after display
        }
        ?>
    </div>
</body>
</html>
