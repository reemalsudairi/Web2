<?php
// Include database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tutorverse";

// Assuming the learner is already logged in and their email is stored in a session variable
session_start();
if (!isset($_SESSION['learner_email'])) {
    // Redirect to login page if learner is not logged in
    header("Location: login.php");
    exit();
}

// Retrieve learner's email from session
$email = $_SESSION['learner_email'];

// Fetch learner's information from the database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM learner WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch learner's information
    $row = $result->fetch_assoc();
    $firstName = $row['fname'];
    $lastName = $row['lname'];
    $password = $row['password'];
    $city = $row['city'];
    $location = $row['location'];
} else {
    // Handle case where learner with the provided email address is not found
    echo "Learner not found.";
    exit();
}

// Update learner's information if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    $newFirstName = $_POST['firstName'];
    $newLastName = $_POST['lastName'];
    $newPassword = $_POST['password'];
    $newCity = $_POST['city'];
    $newLocation = $_POST['location'];

    // Update learner's information in the database
    $updateSql = "UPDATE learner SET fname='$newFirstName', lname='$newLastName', password='$newPassword', city='$newCity', location='$newLocation' WHERE email='$email'";
    if ($conn->query($updateSql) === TRUE) {
        // Refresh the page after update
        header("Location: profile.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>
