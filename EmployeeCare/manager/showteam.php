<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 30px;
            background-color: #6693f5;
        }

        #container {
            width: 75%;
            margin: 0 auto;
            background-color: #fff;
            display: flex;
            flex-direction: column;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #4caf50;
            color: white;
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
            <a href="approveleaves.php">Approve Leaves</a>
            <a href="showteam.php" style="color:black;">Show Team</a>
            <a href="seeattendance.php">Team Attendance</a>
            <a href="hireapplicant.php">Hire Applicant</a>
            <a href="jobopening.php">Job Opening</a>
        </div>
        <div id="content">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Employee ID</th>
                        <th>Joining Date</th>
                        <th>Department</th>
                        <th>Job Role</th>
                        <th>E-mail</th>
                        <th>Contact No</th>
                    </tr>
                </thead>
                <tbody>
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
                    $managerID = $_SESSION['employeeID'];

                    // Fetch employees where managerid matches the session variable
                    $sql = "SELECT * FROM Employee e 
                    INNER JOIN jobroll j ON e.rollid = j.roleid 
                    INNER JOIN department d ON e.departmentid = d.departmentid 
                    WHERE managerid = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $managerID);
                    $stmt->execute();

                    $result = $stmt->get_result();

                    // Check if there are rows in the result set
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['name']}</td>
                                    <td>{$row['employeeid']}</td>
                                    <td>{$row['joiningDate']}</td>
                                    <td>{$row['departmentName']}</td>
                                    <td>{$row['title']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$row['contactno']}</td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No employees found.</td></tr>";
                    }

                    // Close the database connection
                    $conn->close();
                    ?>
                </tbody>
            </table>
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
