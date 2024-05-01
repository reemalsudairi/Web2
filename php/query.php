<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tutorverse";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Common
function validate($input)
{
    return htmlspecialchars(stripslashes(trim($input)));
}

function dd($arr)
{
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
    die("Died...");
}

// Tutor
function tutor_signup_handler($fname, $lname, $password, $age, $gender, $city, $email, $profilepic, $price, $bio, $phone)
{
    global $conn;
    $sql = "INSERT INTO `tutor` (`Fname`, `Lname`, `password`, `age`, `gender`, `city`, `email`, `profilepic`, `price`, `bio`, `phone`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssissssssss", $fname, $lname, $password, $age, $gender, $city, $email, $profilepic, $price, $bio, $phone);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}

function get_tutor_email($email)
{
    global $conn;
    $sql = "SELECT email FROM `tutor` WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $count = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);
    return $count;
}

// Learner
function get_learner_email($email)
{
    global $conn;
    $sql = "SELECT email FROM `learner` WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $count = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);
    return $count;
}

function learner_signup_handler($fname, $lname, $email, $password, $profilepic, $city, $location)
{
    global $conn;
    $sql = "INSERT INTO `learner` (`Fname`, `Lname`, `email`, `password`, `profilepic`, `city`, `location`) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssss", $fname, $lname, $email, $password, $profilepic, $city, $location);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}

// View Rates
function get_rates($email)
{
    global $conn;
    $sql = "SELECT rating, review, email FROM `review` WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}

// Offers
function get_requests($email)
{
    global $conn;
    $sql = "SELECT Stime, date, duration, status, language, remainigT FROM `request` WHERE Lemail = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}

?> 
