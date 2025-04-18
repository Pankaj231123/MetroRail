

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Train Details - Metro Rail Management</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <h1>Update Train Details - Metro Rail Management</h1>
</header>

<div class="update-container">
    <h2>Update Train Details</h2>

    <form method="POST" action="updatetraintimeController.php">
    <label for="train_name">Train Name</label>
    <input type="text" id="train_name" name="train_name" required>

    <label for="status">Status</label>
    <input type="text" id="status" name="status" required>

    <label for="passengers">Passengers</label>
    <input type="text" id="passengers" name="passengers" required>

    <button type="submit">Submit</button>
    </form>


    <footer>
        <button onclick="window.location.href='employee-profile.html'">Back to Profile</button>
    </footer>
</div>

<script>
// Example function to update train details
document.getElementById('update-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const trainName = document.getElementById('train-name').value;
    const trainStatus = document.getElementById('train-status').value;
    const passengerCount = document.getElementById('passenger-count').value;

    // Here you would send the updated data to the server
    alert(`Train details updated:\nName: ${trainName}\nStatus: ${trainStatus}\nPassengers: ${passengerCount}`);
});
</script>

</body>
</html>
