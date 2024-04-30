<?php
include "./config.php"; 
include "./config2.php"; 

$error_message = ""; // Initialize an empty error message
$show_bt_more = false; // Initialize a variable to control the display of bt_more class


$query_check_active_user = "SELECT * FROM active_user";
$result_check_active_user = mysqli_query($con, $query_check_active_user);

// Check if there are any rows in active_user table
if(mysqli_num_rows($result_check_active_user) > 0) {
    $show_bt_more = true; // Set the variable to true if there are rows
}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Drinks</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="drinks.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather&family=Playfair+Displ
            ay:ital,wght@1,500&family=Poppins&family=Spectral+SC&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body>
<div class="menubar">
    <div class="logo">
        <a href="#" title="Home" aria-label="home" class="logo-home">
            <img src="./images/logo.png" alt="logo-home">
        </a>
    </div>
    <div class="main-menu">
        <nav>
            <ul>
                <li>
                    <a href="./home.php" class="home tab">
                        Home
                    </a>
                </li>
                <?php if($show_bt_more): ?>
                    <li>
                        <a href="./drinks.php" class="drinks tab">
                             Drinks
                        </a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="./login.php" class="drinks tab">
                             Drinks
                        </a>
                    </li>
                <?php endif; ?>
                <li>
                    <a href="./review.php" class="blog tab">
                        Reviews
                    </a>
                </li>
                <?php if($show_bt_more): ?>
                <li>
                    <a href="./profile.php" class="profile tab">
                        Profile
                    </a>
                </li>
                <?php endif; ?>
                <?php if($show_bt_more): ?>
                    <li class="bt_logout">
                        <a href="./logout.php" class="log-out tab">
                            Logout
                        </a>
                    </li>
                <?php else: ?>
                    <li class="bt_more"> 
                        <button class="more">More
                            <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16">
                                <path d="M12.78 5.22a.749.749 0 0 1 0 1.06l-4.25 4.25a.749.749 0 0 1-1.06 0L3.22 6.28a.749.749 0 1 1 1.06-1.06L8 8.939l3.72-3.719a.749.749 0 0 1 1.06 0Z"></path>
                            </svg>
                        </button>
                        <div class="drop-down-container animate__zoomIn">
                            <div class="dropdown">
                                <ul class="more-items">
                                    <li class="item">
                                        <a class="item-title" href="./login.php">
                                            <h3>Login</h3>
                                        </a>
                                    </li>
                                    <li class="item">
                                        <a class="item-title" href="./signin.php">
                                            <h3>Signup</h3>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</div>
<div class="confirm">
    <div class="confirm_box">
        <button id="confirm_bt">Confirm Order</button>
        <button id="cancel_bt">Cancel Order</button>
    </div>
</div>
<div class="container">
    <div class="espresso product-card">
        <img src="https://www.starbucks.in/assets/icon/placeholder.svg" alt="Product Image">
        <h2>Espresso</h2>
        <p class="price">Rs. 250</p>
        <div class="quantity-selector">
            <button class="quantity-btn" data-action="decrease">-</button>
            <span class="quantity">0</span>
            <button class="quantity-btn" data-action="increase">+</button>
        </div>
        <button class="add-to-cart-btn">Add to Cart</button>
    </div>

    <div class="Cappuccino product-card">
        <img src="https://www.starbucks.in/assets/icon/placeholder.svg" alt="Product Image">
        <h2>Cappuccino</h2>
        <p class="price">Rs. 300</p>
        <div class="quantity-selector">
            <button class="quantity-btn" data-action="decrease">-</button>
            <span class="quantity">0</span>
            <button class="quantity-btn" data-action="increase">+</button>
        </div>
        <button class="add-to-cart-btn">Add to Cart</button>
    </div>

    <div class="Latte product-card"> 
        <img src="https://www.starbucks.in/assets/icon/placeholder.svg" alt="Product Image">
        <h2>Latte</h2>
        <p class="price">Rs. 200</p>
        <div class="quantity-selector">
            <button class="quantity-btn" data-action="decrease">-</button>
            <span class="quantity">0</span>
            <button class="quantity-btn" data-action="increase">+</button>
        </div>
        <button class="add-to-cart-btn">Add to Cart</button>
    </div>

    <div class="cart">
        <h2>Shopping Cart</h2><br>
        <ul id="cart-items"></ul>
        <label>Coupon Code: </label>
        <input type="text" class="coupon-code" name="coupon" placeholder="Enter your coupon code"><br>
        <p style="display: none;" class="yes">Coupon Applied</p>
        <p style="display: none;" class="no">Coupon Invalid</p>
        <button id="show-bill-btn">Place Order</button>
        <p class="total">Total: Rs<span id="total-price">0.00</span></p>
    </div>
</div>
<script src="./drinks.js">
</script>
</body>
</html>
