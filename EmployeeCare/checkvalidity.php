<?php
// Include the database connection file
include('dbconfig.php');

// Function to check if the provided employee ID is in the managerids table
function isManager($conn, $employeeID)
{
    $sql = "SELECT * FROM managerids WHERE managerid = '$employeeID'";
    $result = $conn->query($sql);

    return $result->num_rows > 0;
}

// Function to check if the provided employee ID is in the employee table
function isEmployee($conn, $employeeID)
{
    $sql = "SELECT * FROM employee WHERE employeeid = '$employeeID'";
    $result = $conn->query($sql);

    return $result->num_rows > 0;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted employee ID
    $employeeID = $_POST["username"];

    // Check if the employee is a manager
    if (isManager($conn, $employeeID)) {
        // Store employeeID in the session
        session_start();
        $_SESSION['employeeID'] = $employeeID;

        // Redirect to managers.php
        header("Location: manager/managers.php");
        exit();
    } elseif (isEmployee($conn, $employeeID)) {
        // Store employeeID in the session
        session_start();
        $_SESSION['employeeID'] = $employeeID;

        // Redirect to employee.php
        header("Location: employee/employee.php");
        exit();
    } else {
        // Display that the provided Employee ID is not valid
        echo '<script>alert("The provided Employee ID is not valid.");
            window.location.href = "./index.php";</script>';
    }
}

// Close the database connection
$conn->close();
?>
