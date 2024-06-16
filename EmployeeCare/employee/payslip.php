<!DOCTYPE html>
<html>
<head>
    <title>PHP Box Example</title>
    <style>
        body {
            margin: 20px;
            padding: 30px;
            background-color: #6693f5;
            font-family: Arial, sans-serif;
        }

        #container {
            width: 75%;
            height: 75vh; /* 75% of the viewport height */
            margin: 0 auto;
            background-color: #fff;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        #menu {
            background-color: #6693f5;
            color: white;
            display: flex;
        }

        #menu a {
            text-decoration: none;
            color: white;
            padding: 10px 30px;
            cursor: pointer;
        }

        #logoutButton {
            color:black;
            margin-left: auto;
            padding: 10px 30px;
            cursor: pointer;
        }

        #content {
            flex: 1;
            padding: 20px;
        }

        .pay-slip {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
        }

        .pay-slip h2 {
            text-align: center;
            color: #333;
        }

        .pay-slip table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .pay-slip th, .pay-slip td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .pay-slip th {
            background-color: #f2f2f2;
        }

        .pay-slip .total {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div id="container">
        <div id="menu">
            <a href="profile.php">Profile</a>
            <a href="requestleaves.php">Request Leaves</a>
            <a href="markattendance.php">Mark Attendance</a>
            <a href="payslip.php" style="color:black;">Salary Slip</a>
            <a href="updateprofile.php">Update Profile</a>
            <div id="logoutButton" onclick="logout()">
                Logout
            </div>
        </div>
        <div id="content">
        <?php
include('./../dbconfig.php');
session_start();

// Check if the employeeID is set in the session
if (!isset($_SESSION['employeeID'])) {
    // If not set, redirect to the login page or handle accordingly
    header("Location: ./../index.php");
    exit();
}

// Retrieve employeeID from the session
$employeeID = $_SESSION['employeeID'];

// SQL query to retrieve salary details from the Salary table
$sql = "SELECT * FROM salary WHERE employeeid = ?";

$stmt = $conn->prepare($sql);

// Bind the parameter
$stmt->bind_param("s", $employeeID);

// Execute the query
$stmt->execute();

// Get the result
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Display pay slip
    echo '<div class="pay-slip">';
    echo '<h2>Pay Slip</h2>';
    echo '<table>';
    echo '<tr><th>Salary ID</th><td>' . $row['salaryid'] . '</td></tr>';
    echo '<tr><th>Employee ID</th><td>' . $row['employeeid'] . '</td></tr>';
    echo '<tr><th>Salary Amount</th><td>$' . number_format($row['salaryAmount'], 2) . '</td></tr>';
    echo '<tr><th>Allowance</th><td>$' . number_format($row['allowance'], 2) . '</td></tr>';
    echo '<tr><th>Bonus</th><td>$' . number_format($row['bonus'], 2) . '</td></tr>';
    echo '</table>';
    echo '</div>';
} else {
    echo '<p>No salary details found for the employee.</p>';
}

// Close the statement
$stmt->close();

// Close the database connection
$conn->close();
?>
        </div>
    </div>

    <script>
        function logout() {
            // You can add any additional logout logic here
            window.location.href = './../index.php';
        }
    </script>
</body>
</html>
