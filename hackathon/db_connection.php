<?php
$servername = "localhost"; // Change if needed
$username = "root"; // Change if needed
$password = "Keethu@home"; // Change if needed
$dbname = "food_donation"; // Change if needed

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
