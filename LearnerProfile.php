<?php 
session_start();

// Check if the user is logged in
/*if (!isset($_SESSION["email"])) {
    // Redirect the user to the login page if not logged in
    header("Location: login.php");
    exit();
}*/

// Include database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tutorverse";
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$email = $_SESSION["email"];

// Fetch user's information from the database
$sql = "SELECT firstName, lastName, city, password, location, profilePic FROM learner WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    // User found, fetch user information
    $row = mysqli_fetch_assoc($result);
    $firstName = $row["firstName"];
    $lastName = $row["lastName"];
    $city = $row["city"];
    $password = $row["password"];
    $location = $row["location"];
    $profilepic = $row["profilePic"];
} else {
    // User not found, handle error or redirect
    echo "User not found.";
}

// Close the database connection
mysqli_close($conn);
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>Tutorverse - My Profile</title>

        <!-- CSS FILES -->        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400&family=Sono:wght@200;300;400;500;700&display=swap" rel="stylesheet">
                        
        <link rel="stylesheet" href="css/bootstrap.min.css">

        <link rel="stylesheet" href="css/bootstrap-icons.css">

        <link rel="stylesheet" href="css/owl.carousel.min.css">
        
        <link rel="stylesheet" href="css/owl.theme.default.min.css">

        <link href="css/templatemo-pod-talk.css" rel="stylesheet">

        <link rel="icon" type="img/png" href="images/logo.png">
        
            
    </head>
    <body>

        <main>

            <nav class="navbar navbar-expand-lg">
                <div class="container">
                    <a class="navbar-brand me-lg-5 me-0" href="LearnerHomepage.html">
                        <img src="images/logotuterverse.png" class="logo-image img-fluid" alt="Tutorverse logo">
                    </a>
                    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-lg-auto">

                            <li class="nav-item">
                                <a class="nav-link " href="LearnerHomepage.html">Home</a>
                            </li><!--لينك صفحة الهوم-->

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarLightDropdownMenuLinkContact" role="button" data-bs-toggle="dropdown" aria-expanded="false">Contact</a>
                                <ul class="dropdown-menu dropdown-menu-light" >
                                    <li><a class="dropdown-item" href="tel:0508197538">Call us</a></li>
                                    <li><a class="dropdown-item" href="mailto:tutorverse@hotmail.com">Email us</a></li>
                                </ul>
                            </li><!--لينك كونتاكت-->

                            <li class="nav-item dropdown"> <!--صورة البروفايل-->
                                <a class="nav-link dropdown-toggle" href="#" id="navbarLightDropdownMenuLinkProfile" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="images/profilePic.png"  class="logo-image img-fluid" alt="Photo"> 
                                </a>
                                <ul class="dropdown-menu dropdown-menu-light" >
                                    <li><a class="dropdown-item" href="learnerProfile.html">View Profile</a></li>
                                    <li><a class="dropdown-item" href="ViewRequest.html">View Requests</a></li>
                                    <li><a class="dropdown-item" href="mainHome.html">Sign out</a></li>
                                </ul>
                            </li>
                            
    
                            
                        </ul>

                    </div>
                </div>
            </nav>

            <header class="site-header d-flex flex-column justify-content-center align-items-center">
                <div class="container">
                    <div class="row ">

                        <div class="col-lg-12 col-12 text-center">

                        </div>

                    </div>
                </div>
            </header>
            <br>
            <div class="container">
                <div class="row ">

                    <div class="col-lg-12 col-12 mx-auto">
                        <div class="section-title-wrap mb-5">
                            <h4 class="section-title">My Profile</h4>
                        </div>
                    </div>
                </div>
            </div>      
            <div class="container">
                <div class="custom-block custom-block-full">
                    <div class="custom-block d-flex">
                        <div>
                            <div class="custom-block-icon-wrap">
                                <div class="custom-block-image-wrap">
                                    <img src="<?php echo $profilepic?>" class="custom-block-image" alt="">
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="custom-block-info">
                            <form action="update_profile.php" method="post">
                            <p>First Name: <input type="text" name="firstName" value="<?php echo $firstName; ?>"></p>
                            <p>Last Name: <input type="text" name="lastName" value="<?php echo $lastName; ?>"></p>
                            <p>Email:<input type="text" name="email" value=" <?php echo $email; ?>"></p>
                            <p>Password: <input type="password" name="password" value="<?php echo $password; ?>"></p>
                            <p>City: <input type="text" name="city" value="<?php echo $city; ?>"></p>
                            <p>Location: <input type="text" name="location" value="<?php echo $location; ?>"></p>
                            <br>
                            <br>
                            <br>
                            <div class="custom-block-btn-group">
                                <button type="submit" class="btn custom-btn customredit-btn">Save</button>
                                <a href="delete_profile.php" class="btn custom-btn customreject-btn">Delete</a>
                            </div>
                        </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
        </main>    
            <footer class="site-footer">   
                <div class="container">
                    <div class="row">
          
          
                        <div class="col-lg-3 col-md-6 col-12 mb-4 mb-md-0 mb-lg-0">
                          <h6 class="site-footer-title mb-3">Contact</h6>
          
                          <p class="mb-2"><strong class="d-inline me-2">Phone:</strong> 
                              <a href="tel:0508197538">010-020-0340</a> </p>
          
                          <p>
                              <strong class="d-inline me-2">Email:</strong>
                              <a href="mailto:tutorverse@hotmail.com">tutorverse@hotmail.com</a> 
                          </p>
                        </div>
          
          
                    </div>
                </div>
          
                <div class="container pt-5">
                    <div class="row align-items-center">
          
                        <div class="col-lg-2 col-md-3 col-12">
                          <a class="navbar-brand" href="LearnerHomepage.html">
                              <img src="images/logo.png" class="logo-image img-fluid" alt="Tutorverse logo">
                          </a>
                        </div>
          
                        <div class="col-lg-3 col-12">
                          <p class="copyright-text mb-0">Copyright © 2024 Tutorverse </p>
                        </div>
                    </div>
                 </div>
            </footer>
          <!--end of footer-->
    </body>
          
</html>

    


