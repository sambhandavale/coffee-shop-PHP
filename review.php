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
    if(isset($_POST['submit'])) {
        $active_user_row = mysqli_fetch_assoc($result_check_active_user);
        $username = $active_user_row['username'];
        $query_get_name = "SELECT * FROM user_profiles where username='$username'";
        $result_get_name = mysqli_query($con, $query_get_name);
        $active_user_fullname = mysqli_fetch_assoc($result_get_name);
        $fullname = $active_user_fullname['fullname'];
        $review = $_POST['review'];

        $query = "INSERT INTO user_reviews (username, review,fullname) VALUES ('$username', '$review','$fullname')";
        
        $fire = mysqli_query($con, $query) or die("Cannot insert data into database. " . mysqli_error($con));


        header("Location: ./review.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./review.css">
    <link rel="stylesheet" href="./home.css">
    <style>
        h1{
            color:white;
        }
        .blog_containers {
            display: flex;
            flex-wrap: wrap;
            gap: 50px;
            flex-direction: column;
            align-items: center;
        }
    </style>
    <title>Document</title>
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
    <div class="blog_containers">
        <?php
            // Fetch and display reviews
            $query_reviews = "SELECT username, review,fullname FROM user_reviews";
            $result_reviews = mysqli_query($con, $query_reviews);

            if ($result_reviews && mysqli_num_rows($result_reviews) > 0) {
                while ($row = mysqli_fetch_assoc($result_reviews)) {
                    $fullname = $row['fullname'];
                    $review = $row['review'];
        ?>
        <div class="blog_container"> 
            <div class="blog_wrapper">
                <div class="blog_top">
                    <p class="user_name"><?php echo $fullname; ?></p>
                </div>
                <div class="line_container">
                    <div class="line"></div>
                </div>
                <div class="main_content">
                    <p class="content"><?php echo $review; ?></p>
                </div>
            </div>
        </div>
        <?php
            }}
            else{
        ?>
        <h1>No Reviews</h1>
        <?php
            }
        ?>
    </div>
    <div class="review-box">
        <h1>Write your Review</h1> 
        <div class="review">
            <?php if($show_bt_more): ?>
                <form action="#" method="post">
                    <input type="text" class="text inp" name="review" placeholder="Write Your Review Here">
                    <button name="submit" class="submit">SUBMIT</button>
                </form>
            <?php else: ?>
                <div class="not_authenticated">
                    <h2>Login to add a Review</h2>
                    <a href="./login.php">Login</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
