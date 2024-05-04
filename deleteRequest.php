<?php
session_start();

// Check if all required parameters are set for deleting a request
if(isset($_GET['delete_request_stime']) && isset($_GET['delete_request_date']) && isset($_GET['delete_request_lemail']) && isset($_GET['delete_request_temail'])) {
    // Database connection parameters
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

    $deleteRequestStime = $_GET['delete_request_stime'];
    $deleteRequestDate = $_GET['delete_request_date'];
    $deleteRequestLemail = $_GET['delete_request_lemail'];
    $deleteRequestTemail = $_GET['delete_request_temail'];

    // Query to delete the request from the database
    $sqlDeleteRequest = "DELETE FROM request WHERE Stime = '$deleteRequestStime' AND date = '$deleteRequestDate' AND Lemail = '$deleteRequestLemail' AND Temail = '$deleteRequestTemail'";

    if(mysqli_query($conn, $sqlDeleteRequest)) {
        // Request deleted successfully
        // Redirect the user back to the page where pending requests are displayed
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    } else {
        // Error deleting request
        echo "Error deleting request: " . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);
} else {
    // Error: Required parameters not set
    echo "Error: Required parameters not set";
}
?>
