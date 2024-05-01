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

// common
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

/* contact us
function contact_us_handler($name, $email, $message)
{
    global $conn;
    $sql = "INSERT INTO `contactus` (`name`, `email`, `massage`) VALUES ('" . $name . "','" . $email . "','" . $message . "')";
    $result = mysqli_query($conn, $sql);
    return $result;
}*/



// tutor
function tutor_signup_handler($fname, $lname, $password, $age, $gender, $city, $email, $profilepic, $price, $bio, $phone)
{
    global $conn;
    $sql = "INSERT INTO `tutor` (`Fname`, `Lname`, `password`, `age`, `gender`, `city`, `email`, `profilepic`, `price`, `bio`, `phone`) VALUES ('" . $fname . "','" . $lname . "','" . $password . "','" . $gender . "','" . $city . "','" . $email . "','" . $profilepic . "','" . $price . "','" . $bio . "','" . $phone . "')";
    $result = mysqli_query($conn, $sql);
    return $result;
}
function get_tutor_email($email)
{
    global $conn;
    $sql = "SELECT email FROM `tutor` WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    return mysqli_num_rows($result);
}

// learner
function get_learner_email($email)
{
    global $conn;
    $sql = "SELECT email FROM `learner` WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    return mysqli_num_rows($result);
}

function learner_signup_handler($fname, $lname, $email, $password, $profilepic, $city, $location)
{

    global $conn;
    $sql = "INSERT INTO `learner` (`Fname`, `Lname`, `email`, `password`, `profilepic`, `city`, `location`) VALUES ('" . $fname . "','" . $lname . "','" . $email . "','" . $password . "','" . $profilepic . "','" . $city . "','" . $location . "')";
    $result = mysqli_query($conn, $sql);

    return $result;
}

// view rates
function get_rates($email)
{
    global $conn;
    $sql = "SELECT review.rate, review.feedback, review.date, review.time, parent.firstName, parent.lastName, parent.img FROM `review`, `parent` WHERE review.parentEmail = parent.email AND review.babysitterEmail = '" . $email . "'";
    $result = mysqli_query($conn, $sql);
    // dd(mysqli_fetch_assoc($result));
    return $result;
}


// offers
function get_requests($email)
{
    global $conn;
    $sql = "SELECT requests.TypeOfServese, requests.startTime, requests.endTime, requests.startDate, requests.startDate, offers.price, offers.offerstatus FROM `requests`, `offers` WHERE  requests.ID = offers.RequestID AND offers.babySitterEmail = '" . $email . "'";
    $result = mysqli_query($conn, $sql);
    return $result;
}