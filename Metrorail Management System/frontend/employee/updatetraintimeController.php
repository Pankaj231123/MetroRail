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
    $train_name = isset($_POST['train_name']) ? trim(htmlspecialchars($_POST['train_name'], ENT_QUOTES, 'UTF-8')) : null;
    $status = isset($_POST['status']) ? trim(htmlspecialchars($_POST['status'], ENT_QUOTES, 'UTF-8')) : null;
    $passengers = isset($_POST['passengers']) ? trim($_POST['passengers']) : null;

    // Validate inputs
    if ($train_name === '' || $status === '' || $passengers === '' || !is_numeric($passengers)) {
        echo "<script>alert('All fields are required and passengers must be a number!'); window.location.href='train_form.html';</script>";
        exit;
    }

    // Convert passengers to an integer
    $passengers = (int) $passengers;

    // Insert query
    $sql = "INSERT INTO TRAINS (NAME, STATUS, PASSENGERS) 
            VALUES (:train_name, :status, :passengers)";

    // Prepare the statement
    $stmt = oci_parse($conn, $sql);

    // Bind values
    oci_bind_by_name($stmt, ':train_name', $train_name);
    oci_bind_by_name($stmt, ':status', $status);
    oci_bind_by_name($stmt, ':passengers', $passengers);

    // Execute the query
    $result = oci_execute($stmt);

    if ($result) {
        echo "<script>alert('Train added successfully!'); window.location.href='train_form.html';</script>";
    } else {
        $e = oci_error($stmt);
        echo "<script>alert('Error adding train: " . htmlentities($e['message'], ENT_QUOTES) . "'); window.location.href='train_form.html';</script>";
    }

    // Free statement and close connection
    oci_free_statement($stmt);
    oci_close($conn);
}
?>
