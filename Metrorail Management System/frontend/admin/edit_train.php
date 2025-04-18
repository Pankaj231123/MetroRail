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

    // Fetch the current train data
    $sql = "SELECT TRAIN_ID, NAME, STATUS, PASSENGERS FROM TRAINS WHERE TRAIN_ID = :train_id";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':train_id', $train_id);
    oci_execute($stmt);

    // Check if the train exists
    $train = oci_fetch_assoc($stmt);

    if (!$train) {
        echo "<script>alert('Train not found!'); window.location.href='train_list.php';</script>";
        exit;
    }

    oci_free_statement($stmt);
} else {
    echo "<script>alert('No train ID provided!'); window.location.href='train_list.php';</script>";
    exit;
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $train_name = isset($_POST['train_name']) ? trim(htmlspecialchars($_POST['train_name'], ENT_QUOTES, 'UTF-8')) : '';
    $status = isset($_POST['status']) ? trim(htmlspecialchars($_POST['status'], ENT_QUOTES, 'UTF-8')) : '';
    $passengers = isset($_POST['passengers']) ? (int) $_POST['passengers'] : null;

    // Validate inputs
    if (empty($train_name) || empty($status) || $passengers === null) {
        echo "<script>alert('All fields are required!');</script>";
    } else {
        // Update query
        $update_sql = "UPDATE TRAINS SET NAME = :train_name, STATUS = :status, PASSENGERS = :passengers WHERE TRAIN_ID = :train_id";
        $update_stmt = oci_parse($conn, $update_sql);

        // Bind values
        oci_bind_by_name($update_stmt, ':train_name', $train_name);
        oci_bind_by_name($update_stmt, ':status', $status);
        oci_bind_by_name($update_stmt, ':passengers', $passengers);
        oci_bind_by_name($update_stmt, ':train_id', $train_id);

        // Execute the update query
        $result = oci_execute($update_stmt);

        if ($result) {
            echo "<script>alert('Train details updated successfully!'); window.location.href='train_list.php';</script>";
        } else {
            $e = oci_error($update_stmt);
            echo "<script>alert('Error updating train: " . htmlentities($e['message'], ENT_QUOTES) . "');</script>";
        }

        oci_free_statement($update_stmt);
    }
}

// Close the connection
oci_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Train</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
        }

        h2 {
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-group button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        .form-group button:hover {
            background-color: #45a049;
        }

        .back-button {
            text-align: center;
            margin-top: 20px;
        }

        .back-button a {
            text-decoration: none;
            padding: 10px 15px;
            background-color: #f1f1f1;
            color: #333;
            border-radius: 5px;
        }

        .back-button a:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Edit Train</h2>

    <form method="POST">
        <div class="form-group">
            <label for="train_name">Train Name</label>
            <input type="text" id="train_name" name="train_name" value="<?php echo isset($train['NAME']) ? htmlentities($train['NAME'], ENT_QUOTES) : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <input type="text" id="status" name="status" value="<?php echo isset($train['STATUS']) ? htmlentities($train['STATUS'], ENT_QUOTES) : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="passengers">Passengers</label>
            <input type="number" id="passengers" name="passengers" value="<?php echo isset($train['PASSENGERS']) ? htmlentities($train['PASSENGERS'], ENT_QUOTES) : ''; ?>" required>
        </div>

        <div class="form-group">
            <button type="submit">Update Train</button>
        </div>
    </form>

    <div class="back-button">
        <a href="train_list.php">Back to Train List</a>
    </div>
</div>

</body>
</html>
