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

// Get the user ID from the query parameter
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid User ID.");
}

$userId = $_GET['id'];

// Fetch the user's current details
$sql = "SELECT * FROM USERS WHERE ID = :id";
$statement = oci_parse($conn, $sql);
oci_bind_by_name($statement, ':id', $userId);

if (oci_execute($statement)) {
    $user = oci_fetch_assoc($statement);
    if (!$user) {
        die("User not found.");
    }
} else {
    $error = oci_error($statement);
    die("Error fetching user details: " . htmlentities($error['message'], ENT_QUOTES));
}
oci_free_statement($statement);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone_number'];
    $password = $_POST['password'];

    // Update the user in the database
    $updateSql = "UPDATE USERS 
                  SET USERNAME = :username, EMAIL = :email, PHONE_NUMBER = :phone_number, PASSWORD = :password 
                  WHERE ID = :id";
    $updateStmt = oci_parse($conn, $updateSql);

    oci_bind_by_name($updateStmt, ':username', $username);
    oci_bind_by_name($updateStmt, ':email', $email);
    oci_bind_by_name($updateStmt, ':phone_number', $phoneNumber);
    oci_bind_by_name($updateStmt, ':password', $password);
    oci_bind_by_name($updateStmt, ':id', $userId);

    if (oci_execute($updateStmt)) {
        echo "<script>alert('User updated successfully!'); window.location.href = 'admin.php';</script>";
    } else {
        $error = oci_error($updateStmt);
        echo "Error updating user: " . htmlentities($error['message'], ENT_QUOTES);
    }
    oci_free_statement($updateStmt);
}

oci_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form label {
            display: block;
            margin-bottom: 5px;
        }

        form input[type="text"],
        form input[type="email"],
        form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        form button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }

        form button:hover {
            background-color: #4cae4c;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit User</h2>
        <form method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?php echo htmlentities($user['USERNAME'], ENT_QUOTES); ?>" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlentities($user['EMAIL'], ENT_QUOTES); ?>" required>

            <label for="phone_number">Phone Number</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlentities($user['PHONE_NUMBER'], ENT_QUOTES); ?>" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" value="<?php echo htmlentities($user['PASSWORD'], ENT_QUOTES); ?>" required>

            <button type="submit">Save Changes</button>
        </form>
        <a href="admin.php">Back to Admin Panel</a>
    </div>
</body>
</html>
