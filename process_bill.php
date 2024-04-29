<?php
include "./config.php"; 
include "./config2.php"; 

$query_check_active_user = "SELECT * FROM active_user";
$result_check_active_user = mysqli_query($con, $query_check_active_user);

$active_user_row = mysqli_fetch_assoc($result_check_active_user);
$username = $active_user_row['username'];

// Check if data is received from AJAX
if (isset($_POST['selectedDrinks']) && isset($_POST['totalPrice'])) {
    // Extract data from POST request
    $selectedDrinks = $_POST['selectedDrinks'];
    $totalPrice = $_POST['totalPrice'];

    // Insert data into the bill table
    $query_insert_bill = "INSERT INTO bill(username,drinks, amount) VALUES ('$username','$selectedDrinks', '$totalPrice')";
    $result_insert_bill = mysqli_query($con2, $query_insert_bill);

    if ($result_insert_bill) {
        // Data inserted successfully
        echo "Bill generated successfully!";
    } else {
        // Error inserting data
        echo "Error generating bill: " . mysqli_error($con2);
    }
} else {
    // Data not received from AJAX
    echo "Error: Data not received!";
}
?>
