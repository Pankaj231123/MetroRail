<?php
// Start the session
session_start();

// Database connection
$conn = oci_connect('METRO', 'PROJECT', 'localhost/XE', 'AL32UTF8');
if (!$conn) {
    $e = oci_error();
    die("Database connection failed: " . htmlentities($e['message'], ENT_QUOTES));
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $employee_id = htmlspecialchars($_POST['employee_id'], ENT_QUOTES, 'UTF-8');
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $salary = htmlspecialchars($_POST['salary'], ENT_QUOTES, 'UTF-8');
    $working_days = htmlspecialchars($_POST['working_days'], ENT_QUOTES, 'UTF-8');
    $working_hours = htmlspecialchars($_POST['working_hours'], ENT_QUOTES, 'UTF-8');

    // Insert query
    $sql = "INSERT INTO EMPLOYEES (EMPLOYEE_ID, NAME, SALARY, WORKING_DAYS, WORKING_HOURS) 
            VALUES (:employee_id, :name, :salary, :working_days, :working_hours)";

    // Prepare the statement
    $stmt = oci_parse($conn, $sql);

    // Bind values
    oci_bind_by_name($stmt, ':employee_id', $employee_id);
    oci_bind_by_name($stmt, ':name', $name);
    oci_bind_by_name($stmt, ':salary', $salary);
    oci_bind_by_name($stmt, ':working_days', $working_days);
    oci_bind_by_name($stmt, ':working_hours', $working_hours);

    // Execute the query
    $result = oci_execute($stmt);

    if ($result) {
        echo "<script>alert('Employee added successfully!'); window.location.href='employee_form.html';</script>";
    } else {
        $e = oci_error($stmt);
        echo "<script>alert('Error adding employee: " . htmlentities($e['message'], ENT_QUOTES) . "'); window.location.href='..\user\profile.php';</script>";
    }

    // Free statement and close connection
    oci_free_statement($stmt);
    oci_close($conn);
}
?>
