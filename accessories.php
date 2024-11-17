<?php 
session_start(); // Start the session
include('header.php'); 

// Connection to the server
$connect = mysqli_connect("localhost", "root", "", "anthea");

if (!$connect) {
    die('ERROR: ' . mysqli_connect_error());
}

// Initialize variables
$id = $name = $price = $material = $description = $image_path = '';

// Get all records
$results = mysqli_query($connect, "SELECT * FROM jewelry");

// Search functionality
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($connect, $_POST['search_query']);
    $results = mysqli_query($connect, "SELECT * FROM jewelry WHERE name LIKE '%$search%'");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ANtheA Accessories Collection</title>
    <link rel="stylesheet" href="antheas.css">
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="menu-panel" onclick="toggleMenu()" aria-label="Toggle menu">&#9776;</div> <!-- Hamburger Menu Icon -->
        
        <!-- Logo in the center-top -->
        <div class="logo">
            <a href="index.php">
                <img src="./images/antheaLogo3.png" alt="Anthea Logo">
            </a>
        </div>
        
        <div class="cart" onclick="toggleCart()" aria-label="View cart">&#128722;<span id="cartCount">0</span></div> <!-- Cart Icon -->
    </header>
<!-- Expanded Menu (Initially Hidden) -->
    <div id="sideMenu" class="side-menu">
        <a href="javascript:void(0)" class="close-btn" onclick="toggleMenu()">&times;</a>
        <div class="menu-content">
            <div class="menu-item">
                <p>Bags &gt;</p>
                <ul>
                    <li><a href="handbags.php">Bags Collections</a></li>
                </ul>
            </div>
            <div class="menu-item">
                <p>Accessories &gt;</p>
                <ul>
                    <li><a href="accessories.php">Accessories Collections</a></li>
                </ul>
            </div>
            <!-- User Account Section -->
            <div class="menu-item">
                <p>User Account &gt;</p>
                <ul>
                    <li><a href="signin.php">Sign In</a></li>
                    <li><a href="signout.php">Sign Out</a></li> <!-- Fixed the signout link -->
                </ul>
            </div>
        </div>
    </div>

    <!-- Search Functionality -->
    <div class="search-section">
        <form method="POST" action="accessories.php">
            <input type="text" name="search_query" placeholder="Search Accessories" required>
            <button type="submit" name="search" class="btn">Search</button>
        </form>
    </div>

    <!-- Display Accessories -->
    <div class="accessories">
        <h2>Accessories</h2>
        <div class="accessory-list">
            <?php while ($row = mysqli_fetch_array($results)) { ?>
                <div class="accessory-item">
                    <img src="<?php echo $row['image_path']; ?>" alt="<?php echo $row['name']; ?>" class="accessory-image">
                    <div class="accessory-details">
                        <h3><?php echo $row['name']; ?></h3>
                        <p>Price: $<?php echo $row['price']; ?></p>
                        <p>Material: <?php echo $row['material']; ?></p>
                        <p>Description: <?php echo $row['description']; ?></p>
                        <button class="btn" onclick="addToCart('<?php echo $row['name']; ?>', <?php echo $row['price']; ?>)">Add to Cart</button>

                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <footer>
        <div class="image-box">
            <a href="handbags.php">
                <img src="./images/handbag1.png" alt="Bags">
                <p>Bags</p>
            </a>
        </div>
        <div class="image-box">
            <a href="accessories.php">
                <img src="./images/jewelry1.remini.jpg" alt="Accessories">
                <p>Accessories</p>
            </a>
        </div>
        <p>Contact Us: <a href="mailto:support@anthea.com">support@anthea.com</a></p>
        <p>Follow Us:
            <span>🌐 Facebook</span>
            <span>🌐 Twitter</span>
            <span>🌐 Instagram</span>
        </p>
    </footer>

    <script>
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    function toggleMenu() {
        const menu = document.getElementById("sideMenu");
        menu.classList.toggle("active");
    }

    function toggleCart() {
        window.location.href = "cart.php"; // Navigate to cart page
    }

    function addToCart(itemName, price) {
        cart.push({ name: itemName, price: price });
        localStorage.setItem('cart', JSON.stringify(cart));
        document.getElementById("cartCount").innerText = cart.length;
        alert(itemName + " has been added to your cart.");
    }

    // Update cart count on page load
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById("cartCount").innerText = cart.length;
    });
</script>

</body>
</html>
