<?php
// Start the session
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../user/adminlogin.php");
    exit;
}

// Database connection
$conn = oci_connect('METRO', 'PROJECT', 'localhost/XE', 'AL32UTF8');
if (!$conn) {
    $e = oci_error();
    die("Database connection failed: " . htmlentities($e['message'], ENT_QUOTES));
}

// Fetch employees data
$employeeQuery = "SELECT EMPLOYEE_ID, NAME, SALARY, WORKING_DAYS, WORKING_HOURS FROM employees";
$employeeStmt = oci_parse($conn, $employeeQuery);
oci_execute($employeeStmt);
$employees = [];
while ($row = oci_fetch_assoc($employeeStmt)) {
    $employees[] = $row;
}
oci_free_statement($employeeStmt);

// Fetch users data
$sql = "SELECT ID, USERNAME, EMAIL, PHONE_NUMBER, PASSWORD FROM USERS";
$statement = oci_parse($conn, $sql);

if (oci_execute($statement)) {
    $users = [];
    while ($row = oci_fetch_assoc($statement)) {
        $users[] = $row;
    }
} else {
    $users = []; // Default to an empty array in case of a query error
}
oci_free_statement($statement);

// Fetch trains data
$trainQuery = "SELECT TRAIN_ID, NAME, STATUS, PASSENGERS FROM TRAINS";
$trainStmt = oci_parse($conn, $trainQuery);
oci_execute($trainStmt);
$trains = [];
while ($row = oci_fetch_assoc($trainStmt)) {
    $trains[] = $row;
}

$ticketsQuery = "SELECT USER_ID, FROM_STATION, TO_STATION, TRAVEL_DATE, TRAVEL_TIME, FARE FROM TICKETS";
$ticketsStmt = oci_parse($conn, $ticketsQuery);
oci_execute($ticketsStmt);
$tickets = [];
while ($row = oci_fetch_assoc($ticketsStmt)) {
    $tickets[] = $row;
}


oci_free_statement($trainStmt);

oci_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metro Rail Management - Admin Panel</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Add your CSS styles here (from your original code) */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f1f1;
        }

        header {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .sidebar {
            width: 200px;
            background-color: #94bbc2;
            color: white;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 40px;
            transition: transform 0.3s ease;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 20px;
            text-decoration: none;
            margin-bottom: 20px;
        }

        .sidebar a:hover {
            background-color: #444;
        }

        .content {
            margin-left: 220px;
            padding: 20px;
        }

        h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #aec37a;
            color: white;
        }
    </style>
</head>
<body>
<header>
    <h1>Metro Rail Management - Admin Panel</h1>
</header>

<div class="sidebar">
    <a href="#employees">Employees</a>
    <a href="#users">Users</a>
    <a href="#trains">Trains</a>
    <a href="#tickets">Tickets</a>
    <button><a href="logout.php">Log Out</a></button>
</div>

