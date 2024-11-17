<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session at the top of header.php
}

// Check if the user is already logged in as admin
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    echo "<header><h1>Welcome," . htmlspecialchars($_SESSION['username']) . "!</h1>";
    echo "<p><a href='handbags.php'>Manage Handbags</a> | <a href='accessories.php'>Manage Jewelry</a> | <a href='logout.php'>Logout</a></p>";
} elseif (isset($_SESSION['guest_logged_in']) && $_SESSION['guest_logged_in'] === true) {
    // If the user has chosen to continue as a guest, display a welcome message
    echo "<header><h1>Welcome to Anthea!</h1>";
    echo "<p>Your one-stop destination for luxury bags and accessories.</p>";
} else {
    // If not logged in as admin and not continued as a guest, show standard header with login options
    echo "<header><p><a href='signin.php'>Sign in as Admin</a> | <a href='index.php' onclick='setGuestSession()'>Continue as Guest</a></p>";
}

echo "</header>";
?>

<script>
function setGuestSession() {
    // Use AJAX to set a session variable for guest login without reloading the page
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "set_guest_session.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("guest_logged_in=true");
}
</script>
