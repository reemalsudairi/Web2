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
        $stmt = $pdo->prepare("SELECT t.*, s.* FROM tutor t INNER JOIN session s ON t.email = s.Temail WHERE status = 'Accepted' AND s.Lemail = ?");
        $stmt->execute([$_SESSION['user_email']]);
        $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
        echo "Database error: " . $e->getMessage();
        $Lreq = [];
    }

    try {
        $stmt = $pdo->prepare("SELECT t.*, s.* FROM tutor t INNER JOIN session s ON t.email = s.Temail WHERE status = 'Completed' AND s.Lemail = ?");
        $stmt->execute([$_SESSION['user_email']]);
        $completedSessions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
        echo "Database error: " . $e->getMessage();
        $Lreq = [];
    }

?>
<!-- HTML code -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tutorverse - My Sessions</title>
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

    <div class="contact-section section-padding pt-0"><!--بداية السشنز-->
        <div class="container">
            <div class="row ">
                <!--buttons to navigate-->
                <div class="mt-2"><br>
                    <a href="#currentreq" class="btn custom-btn" style="font-size: small;">
                        Current Session
                    </a>

                    <a href="#previousreq" class="btn custom-btn" style="font-size: small;">
                        Previous Session
                    </a>
                </div>

                <!--لينك كونتاكت-->





                <div class="col-lg-12 col-12 mx-auto">
                    <div class="section-title-wrap mb-5"><br>
                        <h4 id="currentreq" class="section-title">Current Session</h4>

                    </div>

                    <!-- <div class="row">
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

                                    <p class="mb-0"><strong>Language: Spanish</strong><br>Date: 2/3/2024 <br> Time: 10:00pm</p>

                                </div>
                            </div>
                        </div>
                        </div>
