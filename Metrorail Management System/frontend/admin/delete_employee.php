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

    // Delete query
    $deleteQuery = "DELETE FROM EMPLOYEES WHERE EMPLOYEE_ID = :id";
    $stmt = oci_parse($conn, $deleteQuery);
    oci_bind_by_name($stmt, ':id', $employee_id);

    if (oci_execute($stmt)) {
        oci_free_statement($stmt);
        oci_close($conn);
        header("Location: admin.php#employees");
        exit;
    } else {
        $error = oci_error($stmt);
        die("Failed to delete employee: " . htmlentities($error['message'], ENT_QUOTES));
    }
} else {
    die("Invalid request.");
}
?>
