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

        #menuTop {
            background-color: #6693f5;
            color: white;
            display: flex;
        }

        #menuTop a {
            text-decoration: none;
            color: white;
            padding: 10px 30px;
            cursor: pointer;
        }

        #menuBottom {
            background-color: #6693f5;
            color: white;
            display: flex;
        }

        #menuBottom a {
            text-decoration: none;
            color: white;
            padding: 10px 30px;
            cursor: pointer;
        }

        #logoutButton {
            color: black;
            margin-left: auto;
            padding: 10px 30px;
            cursor: pointer;
        }

        #content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        table {
            width: 80%;
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

        .open-button {
            background-color: #4caf50;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .close-button {
            background-color: #ff5252;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div id="container">
        <div id="menuTop">
            <a href="profile.php">Profile</a>
            <a href="requestleaves.php">Request Leaves</a>
            <a href="markattendance.php">Mark Attendance</a>
            <a href="payslip.php">Salary Slip</a>
            <a href="updateprofile.php">Update Profile</a>
            <div id="logoutButton" onclick="logout()">
                Logout
            </div>
        </div>
        <div id="menuBottom">
            <a href="approveleaves.php">Approve Leaves</a>
            <a href="showteam.php">Show Team</a>
            <a href="seeattendance.php">Team Attendance</a>
            <a href="hireapplicant.php">Hire Applicant</a>
            <a href="jobopening.php" style="color: black;">Job Opening</a>
        </div>
        <div id="content">
            <table>
                <thead>
                    <tr>
                        <th>Role ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Department ID</th>
                        <th>Action</th>
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

                    // Get the current user's employee ID and role
                    $employeeID = $_SESSION['employeeID'];
                    // Fetch the rollid from the Employee table based on the employeeID
                    $sqlGetRole = "SELECT rollid FROM Employee WHERE employeeid = ?";
                    $stmtGetRole = $conn->prepare($sqlGetRole);
                    $stmtGetRole->bind_param("s", $employeeID);
                    $stmtGetRole->execute();
                    $resultGetRole = $stmtGetRole->get_result();

                    // Check if there are rows in the result set
                    if ($resultGetRole->num_rows > 0) {
                        $rowGetRole = $resultGetRole->fetch_assoc();
                        $employeeRole = $rowGetRole['rollid'];
                    } else {
                        // Handle the case where rollid is not found
                        echo "Error: Roll ID not found for the given Employee ID.";
                    }

                    // Close the statement for fetching rollid
                    $stmtGetRole->close();

                    // Check if the user's role is "HRM"
                    if ($employeeRole == 'HRM') {
                        // Fetch job details from the jobroll table
                        $sql = "SELECT * FROM jobroll";
                        $result = $conn->query($sql);

                        // Check if there are rows in the result set
                        if ($result->num_rows > 0) {
                            // Output data of each row
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['roleid']}</td>
                                        <td>{$row['title']}</td>
                                        <td>{$row['description']}</td>
                                        <td>{$row['departmentid']}</td>
                                        <td>";

                                if ($row['jobopening'] == 'NO') {
                                    echo "<form method='post' action=''>
                                            <input type='hidden' name='roleid' value='{$row['roleid']}'>
                                            <button type='submit' class='open-button'>Open</button>
                                        </form>";
                                } else {
                                    echo "<form method='post' action=''>
                                            <input type='hidden' name='roleid' value='{$row['roleid']}'>
                                            <button type='submit' class='close-button'>Close</button>
                                        </form>";
                                }

                                echo "</td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No job roles found.</td></tr>";
                        }
                    } else {
                        // Display a message or redirect to another page for users with roles other than "HRM"
                        echo "<p>You do not have permission to view this page.</p>";
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

<?php
// Include the database connection file
include('./../dbconfig.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form data
    $roleid = sanitize_input($_POST["roleid"]);

    // Fetch the current jobopening status
    $sqlSelect = "SELECT jobopening FROM jobroll WHERE roleid = ?";
    $stmtSelect = $conn->prepare($sqlSelect);
    $stmtSelect->bind_param("s", $roleid);
    $stmtSelect->execute();
    $resultSelect = $stmtSelect->get_result();

    // Check if there are rows in the result set
    if ($resultSelect->num_rows > 0) {
        $row = $resultSelect->fetch_assoc();
        $currentStatus = $row['jobopening'];

        // Update the jobopening status
        $newStatus = ($currentStatus == 'NO') ? 'YES' : 'NO';

        $sqlUpdate = "UPDATE jobroll SET jobopening = ? WHERE roleid = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("ss", $newStatus, $roleid);

        // Execute the query
        if ($stmtUpdate->execute()) {
            echo "Job Opening status updated successfully!";
        } else {
            echo "Error updating Job Opening status: " . $stmtUpdate->error;
        }

        // Close the statement
        $stmtUpdate->close();
    } else {
        echo "Job role not found.";
    }

    // Close the statement for SELECT
    $stmtSelect->close();
}

// Close the database connection
$conn->close();

// Function to sanitize input data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
