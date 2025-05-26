<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booked Details</title>
    <link rel="stylesheet" href="css/prints.css">
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

    <div class="container">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "tf";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch data from the database
        $sql = "SELECT * FROM book ORDER BY id DESC LIMIT 1"; // Get the most recent entry
        $result = $conn->query($sql);

        if ($result === false) {
            // Handle query error
            echo "Error: " . $conn->error;
        } else {
            if ($result->num_rows > 0) {
                // Output data of the most recent entry
                while($row = $result->fetch_assoc()) {
                    echo "<div class='bill-header'><h2>Booking Confirmation</h2></div>";
                    echo "<div class='bill-info'>";
                    echo "<p><strong>Name:</strong> " . $row["name"] . "</p>";
                    echo "<p><strong>Email:</strong> " . $row["email"] . "</p>";
                    echo "<p><strong>Phone:</strong> " . $row["phone"] . "</p>";
                    echo "<p><strong>Date:</strong> " . $row["date"] . "</p>";
                    echo "<p><strong>Time Slot:</strong> " . $row["time_slot"] . "</p>";
                    echo "<p><strong>Duration:</strong> " . $row["duration"] . "</p>";
                    echo "<p><strong>Price:</strong> $" . $row["price"] . "</p>";
                    echo "</div>";
                }
            } else {
                echo "0 results";
            }
        }

        $conn->close();
        ?>
        <div class="button-container">
            <button class="back-button" onclick="window.location.href='index.php'">Back</button>
            <button class="print-button" onclick="window.print()">Print</button>
        </div>
    </div>
    <footer>
        <p>&copy; MATCH MARVER</p>
    </footer>
</body>
</html>
