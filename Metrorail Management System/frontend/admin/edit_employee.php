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

// Check if the employee ID is passed
if (isset($_GET['id'])) {
    $employee_id = $_GET['id'];

    // Fetch employee details
    $query = "SELECT * FROM EMPLOYEES WHERE EMPLOYEE_ID = :id";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ':id', $employee_id);
    oci_execute($stmt);
    $employee = oci_fetch_assoc($stmt);
    oci_free_statement($stmt);

    if (!$employee) {
        die("Employee not found.");
    }
} else {
    die("Invalid request.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $salary = $_POST['salary'];
    $working_days = $_POST['working_days'];
    $working_hours = $_POST['working_hours'];

    $updateQuery = "UPDATE EMPLOYEES 
                    SET NAME = :name, SALARY = :salary, WORKING_DAYS = :working_days, WORKING_HOURS = :working_hours 
                    WHERE EMPLOYEE_ID = :id";
    $updateStmt = oci_parse($conn, $updateQuery);

    oci_bind_by_name($updateStmt, ':name', $name);
    oci_bind_by_name($updateStmt, ':salary', $salary);
    oci_bind_by_name($updateStmt, ':working_days', $working_days);
    oci_bind_by_name($updateStmt, ':working_hours', $working_hours);
    oci_bind_by_name($updateStmt, ':id', $employee_id);

    if (oci_execute($updateStmt)) {
        oci_free_statement($updateStmt);
        oci_close($conn);
        header("Location: admin.php#employees");
        exit;
    } else {
        $error = oci_error($updateStmt);
        die("Failed to update employee: " . htmlentities($error['message'], ENT_QUOTES));
    }
}
oci_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f1f1f1;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 400px;
        max-width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        box-sizing: border-box; /* Ensure padding is included in the width */
    }

    h1 {
        font-size: 24px;
        color: #333;
        margin-bottom: 20px;
        text-align: center;
    }

    label {
        display: block;
        font-size: 16px;
        color: #555;
        margin-bottom: 8px;
        width: 100%; /* Ensure labels align with input fields */
    }

    input[type="text"],
    input[type="number"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 20px;
        font-size: 14px;
        box-sizing: border-box;
    }

    input[type="text"]:focus,
    input[type="number"]:focus {
        border-color: #94bbc2;
        outline: none;
        box-shadow: 0 0 5px rgba(148, 187, 194, 0.5);
    }

    button {
        width: 100%;
        background-color: #94bbc2;
        color: #fff;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        padding: 12px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #77a3a9;
    }



        </style>
</head>
<body>
    <div class="container">
    <h1>Edit Employee</h1>
    <form method="POST">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="<?php echo htmlentities($employee['NAME'], ENT_QUOTES); ?>" required><br><br>

        <label for="salary">Salary:</label><br>
        <input type="number" id="salary" name="salary" value="<?php echo htmlentities($employee['SALARY'], ENT_QUOTES); ?>" required><br><br>

        <label for="working_days">Working Days:</label><br>
        <input type="number" id="working_days" name="working_days" value="<?php echo htmlentities($employee['WORKING_DAYS'], ENT_QUOTES); ?>" required><br><br>

        <label for="working_hours">Working Hours:</label><br>
        <input type="number" id="working_hours" name="working_hours" value="<?php echo htmlentities($employee['WORKING_HOURS'], ENT_QUOTES); ?>" required><br><br>

        <button type="submit">Update Employee</button>
    </form>
</body>
</html>
