<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anthea - Home</title>
    <link rel="stylesheet" href="antheas.css"> <!-- Link to external CSS -->
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
                    <li><a href="accessories.php">Accessories Collection</a></li>
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

    <!-- Main Section -->
    <main>
        <h1>Welcome to Anthea!</h1>
        <p>Your one-stop destination for luxury bags and accessories.</p><br>
        
        <div class="influencer-item">
            <a href="handbags.php">
                <img src="./images/anthea1.png" alt="Influencer Collection">
                <p>Influencer's Picks</p> 
            </a>
        </div>
        
        <h2>Shop Our Products Here!</h2>
        
        <div class="featured-collections">
            <div class="featured-item">
                <a href="handbags.php">
                    <img src="./images/handbag3.png" alt="Handbags Collection">
                    <p>Handbags</p>
                </a>
            </div>
            <div class="featured-item">
                <a href="accessories.php">
                    <img src="./images/jewelry6.png" alt="Accessories Collection">
                    <p>Accessories</p>
                </a>
            </div>
        </div>
    </main>

    <!-- Footer Section -->
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
            <a href="https://facebook.com" target="_blank">Facebook</a>
            <a href="https://twitter.com" target="_blank">Twitter</a>
            <a href="https://instagram.com" target="_blank">Instagram</a>
        </p>
    </footer>

    <!-- JavaScript for Menu and Cart -->
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
