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
        
        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div id="container">
        <div id="menu">
            <a href="profile.php">Profile</a>
            <a href="requestleaves.php" style="color:black;">Request Leaves</a>
            <a href="markattendance.php">Mark Attendance</a>
            <a href="payslip.php">Salary Slip</a>
            <a href="updateprofile.php">Update Profile</a>
            <div id="logoutButton" onclick="logout()">
                Logout
            </div>
        </div>
        <div id="content">
            
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="startdate">Start Date:</label>
    <input type="date" id="startdate" name="startdate" required>

    <label for="enddate">End Date:</label>
    <input type="date" id="enddate" name="enddate" required>

    <label for="type">Leave Type:</label>
    <select id="type" name="type" required>
        <option value="Vacation">Vacation</option>
        <option value="Sick">Sick</option>
        <option value="Personal">Personal</option>
        <!-- Add more options as needed -->
    </select>

    <button type="submit">Submit</button>
</form>
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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted data
    $startDate = $_POST["startdate"];
    $endDate = $_POST["enddate"];
    $leaveType = $_POST["type"];

    // Validate and sanitize the input data (you should add more validation as needed)
    $startDate = htmlspecialchars($startDate);
    $endDate = htmlspecialchars($endDate);
    $leaveType = htmlspecialchars($leaveType);

    // Check if there are previous records for the employee
    $checkPreviousRecordsSQL = "SELECT leavebalance FROM leaves WHERE employeeid = ? ORDER BY startdate DESC LIMIT 1";

    $stmtPreviousRecords = $conn->prepare($checkPreviousRecordsSQL);
    $stmtPreviousRecords->bind_param("s", $employeeID);
    $stmtPreviousRecords->execute();

    $resultPreviousRecords = $stmtPreviousRecords->get_result();

    if ($resultPreviousRecords->num_rows > 0) {
        // If there are previous records, fetch the leave balance
        $row = $resultPreviousRecords->fetch_assoc();
        $leaveBalance = $row['leavebalance'] - 1;
    } else {
        // If no previous records, set the leave balance to 5
        $leaveBalance = 5;
    }

    // Check if the leave balance is sufficient
    if ($leaveBalance > 0) {
        // Insert the leave record into the leaves table
        $insertLeaveSQL = "INSERT INTO leaves (employeeid, startdate, enddate, type, leavebalance) VALUES (?, ?, ?, ?, ?)";
        
        $stmtInsertLeave = $conn->prepare($insertLeaveSQL);
        $stmtInsertLeave->bind_param("ssssi", $employeeID, $startDate, $endDate, $leaveType, $leaveBalance);
        $stmtInsertLeave->execute();

        echo "Leave request submitted successfully!";
    } else {
        echo "You don't have enough leave balance.";
    }

    // Close the statements
    $stmtPreviousRecords->close();
    $stmtInsertLeave->close();
}

// Close the database connection
$conn->close();
?>


