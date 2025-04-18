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
    $user_id = htmlspecialchars($_POST['user_id'], ENT_QUOTES, 'UTF-8');
    $from_station = htmlspecialchars($_POST['from'], ENT_QUOTES, 'UTF-8');
    $to_station = htmlspecialchars($_POST['to'], ENT_QUOTES, 'UTF-8');
    $travel_date = htmlspecialchars($_POST['travel_date'], ENT_QUOTES, 'UTF-8');
    $travel_time = htmlspecialchars($_POST['travel_time'], ENT_QUOTES, 'UTF-8');
    $fare = htmlspecialchars($_POST['fare'], ENT_QUOTES, 'UTF-8');

    // Insert query (No need to insert TICKET_ID, as it auto-generates)
    $sql = "INSERT INTO TICKETS (USER_ID, FROM_STATION, TO_STATION, TRAVEL_DATE, TRAVEL_TIME, FARE) 
            VALUES (:user_id, :from_station, :to_station, TO_DATE(:travel_date, 'YYYY-MM-DD'), :travel_time, :fare)";

    // Prepare the statement
    $stmt = oci_parse($conn, $sql);

    // Bind values
    oci_bind_by_name($stmt, ':user_id', $user_id);
    oci_bind_by_name($stmt, ':from_station', $from_station);
    oci_bind_by_name($stmt, ':to_station', $to_station);
    oci_bind_by_name($stmt, ':travel_date', $travel_date);
    oci_bind_by_name($stmt, ':travel_time', $travel_time);
    oci_bind_by_name($stmt, ':fare', $fare);

    // Execute the query
    $result = oci_execute($stmt);

    if ($result) {
        echo "<script>alert('Ticket booked successfully!'); window.location.href='ticket_form.html';</script>";
    } else {
        $e = oci_error($stmt);
        echo "<script>alert('Error booking ticket: " . htmlentities($e['message'], ENT_QUOTES) . "'); window.location.href='..\user\profile.php';</script>";
    }

    // Free statement and close connection
    oci_free_statement($stmt);
    oci_close($conn);
}
?>
