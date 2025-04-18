<?php
// Start the session
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Prevent caching of this page
header("Cache-Control: no-cache, no-store, must-revalidate"); // Prevent caching
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Ensure the page is considered expired

// Redirect to the login page after logout
header("Location: login.php");
exit;
?>
