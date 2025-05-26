<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            background-image: url('images/w.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            font-family: cursive;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            position: relative;
        }

        .login-content {
            max-width: 600px;
            height: 300px;
            padding: 40px;
            background-color: #ced3d7;
            border-radius: 15px; /* Rounded border */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 1;
            margin-left: 50px; /* Add gap between image and content */
            border: 10px solid black;
        }

        .login-container {
            width: 100%;
        }

        .img {
           
            width: 412px; /* Adjust image width */
            height: auto;
            border-radius: 5px;
            
        }

        h2 {
            margin-top: 10px;
            text-align: center;
        }

        .form-group {
            margin: -10px;;
            margin-bottom: 20px;
            width: 100%;
        }

        label {
            display: block;
            font-weight: bold;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            display: block;
            width: 50%;
            margin-left: 60px; 
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        p {
            text-align: center;
        }

        a {
            text-align: center;
        }
    </style>
</head>
<body>
    <img class="img" src="images/lfb.jpg" alt="Login Image">
    <div class="login-content">
        <div class="login-container">
            <h2>Login</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Login</button>
            </form>
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>

    <?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$database = "tf";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate login
    $sql = "SELECT * FROM register WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Credentials are valid, proceed with login
        echo "<script>alert('Login successful!');</script>";
        // Redirect to dashboard or another page
        header("Location: index.php");
        exit(); // Exit after redirection
    } else {
        // Credentials are not valid, show alert
        echo "<script>alert('Invalid email or password. Please try again.');</script>";
    }

    // Insert entered details into database (assuming register table structure)
    $sql_insert = "INSERT INTO users (email, password) VALUES ($email, $password)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ss", $email, $password);
    $stmt_insert->execute();
}

// Close database connection
$conn->close();
?>

</body>
</html>
