<?php
include "./config.php"; 

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

<html lang="en">
<head> 
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./home.css">
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
                    <a href="#reviews" class="blog tab">
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
<div class="wrapper">
    <div class="catch-phrase">
        <div class="phrase1-wrapper"><div class="phrase1">Caffeine</div></div>
        <div class="phrase2-wrapper"><div class="phrase2">Dreams</div></div>
    </div>
    <div class="image-wrapper"><img class="image" src="./images/cup_of_coffee.png"></div>
</div>
</body>
</html>