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

// Check if the user ID is passed
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Delete tickets associated with the user
    $delete_tickets_sql = "DELETE FROM TICKETS WHERE USER_ID = :user_id";
    $delete_tickets_stmt = oci_parse($conn, $delete_tickets_sql);
    oci_bind_by_name($delete_tickets_stmt, ':user_id', $user_id);

    // Execute the delete query for tickets
    $tickets_result = oci_execute($delete_tickets_stmt);
    if (!$tickets_result) {
        $e = oci_error($delete_tickets_stmt);
        echo "<script>alert('Error deleting associated tickets: " . htmlentities($e['message'], ENT_QUOTES) . "'); window.location.href='user_list.php';</script>";
        oci_free_statement($delete_tickets_stmt);
        oci_close($conn);
        exit;
    }
    oci_free_statement($delete_tickets_stmt);

    // Now delete the user
    $delete_user_sql = "DELETE FROM USERS WHERE ID = :user_id";
    $delete_user_stmt = oci_parse($conn, $delete_user_sql);
    oci_bind_by_name($delete_user_stmt, ':user_id', $user_id);

    // Execute the delete query for the user
    $user_result = oci_execute($delete_user_stmt);

    if ($user_result) {
        echo "<script>alert('User and associated tickets deleted successfully!'); window.location.href='user_list.php';</script>";
    } else {
        $e = oci_error($delete_user_stmt);
        echo "<script>alert('Error deleting user: " . htmlentities($e['message'], ENT_QUOTES) . "'); window.location.href='user_list.php';</script>";
    }

    oci_free_statement($delete_user_stmt);
} else {
    echo "<script>alert('No user ID provided!'); window.location.href='user_list.php';</script>";
    exit;
}

// Close the connection
oci_close($conn);
?>
