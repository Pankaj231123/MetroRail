<?php
// Database connection variables
$host = 'localhost'; // or 127.0.0.1
$port = '1521';      // Default Oracle port
$sid = 'XE';         // Service Identifier (SID)
$username = 'METRO'; // Your Oracle username
$password = 'PROJECT'; // Your Oracle password

// Connection string for Oracle
$conn = oci_connect($username, $password, "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=$host)(PORT=$port))(CONNECT_DATA=(SID=$sid)))");

// Check if the connection is successful
if (!$conn) {
    $e = oci_error();
    echo 'Failed to connect to Oracle: ' . htmlentities($e['message'], ENT_QUOTES);
} else {
    echo 'Connection successful!';
    oci_close($conn); // Close the connection after validation
}
?>
