<php
 include 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background: #ffffff;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 350px;
        }

        .login-container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .login-container label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .login-container input:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            border: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
        }

        .login-container button:hover {
            background: #0056b3;
        }

        .login-container p {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
            color: #555;
        }

        .login-container p a {
            color: #007bff;
            text-decoration: none;
        }

        .login-container p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <script src="scripts/login.js"></script>
    <div class="login-container">
        <h2>Log In</h2>
        <form method="POST" action="/Metrorail%20Management%20System/backend/user/adminlogin.php">
            <label for="email">Email or Phone Number</label>
            <input type="email" id="email" name="email" required>
        
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        
            <button type="submit">Log In</button>
        </form>
        

 
    </div>
</body>
</html>
