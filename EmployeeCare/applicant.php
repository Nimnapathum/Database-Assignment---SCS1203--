<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            overflow-y: auto;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Job Application Form</h2>
        <form action="" method="post">
            <label for="name">Your Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="resume">Resume Name:</label>
            <input type="text" id="resume" name="resume" required>

            <label for="eduQualify">Education Qualification:</label>
            <input type="text" id="eduQualify" name="eduQualify" required>

            <label for="contactno">Contact No:</label>
            <input type="text" id="contactno" name="contactno" required>

            <label for="jobid">Select Job:</label>
            <select id="jobid" name="jobid" required>
                <?php
                include('dbconfig.php');
                $sql = "SELECT roleid, title FROM jobroll WHERE jobopening='YES'";
                $result = $conn->query($sql);
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['roleid']}'>{$row['title']}</option>";
                    }
                } else {
                    echo "<option value=''>No jobs available</option>";
                }
                $conn->close();
                ?>
            </select>

            <button type="submit">Submit Application</button>
        </form>
    </div>
</body>
</html>

<?php
// Include the database connection file
include('dbconfig.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Sanitize and validate form data
        $name = sanitize_input($_POST["name"]);
        $resume = sanitize_input($_POST["resume"]);
        $eduQualify = sanitize_input($_POST["eduQualify"]);
        $contactno = sanitize_input($_POST["contactno"]);
        $jobid = sanitize_input($_POST["jobid"]);

        // Generate applicantid
        $applicantid = generateApplicantID($conn);

        // Set status to 'NO'
        $status = 'NO';

        // SQL query to insert data into the applicant table
        $insertSQL = "INSERT INTO applicant (applicantid, resume, contactno, eduQualify, jobid, status)
                      VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertSQL);
        $stmt->bind_param("ssssss", $applicantid, $resume, $contactno, $eduQualify, $jobid, $status);

        // Execute the query
        if ($stmt->execute()) {
            echo "<p>Application submitted successfully!</p>";
            // Redirect to index page after submission
            header("Location: index.php");
            exit();
        } else {
            throw new Exception("Error submitting application: " . $stmt->error);
        }
    } catch (Exception $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }

    // Close the statement
    $stmt->close();
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

// Function to generate applicantid
function generateApplicantID($conn) {
    // Query to get the last applicantid
    $query = "SELECT applicantid FROM applicant ORDER BY applicantid DESC LIMIT 1";
    $result = $conn->query($query);

    // Default count value
    $count = 1;

    if ($result && $result->num_rows > 0) {
        // Extract the last three digits of the last applicantid
        $lastApplicantID = $result->fetch_assoc()['applicantid'];
        $lastDigits = substr($lastApplicantID, -3);

        // Increment the count
        $count = intval($lastDigits) + 1;
    }

    // Generate the new applicantid
    return "APL" . str_pad($count, 3, '0', STR_PAD_LEFT);
}
?>
