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
        #containerNew {
            width: 60%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #4caf50;
            color: white;
        }

        .approve-btn {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 5px 10px;
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
            <a href="markattendance.php">Mark Attendance</a>
            <a href="payslip.php">Salary Slip</a>
            <a href="updateprofile.php">Update Profile</a>
            <div id="logoutButton" onclick="logout()">
                Logout
            </div>
        </div>
        <div id="menu">
            <a href="approveleaves.php" style="color:black;">Approve Leaves</a>
            <a href="showteam.php">Show Team</a>
            <a href="seeattendance.php">Team Attendance</a>
            <a href="hireapplicant.php">Hire Applicant</a>
            <a href="jobopening.php">Job Opening</a>
        </div>
        <div id="content">
        <div id="containerNew">      

        <?php
        // Include the database connection file
        include('./../dbconfig.php');

        // Start the session
        session_start();

        // Check if the user is logged in
        if (!isset($_SESSION['employeeID'])) {
            // Redirect to the login page or handle accordingly
            header("Location: ./../login.php");
            exit();
        }

        // Get the current user's employee ID
        $approverID = $_SESSION['employeeID'];

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["leaveID"])) {
            // Get the leave ID from the form submission
            $leaveID = $_POST["leaveID"];

            // Update the leaves table with the current user's employee ID as approver
            $updateLeaveSQL = "UPDATE leaves SET approverid = ? WHERE employeeid = ? AND approverid IS NULL";
            $stmtUpdateLeave = $conn->prepare($updateLeaveSQL);
            $stmtUpdateLeave->bind_param("ss", $approverID, $leaveID);
            $stmtUpdateLeave->execute();

            // Close the statement
            $stmtUpdateLeave->close();

            // Reload the page after updating the table
            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        }

        // Fetch leave data with approverid set to NULL
        $sql = "SELECT * FROM leaves WHERE approverid IS NULL";
        $result = $conn->query($sql);

        // Check if there are rows in the result set
        if ($result->num_rows > 0) {
            // Output the table header
            echo "<form method='post'><table>
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>";

            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['employeeid']}</td>
                        <td>{$row['startdate']}</td>
                        <td>{$row['enddate']}</td>
                        <td>{$row['type']}</td>
                        <td><button type='submit' class='approve-btn' name='leaveID' value='{$row['employeeid']}'>Approve</button></td>
                    </tr>";
            }

            // Output the table footer and close the form
            echo "</tbody></table></form>";
        } else {
            echo "No leave requests for approval.";
        }

        // Close the database connection
        $conn->close();
        ?>

    </div>
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


