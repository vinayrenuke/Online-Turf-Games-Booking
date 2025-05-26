<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Appointment Booking Form</title>
<link rel="stylesheet" href="css/home.css">
</head>
<body>

<form id="booking-form" action="#" method="post">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="phone">Phone Number:</label>
    <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" placeholder="1234567890" required>

    <label for="date">Select Date:</label>
    <input type="date" id="datepicker" name="date" required>

    <label for="duration">Duration (hours):</label>
    <input type="number" id="duration" name="duration" min="1" max="3" required>

    <label for="start-time">Select Time Slot:</label>
    <select id="start-time" name="start-time" required>
        <option value="" disabled selected>Select a time slot</option>
    </select>

    <label for="price">Total Price:</label>
    <input type="text" id="price" name="price" readonly>
    
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
    // Initialize datepicker
    $(function() {
        $("#datepicker").datepicker({
            dateFormat: "yy-mm-dd",
            minDate: 0,
            onSelect: function(dateText, inst) {
                // You can add any logic you need when a date is selected
                console.log("Selected date: " + dateText);
            }
        });
    });
        
    // Calculate total price and generate time slots based on duration
    $('#duration').on('input', function() {
        var duration = parseInt($(this).val());
        var totalPrice = duration * 500; // Fixed rate: 980 Rs per hour
        $('#price').val('Rs ' + totalPrice);
        
        // Clear existing time slots
        $('#start-time').empty();
        
        // Generate time slots based on duration
        var startTimeSelect = $('#start-time');
        var endHour = 21; // End time for appointments
        for (var hour = 7; hour <= endHour - duration + 1; hour++) {
            var timeSlotStart = formatTime(hour);
            var timeSlotEnd = formatTime(hour + duration);
            var timeSlot = timeSlotStart + ' - ' + timeSlotEnd;
            var option = $('<option>').text(timeSlot).attr('value', timeSlot);
            startTimeSelect.append(option);
        }
    });

    // Function to format time in 12-hour format with AM/PM
    function formatTime(hour) {
        var ampm = hour >= 12 ? 'PM' : 'AM';
        hour = hour % 12;
        hour = hour ? hour : 12;
        return hour + ' ' + ampm;
    }

    // Function to validate form before submission
    function validateForm() {
        var name = $('#name').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var date = $('#datepicker').val();
        var duration = $('#duration').val();
        var startTime = $('#start-time').val();
        var upiId = $('#upi-id').val();

        if (name === "" || email === "" || phone === "" || date === "" || duration === "" || startTime === "" || upiId === "") {
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
    $date = date("Y-m-d", strtotime($_POST["date"]));
    $timeSlot = $_POST["start-time"];
    $duration = $_POST["duration"];
    $price = $duration * 500; // Fixed rate: 980 Rs per hour

    // Check if the selected time slot is already booked
    $checkSql = "SELECT * FROM book WHERE date = '$date' AND time_slot = '$timeSlot'";
    $result = $conn->query($checkSql);
    if ($result->num_rows > 0) {
        echo "<script>alert('This time slot is already booked. Please select a different time.');</script>";
    } else {
        // SQL to insert form data into database
        $sql = "INSERT INTO book (name, email, phone, date, time_slot, duration, price) VALUES ('$name', '$email', '$phone', '$date', '$timeSlot', $duration, $price)";

        if ($conn->query($sql) === TRUE) {
            echo "<script>window.location.href = 'print.php';</script>";
        } else {
            echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
        }
    }
}

// Close database connection
$conn->close();
?>
</body>
</html>
