<?php
// Database connection
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tutorverse";
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$currentLearnerEmail = isset($_SESSION['learner_email']) ? $_SESSION['learner_email'] : '';
// Query to fetch pending requests


// Query to fetch pending requests for the current learner
$sqlPending = "SELECT Stime, date, duration, language, remainigT, Lemail,Temail,Fname,profilepic,status FROM request,tutor WHERE status = 'pending' AND Lemail = '$currentLearnerEmail' and tutor.email=Temail";
$resultPending = mysqli_query($conn, $sqlPending);

// Query to fetch accepted requests for the current learner
$sqlAccepted = "SELECT Stime, date, duration, language, remainigT, Lemail,Temail,Fname,profilepic,status FROM request,tutor WHERE status = 'accepted' AND Lemail = '$currentLearnerEmail' and tutor.email=Temail";
$resultAccepted = mysqli_query($conn, $sqlAccepted);

// Query to fetch rejected requests for the current learner
$sqlRejected = "SELECT Stime, date, duration, language, remainigT, Lemail,Temail,Fname,profilepic,status FROM request,tutor WHERE status = 'rejected' AND Lemail = '$currentLearnerEmail' and tutor.email=Temail";
$resultRejected = mysqli_query($conn, $sqlRejected);



/*$sqlPending = "SELECT Stime, date, duration, language, remainigT, Lemail, status,Lproficiency, Temail FROM request as r ,postreuest as p WHERE status = 'pending' and r.Lemail=p.Lemail";
$resultPending = mysqli_query($conn, $sqlPending);

// Query to fetch accepted requests
$sqlAccepted = "SELECT Stime, date, duration, language, remainigT, Lemail, status,Lproficiency, Temail FROM request as r ,postreuest as p WHERE status = 'accepted' and r.Lemail=p.Lemail";
$resultAccepted = mysqli_query($conn, $sqlAccepted);

// Query to fetch rejected requests
$sqlRejected = "SELECT Stime, date, duration, language, remainigT, Lemail, status,Lproficiency, Temail FROM request as r ,postreuest as p WHERE status = 'rejected' r.Lemail=p.Lemail";
$resultRejected = mysqli_query($conn, $sqlRejected);*/
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>Tutorverse - Session Requests</title>

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

            <div class="contact-section section-padding pt-0"><!--بداية السشنز-->
                <div class="container">
                    <div class="row ">
                       <!--buttons to navigate-->
                        <div class="mt-2"><br>
                            <a href="#acceptedreq" class="btn custom-btn smallfont" >
                                view accepted requests
                            </a>
                    
                            <a href="#Rejectedreq" class="btn custom-btn smallfont">
                                view rejected requests
                            </a>
                        </div>

                        <div class="col-lg-12 col-12 mx-auto">
                            <div class="section-title-wrap mb-5"><br>
                                <h4 id="pendingreq" class="section-title">Pending Requests</h4>
                   
                            </div>
                        </div>
                        <?php
                // Display pending requests
                while ($row = mysqli_fetch_assoc($resultPending)) {
                    // Extract request details
                    $timeRemaining = $row['remainigT'];
                    $learnerName = $row['Lemail']; // Assuming Lemail is the learner's name
                    $language = $row['language'];
                    $date = $row['date'];
                    $time = $row['Stime'];
                    $duration = $row['duration'];
                    $profilepic=$row['profilepic'];
                    $Fname=$row['Fname'];
                    // Display pending request block
                    echo '<div class="col-lg-4 col-md-6 col-sm-12 mb-4">';
                    echo '<div class="custom-block d-flex">';
                    echo '<div>';
                    echo '<div class="custom-block-icon-wrap">';
                    echo '<a class="custom-block-image-wrap">';
                    echo '<img src=' . $profilepic . ' class="custom-block-image2 img-fluid" alt="">';
                    echo '</a>';
                    echo '</div>';
                    echo '<div class="mt-2 buttonsbesideeachother">';
                    echo '<a href="EditRequest.html" class="btn custom-btn customedit-btn" style="margin:1px;">Edit</a>';
                    echo '<a href="#" class="btn custom-btn customreject-btn" style="margin:1px;">Delete</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="custom-block-info">';
                    echo '<div class="custom-block-top d-flex mb-1">';
                    echo '<small class="me-4">';
                    echo '<i class="bi-hourglass-top custom-icon"></i>';
                    echo $timeRemaining . ' Minutes Remaining';
                    echo '</small>';
                    echo '</div>';
                    echo '<div class="profile-block d-flex">';
                    echo '<img src="#" class="profile-block-image img-fluid" alt="">';
                    echo '<p class="namebesideflag">' . $Fname. '</p>';
                    echo '</div>';
                    echo '<p class="mb-0 languagetext">Language: ' . $language . '</p>';
                    echo '<p class="mb-0 smallfont">Date: ' . $date . '<br> Time: ' . $time . '<br> Proficiency: /*Intermediate*/<br> <i class="bi-clock-fill custom-icon "></i> ' . $duration . ' Minutes<br>status:<a class="custompending-btn accrejtag">Pending</a></p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
                        <div class="col-lg-12 col-12 mx-auto">
                            <div class="section-title-wrap mb-5"><br>
                                <h4 id="acceptedreq" class="section-title">Accepted Requests</h4>
                   
                            </div>
                           
                        </div>
                        <?php
                // Display accepted requests
                while ($row = mysqli_fetch_assoc($resultAccepted)) {
                    // Extract request details
                    $duration = $row['duration'];
                    $learnerName = $row['Lemail']; // Assuming Lemail is the learner's name
                    $language = $row['language'];
                    $date = $row['date'];
                    $time = $row['Stime'];
                    $profilepic=$row['profilepic'];
                    $Fname=$row['Fname'];
                    // Display accepted request block
                    echo '<div class="col-lg-4 col-md-6 col-sm-12 mb-4">';
                    echo '<div class="custom-block d-flex">';
                    echo '<div>';
                    echo '<div class="custom-block-icon-wrap">';
                    echo '<a href="detail-page.html" class="custom-block-image-wrap"></a>';
                    echo '<img src=' . $profilepic . ' class="custom-block-image img-fluid" alt="">';
                    echo '</div>';
                    echo '<div class="mt-2">';
                    echo '<a href="payment.html" class="btn custom-btn" style="margin-left: 7px;">Pay now</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="custom-block-info">';
                    echo '<div class="custom-block-top d-flex mb-1">';
                    echo '<small class="me-4">';
                    echo '<i class="bi-clock-fill custom-icon"></i>';
                    echo $duration . ' Minutes';
                    echo '</small>';
                    echo '</div>';
                    echo '<div class="profile-block d-flex">';
                    echo '<img src="/*images/uk.jpeg*/" class="profile-block-image img-fluid" alt="">';
                    echo '<p class="namebesideflag">' . $Fname. '</p>';
                    echo '</div>';
                    echo '<p class="mb-0 languagetext">Language: ' . $language . '</p>';
                    echo '<p class="mb-0 smallfont">Date: ' . $date . '<br> Time: ' . $time . '<br> Proficiency:/* Intermediate*/<br> status: <a class="customaccept-btn accrejtag">Accepted</a></p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
                        <div class="col-lg-12 col-12 mx-auto">
                            <div class="section-title-wrap mb-5"><br>
                                <h4 id="Rejectedreq" class="section-title">Rejected Requests</h4>
                   
                            </div>
                        </div>
                        <?php
                // Display rejected requests
                while ($row = mysqli_fetch_assoc($resultRejected)) {
                    // Extract request details
                    $duration = $row['duration'];
                    $learnerName = $row['Lemail']; // Assuming Lemail is the learner's name
                    $language = $row['language'];
                    $date = $row['date'];
                    $time = $row['Stime'];
                    $profilepic=$row['profilepic'];
                    $Fname=$row['Fname'];
                    // Display rejected request block
                    echo '<div class="col-lg-4 col-md-6 col-sm-12 mb-4">';
                    echo '<div class="custom-block d-flex">';
                    echo '<div>';
                    echo '<div class="custom-block-icon-wrap">';
                    echo '<div class="custom-block-icon-wrap">';
                    echo '<div class="custom-block-icon-wrap">';
                    echo '<a class="custom-block-image-wrap">';
                    echo '<img src=' . $profilepic . ' class="custom-block-image2 img-fluid" alt="">';
                    echo '</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="custom-block-info">';
                    echo '<div class="custom-block-top d-flex mb-1">';
                    echo '<small class="me-4">';
                    echo '<i class="bi-clock-fill custom-icon"></i>';
                    echo $duration . ' Minutes';
                    echo '</small>';
                    echo '</div>';
                    echo '<div class="profile-block d-flex">';
                    echo '<img src="/*images/uk.jpeg*/" class="profile-block-image img-fluid" alt="">';
                    echo '<p class="namebesideflag">' . $Fname . '</p>';
                    echo '</div>';
                    echo '<p class="mb-0 languagetext">Language: ' . $language . '</p>';
                    echo '<p class="mb-0 smallfont">Date: ' . $date . '<br> Time: ' . $time . '<br> Proficiency: /*Intermediate*/<br> status: <a class="customreject-btn accrejtag">Rejected</a></p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                mysqli_close($conn);
                ?>       
        </main>
         <!--نهاية السشنز-->  
   
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
                              <img src="images/logo.png" class="logo-image img-fluid" alt="templatemo pod talk">
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

    


