<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booked Orders</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Include any other stylesheets or scripts you need -->
    <style>
        /* Add any additional CSS styles specific to this page */
        /* For example, you might want to style the table */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <header>
        <!-- Header content, logo, etc. -->
    </header>
    <nav>
        <!-- Navigation links -->
    </nav>
    <main>
        <div class="container">
            <h1>Booked Orders</h1>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Time Slots</th>
                        <th>Duration</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // PHP code to fetch booked orders from database and display in table
                    // Replace this with your actual PHP code to fetch data
                    // Example data for demonstration:
                    $booked_orders = [
                        ["John Doe", "2024-04-15", "10:00 - 12:00", "2 hours"],
                        ["Jane Smith", "2024-04-16", "14:00 - 16:00", "2 hours"]
                        // Add more rows as needed
                    ];

                    // Loop through each booked order and display in table rows
                    foreach ($booked_orders as $order) {
                        echo "<tr>";
                        echo "<td>{$order[0]}</td>";
                        echo "<td>{$order[1]}</td>";
                        echo "<td>{$order[2]}</td>";
                        echo "<td>{$order[3]}</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
    <footer>
        <!-- Footer content -->
    </footer>
</body>
</html>
