<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turf Booking</title>
    <link rel="stylesheet" href="css/game.css">
    
</head>
<body>
    <header>
        <img src="images/logos.png" width="120" height="30" alt="">
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="games.php">Games</a></li>
                <li><a href="print.php">Your Bookings</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>

    <div class="field">
        <div class="details-container">
        <?php
            // Establish database connection (replace these variables with your actual credentials)
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "admintf";

            $connection = mysqli_connect($servername, $username, $password, $database);

            if (!$connection) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $query = "SELECT * FROM game"; 
            $result = mysqli_query($connection, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="details">';
                    // Assuming the column name for the image path is 'image', adjust if different
                    echo '<img src="admin/images/' . $row['image'] . '" alt="images" class="banner-img" height="200" width="200">';
                    echo '<div class="details-content">';
                    echo '<h2>' . $row['name'] . '</h2>';
                    echo '<p>Size: ' . $row['size'] . '</p>';
                    echo '<p>Fees: ' . $row['fees'] . ' per hour</p>';
                    echo '<p>Location: ' . $row['location'] . '</p>';
                    echo '<a href="home.php" class="btn">Book Now</a>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "No turf details found.";
            }

            mysqli_close($connection);
        ?>


        </div>
    </div>

        <section class="features">
            <h2>Book your TURF</h2>
            <ul>
                <li>Easy online booking system</li>
                <li>Wide selection of turfs</li>
                <li>Competitive prices</li>
                <li>24/7 customer support</li>
            </ul>
        </section>
    </main>
    <footer>
        <p>&copy; MATCH MARVER</p>
    </footer>
</body>
</html>
