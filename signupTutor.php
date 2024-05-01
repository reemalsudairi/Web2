<?php
// Function to sanitize and validate input
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Database connection
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "tutorverse";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $fname = test_input($_POST['fname']);
    $lname = test_input($_POST['lname']);
    $email = test_input($_POST['email']);
    $city = test_input($_POST['city']);
    $phone = test_input($_POST['phone']);
    $password = test_input($_POST['password']);
    $age = test_input($_POST['age']);
    $gender = test_input($_POST['gender']);
    $bio = test_input($_POST['bio']);

    // Perform additional validation as needed
    // For example, you can check if email is valid, password meets certain criteria, etc.
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    }
    
    // SQL to insert data into tutor table
    $sql = "INSERT INTO tutor (Fname, Lname, email, city, phone, password, age, gender, bio) VALUES ('$fname', '$lname', '$email', '$city', '$phone', '$password', '$age', '$gender', '$bio')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
