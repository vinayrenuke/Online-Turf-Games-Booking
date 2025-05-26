<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Appointment Booking Form</title>
<link rel="stylesheet" href="css/tmbook.css">
</head>
<body>

<form id="booking-form" action="#" method="post">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="phone">Phone Number:</label>
    <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" placeholder="1234567890" required>

    <label for="upi-id">UPI id:</label>
    <input type="text" id="upi-id" name="upi-id">

    <!-- Submit button placed below the payment button -->
    <br>
    <button type="button" onclick="validateForm()" style="margin-top: 10px">Book Appointment</button>
    <button type="button" onclick="goBack()" style="margin-bottom: 10px; margin-left: 270px;">Back</button>

</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js"></script>
<script>
    // Function to validate form before submission
    function validateForm() {
        var name = $('#name').val();
        var email = $('#email').val();
        var phone = $('#phone').val();

        if (name === "" || email === "" || phone === "") {
            alert("Please fill in all required fields.");
        } else {
            document.getElementById('booking-form').submit(); // Submit the form if all fields are filled
        }
    }
</script>

<!-- Add PayPal checkout button -->
<script src="https://www.paypal.com/sdk/js?client-id=YOUR_CLIENT_ID"></script>
<div id="paypal-button-container"></div>

<!-- JavaScript to initialize PayPal -->
<script>
  paypal.Buttons({
    createOrder: function(data, actions) {
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: $('#price').val() // Dynamically fetch the total price from the form
          }
        }]
      });
    },
    onApprove: function(data, actions) {
      return actions.order.capture().then(function(details) {
        // Insert logic to save transaction details to your database and complete booking
        alert('Transaction completed by ' + details.payer.name.given_name);
        // Redirect or perform any necessary action after successful payment
        document.getElementById('booking-form').submit(); // Submit the booking form after successful payment
      });
    }
  }).render('#paypal-button-container');
</script>

<script>
    function goBack() {
        window.history.back();
    }
</script>


<?php
// Database connection parameters
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

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

        // SQL to insert form data into database
        $sql = "INSERT INTO tmbook (name, email, phone) VALUES ('$name', '$email', '$phone')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>window.location.href = 'tmbill.php';</script>";
        } else {
            echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
        }
    }

// Close database connection
$conn->close();
?>
</body>
</html>
