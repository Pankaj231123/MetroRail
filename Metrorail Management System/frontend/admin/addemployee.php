<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            border: none;
            background-color: #28a745;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #218838;
        }

        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Add Employee</h2>
        <form action="processemplyee.php" method="POST">
            <div class="form-group">
                <label for="employee_id">Employee ID:</label>
                <input type="number" name="employee_id" id="employee_id" required>
            </div>

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" required>
            </div>

            <div class="form-group">
                <label for="salary">Salary:</label>
                <input type="number" name="salary" id="salary" required>
            </div>

            <div class="form-group">
                <label for="working_days">Working Days:</label>
                <input type="text" name="working_days" id="working_days" required>
            </div>

            <div class="form-group">
                <label for="working_hours">Working Hours:</label>
                <input type="text" name="working_hours" id="working_hours" required>
            </div>

            <button type="submit">Add Employee</button>
        </form>
    </div>

</body>
</html>
