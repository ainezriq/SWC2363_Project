<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
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

        <div class="cart" onclick="toggleCart()">&#128722;<span id="cartCount">0</span></div> <!-- Cart Icon -->
        <a href="cart.php" class="cart-link" style="display: none;"></a> <!-- Invisible link to cart -->
    </header>

    <!-- Menu Panel -->
    <div id="sideMenu" class="side-menu" style="display: none;">
        <a href="javascript:void(0)" class="close-btn" onclick="toggleMenu()">&times;</a>
        <div class="menu-content">
            <div class="menu-item">
                <p>Bags &gt;</p>
                <ul>
                    <li><a href="handbags.php">Handbags</a></li>
                </ul>
            </div>
            <div class="menu-item">
                <p>Accessories &gt;</p>
                <ul>
                    <li><a href="jewelry.php">Jewelry</a></li>
                </ul>
            </div>
            <div class="menu-item">
                <p>User &gt;</p>
                <ul>
                    <li><a href="signin.php">Sign In</a></li>
                    <li><a href="signout.php">Sign Out</a></li>
                </ul>
            </div>
        </div>
    </div>

    <h1>Your Shopping Cart</h1>
    <div id="cartItems"></div> <!-- Cart items will be displayed here -->

    <!-- Checkout Button -->
    <div class="checkout-button">
        <button onclick="goToCheckout()">Proceed to Checkout</button>
    </div>

    <a href="index.php">Back to Home</a>

    <script>
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        function toggleMenu() {
            const menu = document.getElementById("sideMenu");
            menu.style.display = menu.style.display === "block" ? "none" : "block";
        }

        function toggleCart() {
            window.location.href = "cart.php"; // Navigate to cart page
        }

        function displayCart() {
            const cartContainer = document.getElementById('cartItems');
            cartContainer.innerHTML = '';

            if (cart.length === 0) {
                cartContainer.innerHTML = '<p>Your cart is empty.</p>';
            } else {
                cart.forEach((item, index) => {
                    const cartItem = document.createElement('div');
                    cartItem.className = 'cart-item';
                    cartItem.innerHTML = `
                        <p><strong>Item:</strong> ${item.name}</p>
                        <p><strong>Price:</strong> ${item.price}</p>
                        <button onclick="removeFromCart(${index})">Remove</button>
                    `;
                    cartContainer.appendChild(cartItem);
                });
            }
        }

        function removeFromCart(index) {
            cart.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            displayCart();
            document.getElementById("cartCount").innerText = cart.length;
        }

        function goToCheckout() {
            if (cart.length > 0) {
                window.location.href = "checkout.php"; // Redirect to the checkout page
            } else {
                alert("Your cart is empty! Please add some items before proceeding to checkout.");
            }
        }

        // Display the cart items when the page loads
        document.addEventListener('DOMContentLoaded', () => {
            displayCart();
            document.getElementById("cartCount").innerText = cart.length;
        });
    </script>

    <!-- Footer Section -->
    <footer>
        <div class="image-box">
            <a href="handbags.php">
                <img src="./images/handbag1.png" alt="Bags">
                <p>Bags</p>
            </a>
        </div>
        <div class="image-box">
            <a href="jewelry.php">
                <img src="./images/jewelry1.remini.jpg" alt="Jewelry">
                <p>Jewelry</p>
            </a>
        </div>
        <p>Contact Us: <a href="mailto:support@anthea.com">support@anthea.com</a></p>
        <p>Follow Us:
            <span>🌐 Facebook</span>
            <span>🌐 Twitter</span>
            <span>🌐 Instagram</span>
        </p>
    </footer>
</body>
</html>
