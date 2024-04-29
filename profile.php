<?php
include "./config.php"; 
include "./config2.php"; 

$error_message = ""; // Initialize an empty error message
$show_bt_more = false; // Initialize a variable to control the display of bt_more class

// Assuming $con is your database connection
$query_check_active_user = "SELECT * FROM active_user";
$result_check_active_user = mysqli_query($con, $query_check_active_user);

// Check if there are any rows in active_user table
if(mysqli_num_rows($result_check_active_user) > 0) {
    $show_bt_more = true; // Set the variable to true if there are rows
}
?> 

<?php

if(mysqli_num_rows($result_check_active_user) > 0) {
    $active_user_row = mysqli_fetch_assoc($result_check_active_user);
    $username = $active_user_row['username'];

    // Query to retrieve profile details of the active user
    $query_profile = "SELECT * FROM user_profiles WHERE username = '$username'";
    $result_profile = mysqli_query($con, $query_profile);

    if(mysqli_num_rows($result_profile) > 0) {
        // Fetch profile details
        $profile_details = mysqli_fetch_assoc($result_profile);

        // Access profile details
        $fullname = $profile_details['fullname'];
        $email = $profile_details['email'];
        $gender = $profile_details['gender'];
        $birthdate = $profile_details['birthdate'];
    } 
} else {
    echo "No active user found.";
}
?>

<?php
$query_bill = "SELECT * FROM bill WHERE username = '$username'";
$result_bill = mysqli_query($con2, $query_bill);

// Check if there are any rows returned
if (mysqli_num_rows($result_bill) > 0) {
    // Fetch the bill details
    $bill_details = mysqli_fetch_assoc($result_bill);
    $drinks = $bill_details['drinks'];
    $amount = $bill_details['amount'];

    // Convert the drinks string to an array
    $drinksArray = explode(',', $drinks);
    // Count the number of items in the drinks array
    $numberOfItems = count($drinksArray);
}
?>

<?php
if(isset($_POST['submit'])) {
    // Check if the username is set to prevent SQL injection
    if(isset($username)) {
        $query_delete = "DELETE FROM bill WHERE username = '$username'";
        $result_delete = mysqli_query($con2, $query_delete);
        if($result_delete) {
            // Deletion successful
            header("Location: ./profile.php");
            exit;
        } else {
            // Deletion failed
            $error_message = "Failed to delete data.";
        }
    } else {
        $error_message = "Username not set.";
    }
}
?>



<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./home.css">
    <link rel="stylesheet" href="./profile.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather&family=Playfair+Display:ital,wght@1,500&family=Poppins&family=Spectral+SC&display=swap" rel="stylesheet">
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
                    <a href="./review" class="blog tab">
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
                <?php if($show_bt_more): ?> <!-- Check if bt_more should be displayed -->
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
                                            <h3>Sign-in</h3>
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
<div class="profile-container">
    <div class="profile-box">
        <div class="upper-part">
        <img class="profile-image" src="./images/profile.jpg" alt="Not found">
            <div class="name-email">
                <div class="username"><?php echo $fullname; ?></div>
                <div class="email"><?php echo $email; ?></div>
            </div>
        </div>
        <div class="lower-part">
            <div class="current_order">
                <?php
                    if (mysqli_num_rows($result_bill) > 0) {
                ?>
                <h1>Current Order</h1>
                <?php
                    }
                ?>
                <?php
                    if (mysqli_num_rows($result_bill) == 0) {
                ?>
                <h1>Empty Basket</h1>
                <?php
                    }
                ?>
                <div class="order">
                    <?php
                    if (mysqli_num_rows($result_bill) > 0) {
                    foreach ($drinksArray as $title) {
                    ?>
                    <div class="drinks">
                        <img src="https://www.starbucks.in/assets/icon/placeholder.svg" alt="Product Image" />
                        <h3 class="drink_title"><?php echo $title; ?></h3>
                    </div>
                    <?php
                    }}
                    ?>
                </div>
                <?php
                    if (mysqli_num_rows($result_bill) > 0) {
                ?>
                <h3 class="total_bill">Total bill: Rs.<?php echo $amount; ?></h3>
                <?php
                    }
                ?>
                <?php
                $query_bill = "SELECT cancel_bt FROM bill WHERE username = '$username'";
                $result_bill = mysqli_query($con2, $query_bill);
                if ($result_bill) {
                    $row = mysqli_fetch_assoc($result_bill);
                    if ($row && $row['cancel_bt'] == 1) {
                ?>
                <form class="cancel_order" action="#" method="post">
                    <button class="bt_cancel_order" name="submit">Cancel Order</button>
                </form>
                <?php
                    }}
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    setTimeout(function() {
        var cancelButton = document.querySelector('.bt_cancel_order');
        if (cancelButton) {
            cancelButton.style.display = 'none';
            <?php
                $query_update_cancel_bt = "UPDATE bill SET cancel_bt = 0 WHERE username = '$username'";
                $result_update_cancel_bt = mysqli_query($con2, $query_update_cancel_bt);
            ?>
        }
    }, 20000);
</script>
</body>
</html>