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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $name = $_POST['receiver-name'];
    $phone = $_POST['receiver-phone'];
    $address = $_POST['receiver-address'];
    $pincode = $_POST['receiver-pincode'];
    $contact = $_POST['receiver-contact'];
    $num_adults = $_POST['num-adults'];
    $num_children = $_POST['num-children'];
    $receive = $_POST['receive'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO food_receivers (user_id, name, phone, address, pincode, contact, num_adults, num_children, receive) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssiis", $user_id, $name, $phone, $address, $pincode, $contact, $num_adults, $num_children, $receive);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to thank you page
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
