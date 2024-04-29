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

if(isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Assuming $con is your database connection
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($con, $query) or die("Cannot retrieve data from database: " . mysqli_error($con));

    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $db_password = $row['password'];

        if($password == $db_password) {

            $query = "INSERT INTO active_user(username) VALUE('$username')";
            $fire = mysqli_query($con,$query) or die("cannot insert data into database. ".mysqli_error($con));

            $query_check_profile = "SELECT * FROM user_profiles WHERE username = '$username'";
            $result_check_profile = mysqli_query($con, $query_check_profile);
            if(mysqli_num_rows($result_check_profile) > 0) {
                header("Location: ./home.php");
                exit;
            } else {
                header("Location: ./profile_creation.php");
                exit;
            }
        } 
        
        else {
            // Set the error message
            $error_message = "Incorrect password.";
        }
    } else {
        $error_message = "User not found.";
    }
}
?>   

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="login.css">
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
                    <a href="#" class="blog tab">
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
<div class="signin-container">
    <div class="signin-box">
        <div class="box-1">
            <div class="sign-in login">
                <h3 class="login-header">Login</h3>
                <!-- Display error message if it's not empty -->
                <form action="#" method="post">
                    <div class="username">
                        <input type="text" class="text" name="username" placeholder="  Enter Username">
                    </div>
                    <div class="password">
                        <input type="password" class="text" name="password" placeholder="  Enter Password">
                    </div>
                    <button name="submit" class="submit" class="btn btn-primary btn-primary">SUBMIT</button>
                </form>
            </div>
            <div class="box-or">
                <div class="line"></div>
                <div>OR</div>
                <div class="line"></div>
            </div>
            <div class="login">
                Not have an Account  <a href="./signin.html">Sign In</a>
            </div>
            <?php if(!empty($error_message)): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
        </div>
        <div class="box-2"></div>
    </div>
</div>
</body>
</html>
