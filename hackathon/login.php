<?php
// Start the session
session_start();

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
    $emailOrPhone = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ? OR phone = ?");
    $stmt->bind_param("ss", $emailOrPhone, $emailOrPhone);
    
    // Execute the statement
    $stmt->execute();
    $stmt->store_result();
    
    // Check if user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();
        
        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, store user ID in session and redirect to home page
            $_SESSION['user_id'] = $user_id;
            header("Location: home.html");
            exit();
        } else {
            // Password is incorrect
            $error = "Incorrect username or password.";
        }
    } else {
        // User does not exist
        $error = "Incorrect username or password.";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <img src="images/logo_2.jpeg" alt="LOGO">
        <div class="site-name">
            <h1>Food Asthuthe</h1>
        </div>
        <div class="auth-links">
            <a href="index.html">Home</a>
            <a href="signup.html">Sign Up</a>
        </div>
    </header>
    <main>
        <div class="form-container">
            <h1>Log In</h1>
            <form action="login.php" method="POST">
                <label for="email">Email or Phone No.</label>
                <input type="text" id="email" name="email" required>
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                
                <button type="submit">Log In</button>
            </form>
            <?php
            if (isset($error)) {
                echo "<p id='error-message'>$error</p>";
            }
            ?>
        </div>
    </main>
</body>
</html>
