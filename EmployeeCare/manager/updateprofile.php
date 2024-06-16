<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        body {
            margin: 20px;
            padding: 30px;
            background-color: #6693f5;
            font-family: Arial, sans-serif;
        }

        #container {
            width: 75%;
            height: 75vh;
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
            overflow-y: auto;
        }

        .details-box {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-top: 20px;
        }

        .details-box label {
            display: block;
            margin-bottom: 10px;
        }

        .details-box input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        .details-box button {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px 20px;
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
            <a href="updateprofile.php" style="color:black;">Update Profile</a>
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
                header("Location: ./../index.php");
                exit();
            }

            // Retrieve employeeID from the session
            $employeeID = $_SESSION['employeeID'];

            // Initialize variables for form submission
            $name = $address = $gender = $email = $contactno = $DOB = "";

            // Check if the form is submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Sanitize and validate form data
                $name = sanitize_input($_POST["name"]);
                $address = sanitize_input($_POST["address"]);
                $gender = sanitize_input($_POST["gender"]);
                $email = sanitize_input($_POST["email"]);
                $contactno = sanitize_input($_POST["contactno"]);
                $DOB = sanitize_input($_POST["DOB"]);

                // SQL query to update employee details
                $updateSQL = "UPDATE Employee SET name=?, address=?, gender=?, email=?, contactno=?, DOB=? WHERE employeeid=?";
                $stmt = $conn->prepare($updateSQL);
                $stmt->bind_param("sssssss", $name, $address, $gender, $email, $contactno, $DOB, $employeeID);

                // Execute the query
                if ($stmt->execute()) {
                    echo "<p>Profile updated successfully!</p>";
                } else {
                    echo "<p>Error updating profile: " . $stmt->error . "</p>";
                }

                // Close the statement
                $stmt->close();
            }

            // SQL query to retrieve details from the Employee table
            $selectSQL = "SELECT * FROM Employee WHERE employeeid=?";
            $stmtSelect = $conn->prepare($selectSQL);
            $stmtSelect->bind_param("s", $employeeID);

            // Execute the query
            if ($stmtSelect->execute()) {
                // Get the result
                $result = $stmtSelect->get_result();

                // Check if there are rows in the result set
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    ?>
                    <div class="details-box">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required>

                            <label for="address">Address:</label>
                            <input type="text" id="address" name="address" value="<?php echo $row['address']; ?>" required>

                            <label for="gender">Gender:</label>
                            <input type="text" id="gender" name="gender" value="<?php echo $row['gender']; ?>" required>

                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>

                            <label for="contactno">Contact No:</label>
                            <input type="text" id="contactno" name="contactno" value="<?php echo $row['contactno']; ?>" required>

                            <label for="DOB">Date of Birth:</label>
                            <input type="date" id="DOB" name="DOB" value="<?php echo $row['DOB']; ?>" required>

                            <button type="submit">Update Profile</button>
                        </form>
                    </div>
                    <?php
                } else {
                    echo "<p>0 results</p>";
                }
            } else {
                echo "<p>Error executing the query: " . $stmtSelect->error . "</p>";
            }

            // Close the statement
            $stmtSelect->close();

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
