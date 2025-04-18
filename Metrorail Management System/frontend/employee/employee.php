
<?php
include __DIR__ . '/../../backend/user/employeelogin.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Profile - Metro Rail Management</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <h1>Employee Profile - Metro Rail Management</h1>
</header>

<div class="profile-container">
    <h2>Welcome, Employee</h2>

    <section class="employee-details">
        <h3>Employee Details</h3>
        <table>
            <thead>
                <tr>
                    <th>Salary</th>
                    <th>Working Days</th>
                    <th>Working Hours</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td id="employee-salary"></td>
                    <td id="employee-working-days"></td>
                    <td id="employee-working-hours"></td>
                </tr>
            </tbody>
        </table>
    </section>

    <section class="train-details">
        <h3>Train Details</h3>
        <table>
            <thead>
                <tr>
                    <th>Train ID</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Passengers</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody id="train-details">
                <!-- Train data will be inserted here via JavaScript -->
            </tbody>
        </table>
    </section>

    <footer>
    <button onclick="window.location.href='updateTrainTime.php'">Update Train Details</button>
    </footer>

</div>



</body>
</html>
