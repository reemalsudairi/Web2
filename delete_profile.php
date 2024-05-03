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

// Establish a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete the learner's profile from the database
$sql = "DELETE FROM learner WHERE email='$email'";
if ($conn->query($sql) === TRUE) {
    // Logout the learner and redirect to the login page
    session_destroy();
    header("Location: login.php");
    exit();
} else {
    echo "Error deleting record: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
