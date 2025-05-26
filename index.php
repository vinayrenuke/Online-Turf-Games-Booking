<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turf Booking</title>
    <link rel="stylesheet" href="css/Index.css">
</head>
<body>
    
    <header>
    <img src="images/logos.png" width="120" height="30" alt="logo">
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

    <div>
        <div class="container text-center center">
        <div class="d-flex justify-content-center">
            <img class="logo" src="images/logo.png" width="50%" height="20%" alt="">
        </div> 
        <div class="container-fluid text-center">
            <div class="container-fluid"> 
            <h1>Welcome to MATCH MARVEL</h1>
            <p>MATCH MARVEL is a sports facility booking site. Several facilities are hosted on MATCH MARVEL.</p>
            <section class="intro">
            <p>Book your turf online and enjoy your game</p>
            <a href="games.php" class="btn">GAMES</a>
        </section>

        </div>
    </div>


        <!-- Advertisement banner with image slides -->
        <h2>Tournaments</h2>
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

            $query = "SELECT * FROM tournament"; 
            $result = mysqli_query($connection, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="details">';
                    // Assuming the column name for the image path is 'image', adjust if different
                    echo '<img src="admin/images/' . $row['image'] . '" alt="images" class="banner-img" height="200" width="200">';
                    echo '<div class="details-content">';
                    echo '<h2>' . $row['name'] . '</h2>';
                    echo '<p>Team: ' . $row['team'] . '</p>';
                    echo '<p>Fees: ' . $row['fees'] . ' per hour</p>';
                    echo '<p>Location: ' . $row['location'] . '</p>';
                    echo '<a href="tmbook.php" class="btn">Book Now</a>';
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
        <h4>&copy; MATCH MARVEL</h4>
    </footer>


    <!-- JavaScript for slideshow functionality -->
    <script>
        var slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function showSlides(n) {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            if (n > slides.length) {slideIndex = 1}
            if (n < 1) {slideIndex = slides.length}
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slides[slideIndex-1].style.display = "block";
        }
    </script>
</body>
</html>
