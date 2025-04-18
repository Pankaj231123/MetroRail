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

// Check if the train ID is passed
if (isset($_GET['id'])) {
    $train_id = $_GET['id'];

    // Delete query
    $delete_sql = "DELETE FROM TRAINS WHERE TRAIN_ID = :train_id";
    $delete_stmt = oci_parse($conn, $delete_sql);
    oci_bind_by_name($delete_stmt, ':train_id', $train_id);

    // Execute the delete query
    $result = oci_execute($delete_stmt);

    if ($result) {
        echo "<script>alert('Train deleted successfully!'); window.location.href='train_list.php';</script>";
    } else {
        $e = oci_error($delete_stmt);
        echo "<script>alert('Error deleting train: " . htmlentities($e['message'], ENT_QUOTES) . "'); window.location.href='train_list.php';</script>";
    }

    oci_free_statement($delete_stmt);
} else {
    echo "<script>alert('No train ID provided!'); window.location.href='train_list.php';</script>";
    exit;
}

// Close the connection
oci_close($conn);
?>
