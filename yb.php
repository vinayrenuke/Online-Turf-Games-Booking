<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tf"; // Existing database for 'book' table
$yourbook_dbname = "yourbook"; // New database name for 'yourbook' table

// Create connection to the existing database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection to the existing database
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create connection to the new database
$new_conn = new mysqli($servername, $username, $password);

// Check connection to the new database
if ($new_conn->connect_error) {
    die("Connection failed: " . $new_conn->connect_error);
}

// Create new database
$sql_create_db = "CREATE DATABASE IF NOT EXISTS $yourbook_dbname";
if ($new_conn->query($sql_create_db) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $new_conn->error . "<br>";
}

// Close connection to the new database
$new_conn->close();

// Connect to the new database
$conn = new mysqli($servername, $username, $password, $yourbook_dbname);

// Check connection to the new database
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the 'yourbook' table
$sql_create_table = "CREATE TABLE IF NOT EXISTS yourbook (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    time_slot TIME NOT NULL,
    duration INT NOT NULL
)";

if ($conn->query($sql_create_table) === TRUE) {
    echo "Table yourbook created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $date = date("Y-m-d", strtotime($_POST["date"]));
    $time_slot = $_POST["time_slot"];
    $duration = $_POST["duration"];
    $price = $duration * 500; // Fixed rate: 980 Rs per hour

    // Check if the selected time slot is already booked
    $checkSql = "SELECT * FROM book WHERE date = '$date' AND time_slot = '$time_slot'";
    $result = $conn->query($checkSql);
    if ($result->num_rows > 0) {
        echo "<script>alert('This time slot is already booked. Please select a different time.');</script>";
    } else {
        // SQL to insert form data into database
        $sql = "INSERT INTO book (name, email, phone, date, time_slot, duration, price) VALUES ('$name', '$email', '$phone', '$date', '$time_slot', $duration, $price)";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Appointment booked successfully');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
        }

        // Insert fetched data into the new 'yourbook' table
        $sql_fetch_book = "SELECT name, date, time_slot, duration FROM book WHERE name = '$name' AND date = '$date' AND time_slot = '$time_slot' AND duration = $duration";
        $result_fetch_book = $conn->query($sql_fetch_book);
        if ($result_fetch_book === false) {
            echo "Error executing query: " . $conn->error . "<br>";
        } else {
            while ($row = $result_fetch_book->fetch_assoc()) {
                $name = $row['name'];
                $date = $row['date'];
                $timeSlot = $row['time_slot'];
                $duration = $row['duration'];

                // Insert fetched data into 'yourbook' table
                $sql_insert_yourbook = "INSERT INTO yourbook (name, date, time_slot, duration) VALUES ('$name', '$date', '$timeSlot', $duration)";
                if ($conn->query($sql_insert_yourbook) !== TRUE) {
                    echo "Error inserting data into yourbook table: " . $conn->error . "<br>";
                }
            }
        }
    }
}

// Fetch appointments data from the 'book' table
$sql_fetch_book = "SELECT name, date, time_slot, duration FROM book";
$result_fetch_book = $conn->query($sql_fetch_book);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Turf Booking</title>
<link rel="stylesheet" href="css/booked.css">
</head>
<body>

<header>
<img src="images/logos.png" width="120" height="30" alt="">
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="games.php">Games</a></li>
            <li><a href="booked.php">Your Bookings</a></li>
            <li><a href="contact.php">Contact Us</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

<main>
    <div class="container">
        <h1>Booked Orders</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Time Slot</th>
                    <th>Duration</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Output fetched appointments data
                if ($result_fetch_book === false) {
                    echo "Error executing query: " . $conn->error . "<br>";
                } else {
                    if ($result_fetch_book->num_rows > 0) {
                        while($row = $result_fetch_book->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$row['name']}</td>";
                            echo "<td>{$row['date']}</td>";
                            echo "<td>{$row['time_slot']}</td>";
                            echo "<td>{$row['duration']} hours</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No booked orders found.</td></tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</main>

<footer>
    <p>&copy; MATCH MARVEL</p>
</footer>

</body>
</html>
