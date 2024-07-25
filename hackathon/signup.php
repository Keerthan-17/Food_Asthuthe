<?php
// Database connection details
$servername = "localhost"; // Change if needed
$username = "root"; // Change if needed
$password = "Keethu@home"; // Change if needed
$dbname = "food_donation"; // Change if needed

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_type = $_POST['user-type'];
    $name = $_POST['name'];
    $email = isset($_POST['email']) ? $_POST['email'] : NULL;
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $contact = isset($_POST['contact']) ? $_POST['contact'] : NULL;
    $address = $_POST['address'];
    $state = $_POST['state'];
    $pincode = $_POST['pincode'];

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (user_type, name, email, password, phone, contact, address, state, pincode) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $user_type, $name, $email, $hashed_password, $phone, $contact, $address, $state, $pincode);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to login page after successful signup
        header("Location: login.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
