<!DOCTYPE html>
<html>
<head>
    <title>Employee Care</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #6693f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-box {
            width: 400px;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .login-box h2 {
            margin: 0 0 20px;
        }

        .login-box input[type="text"],
        .login-box input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: white;
        }

        .login-box input[type="submit"] {
            background: #007BFF;
            color: #000000;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
        }

    </style>
    
</head>
<body>
    <div class="login-box">
        <h2>EmployeeCare Login</h2>
        <form action="checkvalidity.php" method="post">
            <input type="text" name="username" placeholder="Employee ID" required>
            <input type="submit" value="Login">
            <h5><a href="applicant.php">Apply for a Job</a></h5>
        </form>
    </div>
</body>
</html>
