<?php
    include '../src/dbConnect.php';
    session_start();

    // attempting to query the application version
    try {
        
        $stmt = $pdo->query("SELECT * FROM version WHERE id = 1"); // getting data from the dummy table to get the version
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch(Exception $e) {
        echo "Database error:  " . $e->getMessage();
        $rows = [];
    }

    
    if (isset($_GET['tutor_id'])) {
        $tutorId = $_GET['tutor_id'];
        
        // Prepare a statement to prevent SQL injection
        $stmt = $pdo->prepare("SELECT * FROM tutor WHERE email = ?");
        $stmt->execute([$tutorId]); 
        $tutor = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$tutor) {
            echo "No details found for the selected tutor.";
        }
    } else {
        echo "No tutor selected.";
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $lessonDate = $_POST['lesson-date'];
        $requestTime = $_POST['requestTime'];
        $sessionDuration = $_POST['session-duration'];
        $proficiency = $_POST['proficiency'];
        $language = $_POST['language'];
        $learnerEmail = $_SESSION['user_email']; // Assuming you store user email in session
        $tutorEmail = $tutor['email']; // Assuming you have tutor's email from earlier fetch

        // Prepare SQL statement to insert data
        $sql = "INSERT INTO postrequest (date, requestDuration, Stime, Lproficiency, language, Lemail, Temail) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $success = $stmt->execute([$lessonDate, $requestTime, $sessionDuration, $proficiency, $language, $learnerEmail, $tutorEmail]);

        if ($success) {
            echo "<p>Request posted successfully!</p>";
            // Optionally redirect or perform other actions
            // Redirect to another page after successful signup
            header("Location: viewRequestsLearner.php"); // Adjust this to your target page
            exit;
        } else {
            echo "<p>Error posting request.</p>";
        }
    }

    $user_email = $_SESSION['user_email'];
    // attempting to query the user's profile data
    try {
        $stmt = $pdo->prepare("SELECT Fname, Lname, email, city, location, profilepic FROM learner WHERE email = :user_email");
        $stmt->execute(['user_email' => $user_email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
    } catch(Exception $e) {
        echo "Database error: " . $e->getMessage();
        $user = [];
    }
    // Example function to determine MIME type from Base64 string
    function getMimeType($base64String) {
        $imageInfo = getimagesizefromstring(base64_decode($base64String));
        return $imageInfo['mime'];
    }
    
?>
<!-- HTML Code -->
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
                        
        <link rel="stylesheet" href="../public/css/bootstrap.min.css">

        <link rel="stylesheet" href="../public/css/bootstrap-icons.css">

        <link rel="stylesheet" href="../public/css/owl.carousel.min.css">
        
        <link rel="stylesheet" href="../public/css/owl.theme.default.min.css">

        <link href="../public/css/templatemo-pod-talk.css" rel="stylesheet">

        <link rel="icon" type="img/png" href="../public/images/logo.png">

    </head>
    <body>

        <main>

            <nav class="navbar navbar-expand-lg">
                <div class="container">
                    <a class="navbar-brand me-lg-5 me-0" href="learnerHomepage.php">
                        <img src="../public/images/logotuterverse.png" class="logo-image img-fluid" alt="Tutorverse logo">
                    </a>
                    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-lg-auto">

                            <li class="nav-item">
                                <a class="nav-link " href="learnerHomepage.php">Home</a>
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
                                <?php $mimeType = getMimeType($user['profilepic']); ?>
                                    <img style="width:35px;height:35px;" src="data:<?php echo $mimeType; ?>;base64,<?php echo $user['profilepic']; ?>" class="logo-image custom-block-image img-fluid" alt="Profile Picture">
                                </a>
                                <ul class="dropdown-menu dropdown-menu-light" >
                                    <li><a class="dropdown-item" href="learnerViewProfile.php">View Profile</a></li>
                                    <li><a class="dropdown-item" href="viewRequestsLearner.php">View Requests</a></li>
                                    <li><a class="dropdown-item" href="../public/index.php">Sign out</a></li>
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
                                <form action="#" method="post">
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
                                        
                                                <a href="learnerHomePage.php" class="btn custom-btn customreject-btn ">Cancel</a>
                                            
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
                              <img src="../public/images/logo.png" class="logo-image img-fluid" alt="templatemo pod talk">
                          </a>
                      </div>
          
                      <div class="col-lg-3 col-12">
                        <p class="copyright-text mb-0">Copyright © 2024 Tutorverse 
                            <?php 
                                $firstRow = $rows[0];
                                echo '<span>' . htmlspecialchars($firstRow['version']) . '</span>';
                            ?>
                        </p>
                      </div>
                  </div>
              </div>
          </footer>
          <!--end of footer-->

        

    </body>

</html>
