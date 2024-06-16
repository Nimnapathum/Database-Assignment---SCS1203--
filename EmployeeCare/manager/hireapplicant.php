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

        .hire-button {
            background-color: #4caf50;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
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
            <a href="approveleaves.php">Approve Leaves</a>
            <a href="showteam.php">Show Team</a>
            <a href="seeattendance.php">Team Attendance</a>
            <a href="hireapplicant.php"  style="color:black;">Hire Applicant</a>
            <a href="jobopening.php">Job Opening</a>
        </div>
        <div id="content">
        <table>
            <thead>
                <tr>
                    <th>Applicant ID</th>
                    <th>Resume</th>
                    <th>Contact No</th>
                    <th>Educational Qualification</th>
                    <th>Job ID</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('./../dbconfig.php');

                // Fetch applicants with status 'NO'
                $sql = "SELECT * FROM applicant WHERE status = 'NO'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['applicantid']}</td>
                                <td>{$row['resume']}</td>
                                <td>{$row['contactno']}</td>
                                <td>{$row['eduQualify']}</td>
                                <td>{$row['jobid']}</td>
                                <td>{$row['status']}</td>
                                <td>
                                    <form action='' method='post'>
                                        <input type='hidden' name='applicantId' value='{$row['applicantid']}'>
                                        <button type='submit' class='hire-button'>Hire</button>
                                    </form>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No applicants found with status 'NO'.</td></tr>";
                }

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
include('./../dbconfig.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['applicantId'])) {
    $applicantId = $_POST['applicantId'];

    // Update status to 'YES'
    $updateSql = "UPDATE applicant SET status = 'YES' WHERE applicantid = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("s", $applicantId);

    if ($stmt->execute()) {
        header("Location: ./../index.php"); // Redirect back to the applicant list
        exit();
    } else {
        echo 'Error updating status: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