<div class="content">
    <section id="employees">
        <h2>Employees</h2>
        <button style="margin-bottom: 20px; padding: 10px; background-color: #aec37a; color: white; border: none; border-radius: 5px;">
        <a href="addemployee.php" style="color: white; text-decoration: none;">Add Employee</a>
       </button>
       <table>
    <thead>
        <tr>
            <th>Employee ID</th>
            <th>Name</th>
            <th>Salary</th>
            <th>Working Days</th>
            <th>Working Hours</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($employees)): ?>
            <?php foreach ($employees as $employee): ?>
                <tr>
                    <td><?php echo isset($employee['EMPLOYEE_ID']) ? htmlentities($employee['EMPLOYEE_ID'], ENT_QUOTES) : 'N/A'; ?></td>
                    <td><?php echo isset($employee['NAME']) ? htmlentities($employee['NAME'], ENT_QUOTES) : 'N/A'; ?></td>
                    <td><?php echo isset($employee['SALARY']) ? htmlentities($employee['SALARY'], ENT_QUOTES) : 'N/A'; ?></td>
                    <td><?php echo isset($employee['WORKING_DAYS']) ? htmlentities($employee['WORKING_DAYS'], ENT_QUOTES) : 'N/A'; ?></td>
                    <td><?php echo isset($employee['WORKING_HOURS']) ? htmlentities($employee['WORKING_HOURS'], ENT_QUOTES) : 'N/A'; ?></td>
                    <td>
                        <button>
                            <a href="edit_employee.php?id=<?php echo $employee['EMPLOYEE_ID']; ?>" style="text-decoration: none; color: black;">Edit</a>
                        </button>
                    </td>
                    <td>
                        <button>
                            <a href="delete_employee.php?id=<?php echo $employee['EMPLOYEE_ID']; ?>" onclick="return confirm('Are you sure you want to delete this employee?')" style="text-decoration: none; color: black;">Delete</a>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">No employees found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

    </section>

    <section id="users">
        <h2>Users</h2>
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Password</th>
                    <th>EDIT</th>
                    <th>DELETE</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo isset($user['ID']) ? htmlentities($user['ID'], ENT_QUOTES) : 'N/A'; ?></td>
                        <td><?php echo isset($user['USERNAME']) ? htmlentities($user['USERNAME'], ENT_QUOTES) : 'N/A'; ?></td>
                        <td><?php echo isset($user['EMAIL']) ? htmlentities($user['EMAIL'], ENT_QUOTES) : 'N/A'; ?></td>
                        <td><?php echo isset($user['PHONE_NUMBER']) ? htmlentities($user['PHONE_NUMBER'], ENT_QUOTES) : 'N/A'; ?></td>
                        <td><?php echo isset($user['PASSWORD']) ? htmlentities($user['PASSWORD'], ENT_QUOTES) : 'N/A'; ?></td>

                        <td>
                        <button><a href="edit_user.php?id=<?php echo $user['ID']; ?>">Edit</a> |</button></td>
                        <td>
                        <button><a href="delete_user.php?id=<?php echo $user['ID']; ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a></button>
                        </td>


                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No users found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </section>

    <section id="trains">
        <h2>Trains</h2>
        <table>
        <thead>
            <tr>
                <th>Train ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>Passengers</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($trains)): ?>
                <?php foreach ($trains as $train): ?>
                    <tr>
                        <td><?php echo isset($train['TRAIN_ID']) ? htmlentities($train['TRAIN_ID'], ENT_QUOTES) : 'N/A'; ?></td>
                        <td><?php echo isset($train['NAME']) ? htmlentities($train['NAME'], ENT_QUOTES) : 'N/A'; ?></td>
                        <td><?php echo isset($train['STATUS']) ? htmlentities($train['STATUS'], ENT_QUOTES) : 'N/A'; ?></td>
                        <td><?php echo isset($train['PASSENGERS']) ? htmlentities($train['PASSENGERS'], ENT_QUOTES) : 'N/A'; ?></td>
                        <td>
                            <button class="action-button">
                                <a href="edit_train.php?id=<?php echo $train['TRAIN_ID']; ?>">Edit</a>
                            </button>
                        </td>
                        <td>
                            <button class="action-button delete-button">
                                <a href="delete_train.php?id=<?php echo $train['TRAIN_ID']; ?>" onclick="return confirm('Are you sure you want to delete this train?')">Delete</a>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No trains found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    </section>

    <section id="tickets">
        <h2>Tickets</h2>
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>From Station</th>
                    <th>To Station</th>
                    <th>Travel Date</th>
                    <th>Travel Time</th>
                    <th>Fare</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($tickets)): ?>
                <?php foreach ($tickets as $ticket): ?>
                    <tr>
                        <td><?php echo isset($ticket['USER_ID']) ? htmlentities($ticket['USER_ID'], ENT_QUOTES) : 'N/A'; ?></td>
                        <td><?php echo isset($ticket['FROM_STATION']) ? htmlentities($ticket['FROM_STATION'], ENT_QUOTES) : 'N/A'; ?></td>
                        <td><?php echo isset($ticket['TO_STATION']) ? htmlentities($ticket['TO_STATION'], ENT_QUOTES) : 'N/A'; ?></td>
                        <td><?php echo isset($ticket['TRAVEL_DATE']) ? htmlentities($ticket['TRAVEL_DATE'], ENT_QUOTES) : 'N/A'; ?></td>
                        <td><?php echo isset($ticket['TRAVEL_TIME']) ? htmlentities($ticket['TRAVEL_TIME'], ENT_QUOTES) : 'N/A'; ?></td>
                        <td><?php echo isset($ticket['FARE']) ? htmlentities($ticket['FARE'], ENT_QUOTES) : 'N/A'; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No tickets found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </section>





</div>
</body>
</html>
