<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About ANtheA</title>
    <link rel="stylesheet" href="antheas.css">
</head>

<body>
     
    <?php
    // Connection to the server
    $connect = mysqli_connect("localhost", "root", "", "anthea");

    if (!$connect) {
        die('ERROR: ' . mysqli_connect_error());
    }
    ?>
    <!-- Header Section -->
    <header>
        <div class="menu-panel" onclick="toggleMenu()">&#9776;</div> <!-- Hamburger Menu Icon -->

        <!-- Logo in the center-top -->
        <div class="logo">
            <a href="index.php">
                <img src="./images/antheaLogo3.png" alt="Anthea Logo"> <!-- Correct relative path -->
            </a>
        </div>

        <!-- Profile Icon next to Cart Icon -->
        <div class="profile" onclick="window.location.href='signup.php'">&#128100;</div> <!-- Profile Icon -->
        <div class="cart" onclick="toggleCart()">&#128722;<span id="cartCount">0</span></div> <!-- Cart Icon -->
        <a href="cart.php" class="cart-link" style="display: none;"></a> <!-- Invisible link to cart -->
    </header>

    <!-- Expanded Menu (Initially Hidden) -->
    <div id="sideMenu" class="side-menu">
        <a href="javascript:void(0)" class="close-btn" onclick="toggleMenu()">&times;</a>
        <div class="menu-content">
            <!-- Bags -->
            <div class="menu-item">
                <p>Bags &gt;</p>
                <ul>
                    <li><a href="handbags.php">Handbags</a></li>
                    <li><a href="totebags.php">Tote Bags</a></li>
                    <li><a href="backpack.php">Backpacks</a></li>
                </ul>
            </div>
            <!-- Accessories -->
            <div class="menu-item">
                <p>Accessories &gt;</p>
                <ul>
                    <li><a href="jewelry.php">Jewelry</a></li>
                    <li><a href="scarves.php">Scarves</a></li>
                    <li><a href="watches.php">Watches</a></li>
                </ul>
            </div>
            <!-- User Account Section -->
            <div class="menu-item">
                <p>User Account &gt;</p>
                <ul>
                    <li><a href="user_profile.php">My Profile</a></li> <!-- Accessible even if not logged in -->
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="signout.php">Sign Out</a></li> <!-- Optionally add sign out link -->
                    <?php else: ?>
                        <li><a href="signin.php">Sign In</a></li>
                        <li><a href="signup.php">Sign Up</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>

    <h1>About ANtheA</h1>
    <nav>
        <ul>
            <li><a href="history.php">Our History</a></li>
            <li><a href="team.php">Our Team</a></li>
            <li><a href="reviews.php">Customer Reviews</a></li>
        </ul>
    </nav>
    <a href="index.php">Back to Home</a>

    <!-- Footer Section -->
    <footer>
        <div class="image-box">
            <a href="about.php">
                <img src="./images/antheaLogo2.png" alt="About Anthea">
                <p>About Anthea</p>
            </a>
        </div>
        <div class="image-box">
            <a href="bags.php">
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

    <!-- JavaScript for Menu and Cart -->
    <script>
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        function toggleMenu() {
            const menu = document.getElementById("sideMenu");
            menu.style.display = (menu.style.display === "block") ? "none" : "block";
        }

        function toggleCart() {
            window.location.href = "cart.php"; // Navigate to cart page
        }

        function showProductDetails(name, price, material, description, imageSrc) {
            const productDisplay = document.getElementById('productDisplay');
            productDisplay.innerHTML = `
                <div class="product-details">
                    <img src="${imageSrc}" alt="${name}" class="product-image">
                    <h1>${name}</h1>
                    <p><strong>Price:</strong> ${price}</p>
                    <p><strong>Material:</strong> ${material}</p>
                    <p><strong>Description:</strong> ${description}</p>
                    <button onclick="addToCart('${name}', '${price}')">Add to Cart</button>
                    <button onclick="window.location.href='backpack.php'">Back to Products</button>
                </div>
            `;
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
