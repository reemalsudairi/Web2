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

    // Handle signup submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $rating = $_POST['rating'];
        $message = $_POST['message'];
        $Lemail = $_SESSION['user_email'];
        $Temail = $_GET['tutor_id'];

        try {

            // Prepare and bind
            $stmt = $pdo->prepare("INSERT INTO review (Lemail, Temail, rating, review) VALUES (?, ?, ?, ?)");
            $stmt->execute([$Lemail, $Temail, $rating, $message]);


            // Redirect to another page after successful signup
            header("Location: learnerHomePage.php"); // Adjust this to your target page
            exit;
        }catch(Exception $e) {
            echo "Database error:  " . $e->getMessage();
        }
    }

?>
<!-- HTML Code  -->
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title> Tutorverse - Rate And Review</title>

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
                    <a class="navbar-brand me-lg-5 me-0" href="learnerHomePage.php">
                        <img src="../public/images/logotuterverse.png" class="logo-image img-fluid" alt="Tutorverse logo">
                    </a>
                    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-lg-auto">

                            <li class="nav-item">
                                <a class="nav-link " href="learnerHomePage.php">Home</a>
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
                                    <img src="../public/images/profilePic.png"  class="logo-image img-fluid" alt="Photo"> 
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
            <div class="latest-podcast-section section-padding" id="section_2">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-12 col-12">
                            <div class="section-title-wrap mb-5">
                                <h4 class="section-title">Share Your Experience</h4>
                            </div>
                        </div>
                        </div>
                        <form action="#" method="POST" class="custom-form contact-form" role="form">


                        <div class="container">
                            <div class="row justify-content-center">
                        <div class="col-lg-6 col-20 mb-20 mb-lg-20">
                            <div class="custom-block custom-block-full">
                                <div class="custom-block-image-wrap">
                                    <div class="feedback-form">
                                        
                                        
                                    <div class="rating-stars-container">
                                        <input type="radio" id="star1" name="rating" value="5">
                                        <label class="star" for="star1"><i class="fas fa-star"></i></label>
                                        <input type="radio" id="star2" name="rating" value="4">
                                        <label class="star" for="star2"><i class="fas fa-star"></i></label>
                                        <input type="radio" id="star3" name="rating" value="3">
                                        <label class="star" for="star3"><i class="fas fa-star"></i></label>
                                        <input type="radio" id="star4" name="rating" value="2">
                                        <label class="star" for="star4"><i class="fas fa-star"></i></label>
                                        <input type="radio" id="star5" name="rating" value="1">
                                        <label class="star" for="star5"><i class="fas fa-star"></i></label>
                                    </div>
                                    
                                    
                                    
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-12">
                                                    <div class="form-floating">                                                        
                                                    </div>
                                                </div>
                    
                                                  
                                                <div class="center">
                                                    <h5>we highly value your feedback!</h5>
                                                  </div>
                                                  


                                                  <div class="form-floating">
                                                    <textarea class="form-control" id="message" name="message" placeholder="Describe message here"></textarea>
                                                    <label for="message">Write Your Review Here...</label>
                                                </div>
                                                
                                            </div>
        
                                            <div class="col-lg-4 col-12 mx-auto">
                                                <button type="submit" class="form-control">Submit</button>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                        </div>
                                        </div>
                                        </div>
                                   
                                    </form>
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
                        <img src="../public/images/logo.png" class="logo-image img-fluid" alt="Tutorverse logo">
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

    
    





    </body>
</html>