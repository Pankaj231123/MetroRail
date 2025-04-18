<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Ticket</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="form-container">
        <h2>Book Your Ticket</h2>
        <form action="process_ticket.php" method="POST">
            
            <label for="user_id">User ID:</label>
            <input type="number" id="user_id" name="user_id" required>

            <label for="from_station">From Station:</label>
            <select id="from" name="from" required>
            <option value="uttaraNorth">Uttara North</option>
            <option value="uttaraSouth">Uttara South</option>
            <option value="jasimuddin">Jasimuddin</option>
            <option value="shahjalalUniversity">Shahjalal University of Science and Technology</option>
            <option value="mirpur12">Mirpur-12</option>
            <option value="mirpur10">Mirpur-10</option>
            <option value="agargaon">Agargaon</option>
            <option value="farmgate">Farmgate</option>
            <option value="shaplaChattar">Shapla Chattar</option>
            <option value="banglamotor">Banglamotor</option>
            <option value="shahbagh">Shahbagh</option>
            <option value="dhakaUniversity">Dhaka University</option>
            <option value="motijheel">Motijheel</option>
            <option value="kamalapur">Kamalapur</option>
            </select>

            <label for="to_station">To Station:</label>
            <select id="to" name="to" required>
            <option value="uttaraNorth">Uttara North</option>
            <option value="uttaraSouth">Uttara South</option>
            <option value="jasimuddin">Jasimuddin</option>
            <option value="shahjalalUniversity">Shahjalal University of Science and Technology</option>
            <option value="mirpur12">Mirpur-12</option>
            <option value="mirpur10">Mirpur-10</option>
            <option value="agargaon">Agargaon</option>
            <option value="farmgate">Farmgate</option>
            <option value="shaplaChattar">Shapla Chattar</option>
            <option value="banglamotor">Banglamotor</option>
            <option value="shahbagh">Shahbagh</option>
            <option value="dhakaUniversity">Dhaka University</option>
            <option value="motijheel">Motijheel</option>
            <option value="kamalapur">Kamalapur</option>
        <   <select>

            <label for="travel_date">Travel Date:</label>
            <input type="date" id="travel_date" name="travel_date" required>

            <label for="travel_time">Travel Time:</label>
            <input type="time" id="travel_time" name="travel_time" required>

            <label for="fare">Fare ($):</label>
            <input type="number" id="fare" name="fare" step="0.01" required>

            <button type="submit">Book Ticket</button>
        </form>
    </div>

</body>
</html>
