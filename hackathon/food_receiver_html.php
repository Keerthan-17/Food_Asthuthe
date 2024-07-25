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

// Fetch user details from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT name, phone FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name, $phone);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Receiver</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
    <div class="logo">
            <img src="images/logo_2.jpeg" alt="LOGO">
        </div>
        <div class="auth-links">
            <a href="home.html">Home</a>
            <a href="logout.php">Log Out</a>
        </div>
    </header>
    <main>
        <div class="form-container">
            <h1>Food Receiver Information</h1>
            <form action="food_receiver.php" method="POST">
                <legend>About Receiver</legend>
                <label for="receiver-name">Name</label>
                <input type="text" id="receiver-name" name="receiver-name" value="<?php echo htmlspecialchars($name); ?>" required>
                
                <label for="receiver-phone">Phone Number</label>
                <input type="text" id="receiver-phone" name="receiver-phone" value="<?php echo htmlspecialchars($phone); ?>" required>
                
                <label for="receiver-address">Address</label>
                <input type="text" id="receiver-address" name="receiver-address" required>
                
                <label for="receiver-pincode">Pincode</label>
                <input type="text" id="receiver-pincode" name="receiver-pincode" required>
                
                <label for="receiver-contact">Contact Number</label>
                <input type="text" id="receiver-contact" name="receiver-contact" required>
                
                <br><br>
                <legend>Number of People</legend><br>
                <div class="subsection">
                    <label for="num-adults">Adults</label>
                    <input type="number" id="num-adults" name="num-adults" required>
                </div>
                <div class="subsection">
                    <label for="num-children">Children</label>
                    <input type="number" id="num-children" name="num-children" required>
                </div>
                
                <label>Can you receive food from donor's location?</label>
                <div>
                    <input type="radio" id="receive-yes" name="receive" value="yes" required>
                    <label for="receive-yes">Yes</label>
                    <input type="radio" id="receive-no" name="receive" value="no" required>
                    <label for="receive-no">No</label>
                </div>                
                <button type="submit">Submit</button>
            </form>
        </div>
    </main>
</body>
</html>