<div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="custom-block d-flex">
                <div class="">
                    <div class="custom-block-icon-wrap">
                        <div class="section-overlay"></div>
                        
                            <img src="../public/images/profilepic2.jpg"
                            class="custom-block-image img-fluid" alt="">
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

                        <p class="namebesideflag">Maya</p>
                    </div>

                    <p class="mb-0"><strong>Language: Arabic</strong><br>Date: 6/3/2024 <br> Time: 8:00pm</p>

                </div>

            </div>
        </div> -->

        <div class="row">
        <?php foreach ($sessions as $session): ?>
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                        <div class="custom-block d-flex">
                                            <div class="">
                                                <div class="custom-block-icon-wrap">
                                                    <div class="section-overlay"></div>
                                                        <!-- <img src="../public/images/profilepic2.jpg" class="custom-block-image img-fluid" alt=""> -->
                                                        <?php if (isset($session['profilePic']) && $session['profilePic']): ?>
                                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($session['profilePic']); ?>" class="custom-block-image img-fluid" alt="Profile Picture">
                                                        <?php else: ?>
                                                            <img src="../public/images/profilepic2.jpg" class="custom-block-image img-fluid" alt="Default Profile Picture">
                                                        <?php endif; ?>
                                                        <a href="#" class="custom-block-icon">
                                                            <i class="bi-play-fill"></i>
                                                        </a>
                                                </div>
            
                                                <div class="mt-2">
                                                    <a href="mailto:<?php echo htmlspecialchars($session['Temail']); ?>" class="btn custom-btn" style="margin-left: 7px">
                                                        Contact
                                                    </a>
                                                </div>
                                            </div>
            
                                            <div class="custom-block-info">
                                                <div class="custom-block-top d-flex mb-1">
                                                    <small class="me-4">
                                                        <i class="bi-clock-fill custom-icon"></i>
                                                        <?php echo htmlspecialchars($session['duration']); ?>  Minutes
                                                    </small>
            
                                                </div>
            
                                                <div class="profile-block d-flex">
            
                                                    <p class="namebesideflag"><?php echo htmlspecialchars($session['Fname']); ?> &nbsp; <?php echo htmlspecialchars($session['Lname']); ?></p>
                                                </div>
                                                <p class="mb-0" style="font-size:small;"><strong>Language:  <?php echo htmlspecialchars($session['language']); ?></strong><br>Date:<?php echo htmlspecialchars($session['date']); ?> <br> Time:  <?php echo htmlspecialchars($session['Stime']); ?> 
                                                <!-- <br> Proficiency: Advanced -->
                                            </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
        </div>
        
            
                    
              




                <div class="col-lg-12 col-12 mx-auto">
                    <div class="section-title-wrap mb-5"><br>
                        <h4 id="previousreq" class="section-title">Previous Session</h4>

                    </div>


                    <!-- <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="custom-block d-flex">
                                <div class="">
                                    <div class="custom-block-icon-wrap">
                                            <img src="../public/images/Camila.webp" class="custom-block-image img-fluid" alt="">
                                    </div>

                                    <div class="mt-2">
                                        <a href="review.html" class="btn custom-btn">
                                            Rate&Review
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

                                        <p class="namebesideflag">Camila</p>
                                    </div>

                                    <p class="mb-0"><strong>Language: English</strong><br>Date: 11/3/2023 <br> Time: 8:00pm</p>

                                </div>

                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="custom-block d-flex">
                                <div class="">
                                    <div class="custom-block-icon-wrap">
                                        <div class="section-overlay"></div>
                                       
                                            <img src="../public/images/handsome-asian-man-listening-music-through-headphones.jpg" class="custom-block-image img-fluid" alt="">
                                        
                                    </div>

                                    <div class="mt-2">
                                        <a href="review.html" class="btn custom-btn">
                                            Rate&Review
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

                                    <p class="mb-0"><strong>Language: Chinese</strong><br>Date: 15/3/2023 <br> Time: 5:00pm</p>

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="custom-block d-flex">
                                <div class="">
                                    <div class="custom-block-icon-wrap">
                                        <div class="section-overlay"></div>
                                            <img src="../public/images/kevincopy.png" class="custom-block-image img-fluid" alt="">
                                    </div>

                                    <div class="mt-2">
                                        <a href="review.html" class="btn custom-btn">
                                            Rate&Review
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

                                    <p class="mb-0"><strong>Language: Spanish</strong><br>Date: 22/3/2023<br> Time: 1:00pm</p>

                                </div>
                            </div>
                        </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                <div class="custom-block d-flex">
                                    <div class="">
                                        <div class="custom-block-icon-wrap">
                                            <div class="section-overlay"></div>
                                                <img src="../public/images/elsa.webp" class="custom-block-image img-fluid" alt="">
                                        </div>
    
                                        <div class="mt-2">
                                            <a href="review.html" class="btn custom-btn">
                                                Rate&Review
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
    
                                        <p class="mb-0"><strong>Language: English</strong><br>Date: 6/3/2023 <br> Time: 8:00pm</p>
    
                                    </div>
    
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                <div class="custom-block d-flex">
                                    <div class="">
                                        <div class="custom-block-icon-wrap">
                                            <div class="section-overlay"></div>
                                            
                                                <img src="../public/images/sauditutor.jpeg"
                                                class="custom-block-image img-fluid" alt="">
                                        </div>
    
                                        <div class="mt-2">
                                            <a href="review.html" class="btn custom-btn">
                                                Rate&Review
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
    
                                            <p class="namebesideflag">Omar</p>
                                        </div>
    
                                        <p class="mb-0"><strong>Language: Arabic</strong><br>Date: 8/2/2023 <br> Time: 6:00pm</p>
    
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                <div class="custom-block d-flex">
                                    <div class="">
                                        <div class="custom-block-icon-wrap">
                                            <div class="section-overlay"></div>
                                            
                                                <img src="../public/images/Camila.webp" class="custom-block-image img-fluid" alt="">
                                        </div>
    
                                        <div class="mt-2">
                                            <a href="review.html" class="btn custom-btn">
                                               Rate&Review
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
    
                                            <p class="namebesideflag">Camila</p>
                                        </div>
    
                                        <p class="mb-0"><strong>Language: Spanish</strong><br>Date: 19/3/2023 <br> Time: 3:00pm</p>
    
                                    
                                    </div>
        
                                </div>
                            </div>

                            </div>
            </div> -->

            <div class="row">

                        <?php foreach ($completedSessions as $completedSession): ?>
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                        <div class="custom-block d-flex">
                                            <div class="">
                                                <div class="custom-block-icon-wrap">
                                                    <div class="section-overlay"></div>
                                                        <?php if (isset($completedSession['profilePic']) && $completedSession['profilePic']): ?>
                                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($completedSession['profilePic']); ?>" class="custom-block-image img-fluid" alt="Profile Picture">
                                                        <?php else: ?>
                                                            <img src="../public/images/profilepic2.jpg" class="custom-block-image img-fluid" alt="Default Profile Picture">
                                                        <?php endif; ?>
                                                        <a href="#" class="custom-block-icon">
                                                            <i class="bi-play-fill"></i>
                                                        </a>
                                                </div>
            
                                                <div class="mt-2">
                                                    <a href="postReviewLearner.php?tutor_id=<?php echo urlencode($completedSession['email']); ?>" class="btn custom-btn" style="margin-left: 7px">
                                                        Rate & Review
                                                    </a>
                                                </div>
                                            </div>
            
                                            <div class="custom-block-info">
                                                <div class="custom-block-top d-flex mb-1">
                                                    <small class="me-4">
                                                        <i class="bi-clock-fill custom-icon"></i>
                                                        <?php echo htmlspecialchars($completedSession['duration']); ?>  Minutes
                                                    </small>
            
                                                </div>
            
                                                <div class="profile-block d-flex">
            
                                                    <p class="namebesideflag"><?php echo htmlspecialchars($completedSession['Fname']); ?> &nbsp; <?php echo htmlspecialchars($completedSession['Lname']); ?></p>
                                                </div>
                                                <p class="mb-0" style="font-size:small;"><strong>Language:  <?php echo htmlspecialchars($completedSession['language']); ?></strong><br>Date:<?php echo htmlspecialchars($completedSession['date']); ?> <br> Time:  <?php echo htmlspecialchars($completedSession['Stime']); ?> 
                                                
                                            </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                    </div>







                    
        </div>
        
    </div>
</div>

</div>


</div>

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
