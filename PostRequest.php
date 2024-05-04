<?php
session_start();
require('connect.php');

// Retrieve form data
$stime = $_POST['requestTime'];
$date = $_POST['lesson-date'];
$duration = $_POST['session-duration'];
$language = $_POST['language'];
$proficiency = $_POST['proficiency'];


// Get the learner and tutor email from session variables
$lemail = $_SESSION['learner_email'];
$temail = $_SESSION['tutor_email'];

// Retrieve the maximum rID from the table
$sql_max_rid = "SELECT MAX(rID) AS max_rid FROM request";
$result_max_rid = $conn->query($sql_max_rid);
$row = $result_max_rid->fetch_assoc();
$max_rid = $row['max_rid'];

// Generate the new rID
if ($max_rid === null) {
    // If there are no existing records, start from 1
    $new_rid = 1;
} else {
    // Increment the maximum rID by 1
    $new_rid = $max_rid + 1;
}

// Insert data into the database
$sql = "INSERT INTO request (rID, Lemail, Temail, remainingT, status, Stime, date, duration, language)
        VALUES ('$new_rid', '$lemail', '$temail', '24', 'pending', '$stime', '$date', '$duration', '$language')";

if ($conn->query($sql) === TRUE) {
    echo "Session request posted successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>


<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>Tutorverse - Post Session Request</title>

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
                 <br><br>
                <div class="contact-section section-padding pt-0"><!--بداية السشنز-->
                    <div class="container">
                        <div class="col-lg-12 col-12 mx-auto">
                            <div class="section-title-wrap mb-5">
                                <h4 class="section-title">Post Session Request</h4>
                            </div>
                        </div>
                        <div class="container">
                            <div class="custom-block custom-block-full">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <div class="container">
                                        <div class="row">
                                            <div class="custom-form">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                             <label for="lesson-date">Select Date:</label>
                                                              <input type="date" id="lesson-date" name="lesson-date" class="form-control" required>
                                                        </div>
                                                            <div  class="col-md-6">
                                                                 <label for="requestTime">Session Time:</label>
                                                                 <input type="time" id="requestTime" name="requestTime" class="form-control" required>
                                                            </div>
                                                    </div>
                                                </div>
                                                 <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                             <label for="session-duration">Session Duration:</label>
                                                             <select id="session-duration" name="session-duration" size="1" class="form-control" required>
                                                                 <option value="">Select the duration</option>
                                                                  <option value="30">30 minutes</option>
                                                                  <option value="40">40 minutes</option>
                                                                  <option value="50">50 minutes</option>
                                                                  <option value="60">60 minutes</option>
                                                             </select>
                                                        </div>
                                                            <div class="col-md-6">
                                                                 <label for="proficiency">Proficiency:</label>
                                                                 <select id="proficiency" name="proficiency" size="1" class="form-control" required>
                                                                     <option value="">Select the proficiency</option>
                                                                     <option value="Beginner">Beginner</option>
                                                                     <option value="Intermediate">Intermediate</option>
                                                                     <option value="Advanced">Advanced</option>
                                                                 </select>
                                                            </div>
                                                    </div>
                                                </div>
                
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                             <label for="language">Language:</label>
                                                             <input type="text" id="language" name="language" class="form-control" placeholder="Enter the language" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                   <br>
                                            </div>
                                  
                                              
                                          
                                        </div>  
                                         
                                     
                                               <br>
                                            <div class="custom-block-btn-group">
                                        
                                                <a href="ViewRequest.html" class="btn custom-btn customreject-btn ">Cancel</a>
                                            
                                                <button type="submit" class="btn custom-btn customedit-btn">Post Request</button>
                                            
                                            </div>
                                    </div>  
                                </form>
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


