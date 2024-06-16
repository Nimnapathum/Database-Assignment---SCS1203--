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

        

        .employee-list {
            list-style-type: none;
            padding: 0;
            max-width: 600px;
            margin: 20px auto;
        }

        .employee-list li {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .details-box {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            flex-grow: 1;
        }

        .details-box p {
            margin: 0; /* Remove default paragraph margin */
            text-align: left; /* Align text to the left */
        }

        .details-box p strong {
            display: inline-block;
            width: 160px; /* Adjust the width based on your needs */
            padding: 5px;
        }
    </style>
</head>
<body>
    <div id="container">
        <div id="menu">
            <a href="profile.php" style="color:black;">Profile</a>
            <a href="requestleaves.php">Request Leaves</a>
            <a href="markattendance.php">Mark Attendance</a>
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
            
<?php
include('./../dbconfig.php');
session_start();

// Check if the employeeID is set in the session
if (!isset($_SESSION['employeeID'])) {
    // If not set, redirect to the login page or handle accordingly
    header("Location: index.php");
    exit();
}

// Retrieve employeeID from the session
$employeeID = $_SESSION['employeeID'];

// SQL query to retrieve details from the Employee table
$sql = "SELECT * FROM Employee e 
        INNER JOIN jobroll j ON e.rollid = j.roleid 
        INNER JOIN department d ON e.departmentid = d.departmentid 
        WHERE employeeid = ?";

$stmt = $conn->prepare($sql);

// Bind the parameter
$stmt->bind_param("s", $employeeID);

// Execute the query
if ($stmt->execute()) {
    // Get the result
    $result = $stmt->get_result();

    // Check if there are rows in the result set
    if ($result->num_rows > 0) {
        echo "<div class='details-box'>";
        // Output data of each row
        $row = $result->fetch_assoc();
        echo "<p><strong>Name:</strong><b> " . $row["name"] . "</b></p>";
        echo "<p><strong>Employee ID:</strong> " . $row["employeeid"] . "</p>";
        echo "<p><strong>Address:</strong> " . $row["address"] . "</p>";
        echo "<p><strong>Gender:</strong> " . $row["gender"] . "</p>";
        echo "<p><strong>Email:</strong> " . $row["email"] . "</p>";
        echo "<p><strong>Contact No:</strong> " . $row["contactno"] . "</p>";
        echo "<p><strong>Date of Birth:</strong> " . $row["DOB"] . "</p>";
        echo "<p><strong>Manager ID:</strong> " . $row["managerid"] . "</p>";
        echo "<p><strong>Joining Date:</strong> " . $row["joiningDate"] . "</p>";
        echo "<p><strong>Department Name:</strong> " . $row["departmentName"] . "</p>";
        echo "<p><strong>Job role:</strong> " . $row["title"] . "</p></div>";
    } else {
        echo "0 results";
    }
} else {
    echo "Error executing the query: " . $stmt->error;
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

