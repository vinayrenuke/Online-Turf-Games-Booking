<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="css/contact.css">
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
        <div class="container">
            <div class="contact-info">
                <img src="images/admin.jpg" alt="Contact Image">
                <div class="info">
                    <h2>ABCD</h2>
                    <p><strong>Address:</strong> 123 Main St, City, Country</p>
                    <p><strong>Phone:</strong> +123 456 7890</p>
                    <p><strong>Email:</strong> abcd@example.com</p>
                </div>
            </div>
            <div class="contact-form">
                <h2>Send us a message</h2>
                <?php
                // Handle form submission
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Define database connection details
                    $host = 'localhost';
                    $dbname = 'tf';
                    $username = 'root';
                    $password = '';

                    try {
                        // Establish database connection
                        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        // Retrieve form data
                        $name = $_POST['name'];
                        $email = $_POST['email'];
                        $message = $_POST['message'];

                        // Prepare SQL statement
                        $stmt = $pdo->prepare("INSERT INTO c_message (name, email, message) VALUES (:name, :email, :message)");

                        // Bind parameters
                        $stmt->bindParam(':name', $name);
                        $stmt->bindParam(':email', $email);
                        $stmt->bindParam(':message', $message);

                        // Execute the statement
                        $stmt->execute();

                        // Display success message using JavaScript
                        echo "<script>alert('Message sent successfully!');</script>";
                    } catch (PDOException $e) {
                        echo "Connection failed: " . $e->getMessage();
                    }
                }
                ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <input type="text" name="name" placeholder="Your Name" required>
                    <input type="email" name="email" placeholder="Your Email" required>
                    <textarea name="message" placeholder="Your Message" required></textarea>
                    <button type="submit">Send</button>
                </form>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; MATCH MARVEL</p>
    </footer>
</body>
</html>
