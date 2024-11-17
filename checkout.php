<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
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

    <h1>Checkout</h1>

    <!-- Display Cart Items -->
    <div id="checkoutItems"></div>

    <!-- Display Total Price -->
    <div id="totalPrice">
        <h3>Total Price: RM <span id="totalAmount">0</span></h3>
    </div>

    <!-- Payment Method Selection -->
    <div id="paymentMethod">
        <h3>Select Payment Method:</h3>
        <label>
            <input type="radio" name="payment" value="creditCard"> Credit Card
        </label><br>
        <label>
            <input type="radio" name="payment" value="paypal"> PayPal
        </label><br>
        <label>
            <input type="radio" name="payment" value="cash"> Cash on Delivery
        </label>
    </div>

    <button onclick="completeCheckout()">Complete Checkout</button>

    <a href="cart.php">Back to Cart</a>

    <!-- Thank you message and home button will be shown here after checkout -->
    <div id="thankYouMessage" style="display: none;">
        <h2>Thank you for your purchase!</h2>
        <button onclick="goBackHome()">Go to Home Page</button>
    </div>

    <!-- Receipt Section -->
    <div id="receiptSection" style="display: none; margin-top: 20px;">
        <h2>Receipt</h2>
        <div id="receiptDetails"></div>
        <h3>Total Amount Paid: RM <span id="receiptTotal"></span></h3>
        <p>Payment Method: <span id="receiptPaymentMethod"></span></p>
    </div>

    <!-- JavaScript for displaying items and calculating total price -->
    <script>
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        function displayCheckoutItems() {
            const checkoutContainer = document.getElementById('checkoutItems');
            checkoutContainer.innerHTML = '';

            let total = 0;

            if (cart.length === 0) {
                checkoutContainer.innerHTML = '<p>Your cart is empty.</p>';
            } else {
                cart.forEach((item, index) => {
                    const itemElement = document.createElement('div');
                    itemElement.className = 'checkout-item';
                    itemElement.innerHTML = `
                        <p><strong>Item:</strong> ${item.name}</p>
                        <p><strong>Price:</strong> RM ${item.price}</p>
                    `;
                    checkoutContainer.appendChild(itemElement);

                    // Convert item.price to number and add to total
                    total += parseFloat(item.price);
                });

                // Display the total price in RM format
                document.getElementById('totalAmount').innerText = total.toFixed(2);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            displayCheckoutItems();
        });

        function completeCheckout() {
            const paymentMethods = document.getElementsByName('payment');
            let selectedMethod = null;

            paymentMethods.forEach(method => {
                if (method.checked) {
                    selectedMethod = method.value;
                }
            });

            if (!selectedMethod) {
                alert("Please select a payment method.");
                return;
            }

            // Send cart data to the PHP script
            fetch('save_purchase.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ cart: cart, paymentMethod: selectedMethod })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert("Checkout completed successfully with payment method: " + selectedMethod);
                    localStorage.removeItem('cart');

                    // Display receipt details
                    const receiptDetails = document.getElementById('receiptDetails');
                    let total = 0;
                    receiptDetails.innerHTML = '';

                    cart.forEach(item => {
                        const itemElement = document.createElement('p');
                        itemElement.innerHTML = `<strong>${item.name}</strong> - RM ${item.price}`;
                        receiptDetails.appendChild(itemElement);
                        total += parseFloat(item.price);
                    });

                    document.getElementById('receiptTotal').innerText = total.toFixed(2);
                    document.getElementById('receiptPaymentMethod').innerText = selectedMethod;

                    document.getElementById('checkoutItems').style.display = 'none';
                    document.getElementById('totalPrice').style.display = 'none';
                    document.getElementById('paymentMethod').style.display = 'none';
                    document.querySelector('button[onclick="completeCheckout()"]').style.display = 'none';
                    document.getElementById('thankYouMessage').style.display = 'block';
                    document.getElementById('receiptSection').style.display = 'block';
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function goBackHome() {
            window.location.href = 'index.php';
        }
    </script>
</body>
</html>


