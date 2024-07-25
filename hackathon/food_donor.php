<?php
// Start the session
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Include database connection
include('db_connection.php');

// Get user_id from session
$user_id = $_SESSION['user_id'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $donor_name = $_POST['donor-name'];
    $donor_phone = $_POST['donor-phone'];
    $donor_address = $_POST['donor-address'];
    $donor_pincode = $_POST['donor-pincode'];
    $food_source = $_POST['food-source'];
    $food_plates = $_POST['food-plates'];
    $food_type = $_POST['food-type'];
    $deliver = $_POST['deliver'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO food_donors (user_id, donor_name, donor_phone, donor_address, donor_pincode, food_source, food_plates, food_type, deliver) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssiss", $user_id, $donor_name, $donor_phone, $donor_address, $donor_pincode, $food_source, $food_plates, $food_type, $deliver);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to a thank you or confirmation page
        header("Location: thank_you.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
