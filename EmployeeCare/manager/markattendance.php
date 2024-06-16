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
            padding: 10px;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 5px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: white;
            padding: 5px 15px;
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
            <a href="requestleaves.php">Request Leaves</a>
            <a href="markattendance.php" style="color:black;">Mark Attendance</a>
            <a href="payslip.php">Salary Slip</a>
            <a href="updateprofile.php">Update Profile</a>
            <div id="logoutButton" onclick="logout()">
                Logout
            </div>
        </div>
        <div id="menu">
            <a href="approveleaves.php">Approve Leaves</a>
            <a href="showteam.php">Show Team</a>
            <a href="seeattendance.php">Team Attendance</a>
            <a href="hireapplicant.php">Hire Applicant</a>
            <a href="jobopening.php">Job Opening</a>
        </div>
        <div id="content">
            
<form action="" method="post">
    <label for="arrivalhour">Arrival Hour:</label>
    <input type="number" id="arrivalhour" name="arrivalhour" min="0" max="24" required>

    <label for="arrivalminute">Arrival Minute:</label>
    <input type="number" id="arrivalminute" name="arrivalminute" min="0" max="59" required>

    <label for="departurehour">Departure Hour:</label>
    <input type="number" id="departurehour" name="departurehour" min="0" max="24" required>

    <label for="departureminute">Departure Minute:</label>
    <input type="number" id="departureminute" name="departureminute" min="0" max="59" required>

    <button type="submit">Submit Attendance</button>
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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted data
    $employeeID = $_SESSION['employeeID'];
    $attendanceDate = date("Y-m-d"); // Current date
    $arrivalHour = $_POST["arrivalhour"];
    $arrivalMinute = $_POST["arrivalminute"];
    $departureHour = $_POST["departurehour"];
    $departureMinute = $_POST["departureminute"];

    // Check if attendance for the current date already exists
    $checkAttendanceSQL = "SELECT * FROM attendance WHERE employeeid = ? AND attendancedate = ?";
    $stmtCheckAttendance = $conn->prepare($checkAttendanceSQL);
    $stmtCheckAttendance->bind_param("ss", $employeeID, $attendanceDate);
    $stmtCheckAttendance->execute();

    $resultCheckAttendance = $stmtCheckAttendance->get_result();

    if ($resultCheckAttendance->num_rows > 0) {
        echo "Attendance for the current date already submitted.";
    } else {
        // Insert the attendance record into the attendance table
        $insertAttendanceSQL = "INSERT INTO attendance (employeeid, attendancedate, arrivaltimehour, arrivaltimeminiute, departuretimehour, departuretimeminiute) VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmtInsertAttendance = $conn->prepare($insertAttendanceSQL);
        $stmtInsertAttendance->bind_param("ssiiii", $employeeID, $attendanceDate, $arrivalHour, $arrivalMinute, $departureHour, $departureMinute);
        $stmtInsertAttendance->execute();

        echo "Attendance submitted successfully!";

        $stmtCheckAttendance->close();
        $stmtInsertAttendance->close();
    }

    // Close the statements
    
}

// Close the database connection
$conn->close();
?>
