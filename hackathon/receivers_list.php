<?php
// Start the session
session_start();

// Include database connection
include('db_connection.php');

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Fetch all receivers
$receivers_sql = "SELECT name, phone, address, pincode, (num_adults + num_children) AS num_people FROM food_receivers";
$receivers_result = $conn->query($receivers_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receivers List</title>
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
            <a href="logout.php">Log Out</a>
        </div>
    </header>
    <main>
        <div class="content">
            <h1>Food Receivers List</h1>
            <div class="list-container">
                <?php
                if ($receivers_result->num_rows > 0) {
                    echo '<table class="info-table">';
                    echo '<thead><tr><th>Name</th><th>Contact Number</th><th>Address</th><th>Pincode</th><th>Number of People</th></tr></thead>';
                    echo '<tbody>';
                    while ($row = $receivers_result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['phone']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['address']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['pincode']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['num_people']) . '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody></table>';
                } else {
                    echo '<p>No receivers found.</p>';
                }
                ?>
            </div>
        </div>
    </main>
</body>
</html>
<?php
// Close the database connection
$conn->close();
?>
