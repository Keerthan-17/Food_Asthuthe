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
    <title>Food Donor</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
    <div class="logo">
            <img src="images/logo_2.jpeg" alt="LOGO">
        </div>
        <div class="site-name">
            <h1>Food Asthuthe</h1>
        </div>
        <div class="auth-links">
            <a href="home.html">Home</a>
            <a href="receivers_list.php">Receivers List</a>
            <a href="logout.php">Log Out</a>
        </div>
    </header>
    <main>
        <div class="form-container">
            <h1>Food Donor Information</h1>
            <form action="food_donor_submit.php" method="POST">
                <fieldset>
                    <legend>About Donor</legend>
                    <label for="donor-name">Name</label>
                    <input type="text" id="donor-name" name="donor-name" value="<?php echo htmlspecialchars($name); ?>" required>
                    
                    <label for="donor-phone">Phone Number</label>
                    <input type="text" id="donor-phone" name="donor-phone" value="<?php echo htmlspecialchars($phone); ?>" required>
                    
                    <label for="donor-address">Address</label>
                    <input type="text" id="donor-address" name="donor-address" required>
                    
                    <label for="donor-pincode">Pincode</label>
                    <input type="text" id="donor-pincode" name="donor-pincode" required>
                    
                    <label for="food-source">Source of Food</label>
                    <select id="food-source" name="food-source" required>
                        <option value="restaurant">Restaurant</option>
                        <option value="wedding">Wedding</option>
                        <option value="others">Others</option>
                    </select>
                </fieldset>
                
                <fieldset>
                    <legend>About Food</legend>
                    <label for="food-plates">Number of Plates (approx)</label>
                    <input type="number" id="food-plates" name="food-plates" required>
                    
                    <label for="food-type">Type of Food</label>
                    <select id="food-type" name="food-type" required>
                        <option value="veg">Veg</option>
                        <option value="non-veg">Non-Veg</option>
                    </select>
                    
                    <label>Can you deliver?</label>
                    <div>
                        <input type="radio" id="deliver-yes" name="deliver" value="yes" required>
                        <label for="deliver-yes">Yes</label>
                        <input type="radio" id="deliver-no" name="deliver" value="no" required>
                        <label for="deliver-no">No</label>
                    </div>
                </fieldset>
                
                <button type="submit">Submit</button>
            </form>
        </div>
    </main>
</body>
</html>
