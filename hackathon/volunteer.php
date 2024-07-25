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

// Initialize search variable
$search_pincode = '';
if (isset($_POST['search'])) {
    $search_pincode = $_POST['search_pincode'];
}

// Fetch donors who can't deliver
$donors_sql = "SELECT donor_name, donor_phone, donor_address, food_plates, donor_pincode FROM food_donors WHERE deliver = 'no'";
if ($search_pincode != '') {
    $donors_sql .= " AND donor_pincode = ?";
}
$donors_stmt = $conn->prepare($donors_sql);
if ($search_pincode != '') {
    $donors_stmt->bind_param("s", $search_pincode);
}
$donors_stmt->execute();
$donors_result = $donors_stmt->get_result();

// Fetch all receivers
$receivers_sql = "SELECT name, phone, address, (num_adults + num_children) AS num_people, pincode FROM food_receivers";
if ($search_pincode != '') {
    $receivers_sql .= " WHERE pincode = ?";
}
$receivers_stmt = $conn->prepare($receivers_sql);
if ($search_pincode != '') {
    $receivers_stmt->bind_param("s", $search_pincode);
}
$receivers_stmt->execute();
$receivers_result = $receivers_stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Page</title>
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
        <div class="content" id="content">
            <h1>Donors and Receivers Needing Assistance</h1>
            <form method="post" action="volunteer.php">
                <label for="search_pincode">Search by Pincode:</label>
                <input type="text" id="search_pincode" name="search_pincode" value="<?php echo htmlspecialchars($search_pincode); ?>" class="short-input">
                <button type="submit" name="search">Search</button>
            </form>
            <div class="list-container">
                <h2>Donors</h2>
                <?php
                if ($donors_result->num_rows > 0) {
                    echo '<table class="info-table">';
                    echo '<thead><tr><th>Name</th><th>Contact Number</th><th>Address</th><th>Number of Plates</th><th>Pincode</th></tr></thead>';
                    echo '<tbody>';
                    while ($row = $donors_result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['donor_name']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['donor_phone']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['donor_address']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['food_plates']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['donor_pincode']) . '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody></table>';
                } else {
                    echo '<p>No donors found who need assistance.</p>';
                }
                ?>

                <h2>Receivers</h2>
                <?php
                if ($receivers_result->num_rows > 0) {
                    echo '<table class="info-table">';
                    echo '<thead><tr><th>Name</th><th>Contact Number</th><th>Address</th><th>Number of People</th><th>Pincode</th></tr></thead>';
                    echo '<tbody>';
                    while ($row = $receivers_result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['phone']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['address']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['num_people']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['pincode']) . '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody></table>';
                } else {
                    echo '<p>No receivers found who need assistance.</p>';
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
