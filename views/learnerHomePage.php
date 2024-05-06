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

    try {
        $stmt = $pdo->query("SELECT Fname, Lname, email, price, bio, profilepic FROM tutor"); // Adjust according to your database schema
        $tutors = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo "Database error: " . $e->getMessage();
        $tutors = [];
    }
?>
<!-- HTML code -->
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>Tutorverse - Homepage</title>

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
                                <a class="nav-link active" href="learnerHomePage.php">Home</a>
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

            <div class="section-padding" id="section_2">
                <div class="container">
                    <div class="row justify-content-center" >

                        <div>
                            <div class="contact-info">
                                <h2 class="mb-4">Welcome to Tutorverse!</h2>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="contact-section section-padding pt-0"><!--بداية السشنز-->
                <div class="container">
                    <div class="row ">

                        <div class="col-lg-12 col-12 mx-auto">
                            <div class="section-title-wrap mb-5">
                                <h4 class="section-title">My Sessions</h4>
                            </div>
                            <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                <div class="custom-block d-flex">
                                    <div class="">
                                        <div class="custom-block-icon-wrap">
                                            <div class="section-overlay"></div>
                                                <img src="../public/images/elsa.webp" class="custom-block-image img-fluid" alt="">
                                            <a href="#" class="custom-block-icon">
                                                <i class="bi-play-fill"></i>
                                            </a>
                                        </div>
    
                                        <div class="mt-2">
                                            <a href="chat1.html" class="btn custom-btn" style="margin-left: 7px;">
                                                Contact
                                            </a>
                                        </div>
                                    </div>
    
                                    <div class="custom-block-info">
                                        <div class="custom-block-top d-flex mb-1">
                                            <small class="me-4">
                                                <i class="bi-clock-fill custom-icon"></i>
                                                50 Minutes
                                            </small>
    
                                        </div>
    
                                        <div class="profile-block d-flex">
    
                                            <p class="namebesideflag">Elsa</p>
                                        </div>
    
                                        <p class="mb-0"><strong>Language: English</strong><br>Date: 6/2/2024 <br> Time: 8:00pm</p>
    
                                    </div>
    
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                <div class="custom-block d-flex">
                                    <div class="">
                                        <div class="custom-block-icon-wrap">
                                            <div class="section-overlay"></div>
                                                <img src="../public/images/handsome-asian-man-listening-music-through-headphones.jpg" class="custom-block-image img-fluid" alt="">
                                            <a href="#" class="custom-block-icon">
                                                <i class="bi-play-fill"></i>
                                            </a>
                                        </div>
    
                                        <div class="mt-2">
                                            <a href="chat1.html" class="btn custom-btn" style="margin-left: 7px;">
                                                Contact
                                            </a>
                                        </div>
                                    </div>
    
                                    <div class="custom-block-info">
                                        <div class="custom-block-top d-flex mb-1">
                                            <small class="me-4">
                                                <i class="bi-clock-fill custom-icon"></i>
                                                60 Minutes
                                            </small>
    
                                        </div>
    
                                        <div class="profile-block d-flex">
    
                                            <p class="namebesideflag">Chan</p>
                                        </div>
    
                                        <p class="mb-0"><strong>Language: Chinese</strong><br>Date: 15/2/2024 <br> Time: 10:00pm</p>
    
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                <div class="custom-block d-flex">
                                    <div class="">
                                        <div class="custom-block-icon-wrap">
                                            <div class="section-overlay"></div>
                                                <img src="../public/images/kevincopy.png" class="custom-block-image img-fluid" alt="">
                                            <a href="#" class="custom-block-icon">
                                                <i class="bi-play-fill"></i>
                                            </a>
                                        </div>
    
                                        <div class="mt-2">
                                            <a href="chat1.html" class="btn custom-btn" style="margin-left: 7px;">
                                                Contact
                                            </a>
                                        </div>
                                    </div>
    
                                    <div class="custom-block-info">
                                        <div class="custom-block-top d-flex mb-1">
                                            <small class="me-4">
                                                <i class="bi-clock-fill custom-icon"></i>
                                                60 Minutes
                                            </small>
    
                                        </div>
    
                                        <div class="profile-block d-flex">
    
                                            <p class="namebesideflag">Kavin</p>
                                        </div>
    
                                        <p class="mb-0"><strong>Language: Spanish</strong><br>Date: 22/2/2024 <br> Time: 10:00pm</p>
    
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div> 
                        <div class="col-lg-2 col-12 ms-auto">
                            <a href="Learnersessionpage.html" class="btn custom-btn">
                                View more
                            </a>
                        </div>  
                    </div>
                </div>  
            </div><!--نهاية السشنز-->
                    
            <div class="contact-section section-padding pt-0" id="section_22"><!--بداية التوتر لست-->
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-12 col-12 mx-auto">
                            <div class="section-title-wrap mb-5">
                                <h4 class="section-title">Meet Our Tutors</h4>
                        </div>
                    </div>
                        <!-- <div class="col-lg-3 col-12 mb-4 mb-lg-0">
                            <div class="custom-block custom-block-full">
                                <div class="custom-block-image-wrap">
                                        <img src="../public/images/elsa.webp" class="custom-block-image img-fluid" alt="">
                                </div>
            
                                <div class="profile-block d-flex">
                                    <p class="namebesideflag">Elsa  
                                        <a href="reviewsAsLearner.html" class="rating ratingmargin">★★★☆☆ 3.5</a></p>
                                </div>
                                <span class="bi-cash-coin purple"> &#36; 12.5/hr</span>

                                <div class="mt-2">
                                    <a href="mailto:tutorverse@hotmail.com" class="btn custom-btn">View Details</a>
                                </div>
                                <div class="mt-2">
                                    <a href="PostRequest.html" class="btn custom-btn">Post request</a>
                                </div>
            
                                <div class="mt-2">
                                    <a href="chat1.html" class="btn custom-btn">Contact</a>
                                </div>
                            </div>
                        </div>
            
                        <div class="col-lg-3 col-12 mb-4 mb-lg-0">
                            <div class="custom-block custom-block-full">
                                <div class="custom-block-image-wrap">
                                        <img src="../public/images/Camila.webp" class="custom-block-image img-fluid" alt="">
                                </div>
            
                                <div class="profile-block d-flex">
                                    <p class="namebesideflag">Camila  
                                        <a href="reviewsAsLearner.html" class="rating ratingmargin">★★★★★ 5</a></p>
                                </div>

                                <span class="bi-cash-coin purple"> &#36; 10/hr</span>
                                <div class="mt-2">
                                    <a href="mailto:tutorverse@hotmail.com" class="btn custom-btn">View Details</a>
                                </div>
                                <div class="mt-2">
                                    <a href="PostRequest.html" class="btn custom-btn">Post request</a>
                                </div>
            
                                <div class="mt-2">
                                    <a href="chat1.html" class="btn custom-btn">Contact</a>
                                </div>
                            </div>
                        </div>
            
                        <div class="col-lg-3 col-12 mb-4 mb-lg-0">
                            <div class="custom-block custom-block-full">
                                <div class="custom-block-image-wrap">
                                        <img src="../public/images/kevincopy.png" class="custom-block-image img-fluid" alt="">
                                </div>
            
                                <div class="profile-block d-flex">
                                    <p class="namebesideflag">Kevin   
                                        <a href="reviewsAsLearner.html" class="rating ratingmargin">★★☆☆☆ 2.4</a></p>
                                </div>
                                <span class="bi-cash-coin purple"> &#36; 15/hr</span>
                                <div class="mt-2">
                                    <a href="mailto:tutorverse@hotmail.com" class="btn custom-btn">View Details</a>
                                </div>
                                <div class="mt-2">
                                    <a href="PostRequest.html" class="btn custom-btn">Post request</a>
                                </div>
            
                                <div class="mt-2">
                                    <a href="chat1.html" class="btn custom-btn">Contact</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-12 mb-4 mb-lg-0">
                            <div class="custom-block custom-block-full">
                                <div class="custom-block-image-wrap">
                                        <img src="../public/images/handsome-asian-man-listening-music-through-headphones.jpg" class="custom-block-image img-fluid" alt="">
                                </div>
            
                                <div class="profile-block d-flex">
                                    <p class="namebesideflag">Chan   
                                    <a href="reviewsAsLearner.html" class="rating ratingmargin">★★★★☆ 4.6</a></p>
                                </div>
                                <span class="bi-cash-coin purple"> &#36; 10/hr</span>
                                <div class="mt-2">
                                    <a href="mailto:tutorverse@hotmail.com" class="btn custom-btn">View Details</a>
                                </div>
                                <div class="mt-2">
                                    <a href="PostRequest.html" class="btn custom-btn">Post request</a>
                                </div>
            
                                <div class="mt-2">
                                    <a href="chat1.html" class="btn custom-btn">Contact</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-lg-2 col-12 ms-auto">
                        <a href="tutorlist.html" class="btn custom-btn">
                            View more
                        </a>
                    </div> -->

                    <div class="row">
                    <?php foreach ($tutors as $tutor): ?>
                        <div class="col-lg-3 col-12 mb-4 mb-lg-0">
                            <div class="custom-block custom-block-full">
                                <div class="custom-block-image-wrap">
                                    <?php if (isset($tutor['profilePic']) && $tutor['profilePic']): ?>
                                        <img src="data:image/jpeg;base64,<?php echo base64_encode($tutor['profilePic']); ?>" class="custom-block-image img-fluid" alt="Profile Picture">
                                    <?php else: ?>
                                        <img src="../public/images/profilepic2.jpg" class="custom-block-image img-fluid" alt="Default Profile Picture">
                                    <?php endif; ?>
                                </div>

                                <div class="profile-block d-flex">
                                    <p class="namebesideflag"><?php echo htmlspecialchars($tutor['Fname']); ?> &nbsp; <?php echo htmlspecialchars($tutor['Lname']); ?>
                                        <!-- <a href="reviewsAsLearner.html" class="rating ratingmargin"><?php echo str_repeat('★', floor($tutor['rating'])) . str_repeat('☆', 5 - floor($tutor['rating'])) . ' ' . $tutor['rating']; ?></a> -->
                                    </p>
                                </div>
                                <span class="bi-cash-coin purple"> &#36; <?php echo htmlspecialchars($tutor['price']); ?>/hr</span>

                                <div class="mt-2">
                                    <a href="viewTutorDetails_learner.php?tutor_id=<?php echo urlencode($tutor['email']); ?>" class="btn custom-btn">View Details</a>
                                </div>
                                <div class="mt-2">
                                    <a href="postRequestLearner.php?tutor_id=<?php echo urlencode($tutor['email']); ?>" class="btn custom-btn">Post request</a>
                                </div>

                                <div class="mt-2">
                                    <a href="mailto:<?php echo htmlspecialchars($tutor['email']); ?>" class="btn custom-btn">Contact</a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>

            <!--نهاية التوترز-->
        </main>


<!--footer-->

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
<!--end of footer-->
        </body>

</html>