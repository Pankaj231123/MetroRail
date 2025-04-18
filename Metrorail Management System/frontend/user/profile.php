<?php

include 'C:/xampp/htdocs/Metrorail Management System/backend/user/login.php';



// Database connection
$conn = oci_connect('METRO', 'PROJECT', 'localhost/XE', 'AL32UTF8');
if (!$conn) {
    $e = oci_error();
    die("Database connection failed: " . htmlentities($e['message'], ENT_QUOTES));
}
$trainQuery = "SELECT TRAIN_ID, NAME, STATUS, PASSENGERS FROM TRAINS";
$trainStmt = oci_parse($conn, $trainQuery);
oci_execute($trainStmt);
$trains = [];
while ($row = oci_fetch_assoc($trainStmt)) {
    $trains[] = $row;
}
oci_free_statement($trainStmt);

oci_close($conn);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metro Customer Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .container {
            display: flex;
            flex: 1;
        }

        .sidebar {
            background-color: #ffffff;
            width: 25%;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .sidebar img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 15px;
        }

        .sidebar h3 {
            color: #333;
            margin-bottom: 10px;
        }

        .sidebar p {
            color: #555;
            margin-bottom: 5px;
            font-size: 14px;
            text-align: center;
        }

        .sidebar .balance {
            font-weight: bold;
            color: #007bff;
            margin-top: 10px;
        }

        .sidebar button {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .sidebar button:hover {
            background-color: #0056b3;
        }

        .main-content {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .buttons button {
            flex: 1;
            margin: 0 10px;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .buttons button:hover {
            background-color: #0056b3;
        }

        .train-route {
            flex: 1;
            background-color: #ffffff;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .train-route h4 {
            color: #333;
            margin-bottom: 10px;
        }

        .train-route table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .train-route table th, .train-route table td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .train-route table th {
            background-color: #f4f4f9;
            color: #333;
            font-weight: bold;
        }

        .train-route table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .logout {
            background-color: #ffffff;
            padding: 10px;
            text-align: center;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
        }

        .logout button {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .logout button:hover {
            background-color: #a71d2a;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Left Sidebar -->
        <div class="sidebar">
            
            <h3>Pankaj Roy</h3>
            <p>123 norda Badda<br>Dhaka, BD</p>
            <p>Card Number: **** **** **** 1234</p>
            <p class="balance">Balance: 45.75tk</p>
            <button>Update Profile</button>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Buttons Section -->
            <div class="buttons">
                <button><a href="http://localhost/Metrorail%20Management%20System/frontend/route/routeDetails.html";>Train Route</button>
                <button><a href="http://localhost/Metrorail%20Management%20System/frontend/train/trainDetails.html";>Train Schedule Update</a></button>
                <button ><a href="http://localhost/Metrorail%20Management%20System/frontend/ticketing/ticket.php";>Buy Ticket</a></button>


                
            </div>

            <!-- Travel History Section -->
            <div class="train-route">
            <h4>Train Route Schedule</h4>
            <table>
            <thead>
                <tr>
                    <th>Train Number</th>
                    <th>Route</th>
                    <th>Departure Time</th>
                    <th>Arrival Time</th>
                    <th>Fare</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trains as $train) : ?>
                    <tr>
                        <td><?= htmlentities($train['TRAIN_ID']) ?></td>
                        <td><?= htmlentities($train['NAME']) ?></td>
                        <td><?= htmlentities($train['STATUS']) ?></td>
                        <td><?= htmlentities($train['PASSENGERS']) ?></td>
                        <td>$<?php echo rand(2, 10) . ".00"; ?></td>
                    </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>



    <!-- Footer Section -->
    <div class="logout">
        <button><a href= "profilelogout.php">Log Out</a></button>
    </div>
</body>
</html>