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
        $stmt = $pdo->query("SELECT t.Fname, t.Lname, t.email, t.price, t.bio, t.profilepic, AVG(r.rating) AS averageRating FROM  tutor t LEFT JOIN review r ON t.email = r.Temail GROUP BY t.Fname, t.Lname, t.email, t.price, t.bio, t.profilepic;"); // Adjust according to your database schema
        $tutors = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo "Database error: " . $e->getMessage();
        $tutors = [];
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
<!-- HTML code -->
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>Tutorverse - Tutor List</title>

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

       
            <div class="latest-podcast-section section-padding" id="section_2"><!--بداية التوتر لست-->
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-12 col-12">
                            <div class="section-title-wrap mb-5">
                                <h4 class="section-title">Meet Our Tutors</h4>
                            </div>
                        </div>

                                               
                         <!-- <div class="col-lg-3 col-12 mb-4 mb-lg-0 tutor-container ratingmargin">
                            <div class="custom-block custom-block-full">
                                <div class="custom-block-image-wrap">
                                    
                                        <img src="../public/images/elsa.webp" class="custom-block-image img-fluid" alt="">
                                   
                                </div>
            
                                <div class="profile-block d-flex">
                                    <p class="namebesideflag">Elsa</p> 
                                        <a href="reviewsAsLearner.html" class="rating ratingmargin">★★★☆☆ 3.7</a><br>

                                
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


                        <div class="col-lg-3 col-12 mb-4 mb-lg-0 tutor-container ratingmargin">
                            <div class="custom-block custom-block-full">
                                <div class="custom-block-image-wrap">
                                        <img src="../public/images/Camila.webp" class="custom-block-image img-fluid" alt="">
                                </div>
            
                                <div class="profile-block d-flex">
                                    <p class="namebesideflag">Camila</p>
                                        <a href="reviewsAsLearner.html" class="rating ratingmargin">★★★★★ 5</a>
                                      

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
                        
                        <div class="col-lg-3 col-12 mb-4 mb-lg-0 tutor-container ratingmargin">

                            <div class="custom-block custom-block-full">
                                <div class="custom-block-image-wrap">
                                        <img src="../public/images/kevincopy.png" class="custom-block-image img-fluid" alt="">
                                    
                                </div>
            
                                <div class="profile-block d-flex">
                                    <p class="namebesideflag">Kevin</p>   
                                        <a href="reviewsAsLearner.html" class="rating ratingmargin">★★★★☆ 4.3</a>
                                    
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
                        

                        <div class="col-lg-3 col-12 mb-4 mb-lg-0 tutor-container ratingmargin">
                            <div class="custom-block custom-block-full">
                                <div class="custom-block-image-wrap">
                                   
                                        <img src="../public/images/handsome-asian-man-listening-music-through-headphones.jpg" class="custom-block-image img-fluid" alt="">
                                
                                </div>
            
                                <div class="profile-block d-flex">
                                    <p class="namebesideflag">Chan </p>  
                                        <a href="reviewsAsLearner.html" class="rating ratingmargin">★★★★☆ 4.9</a>
                                    
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
          
                    

                        <div class="col-lg-3 col-12 mb-4 mb-lg-0 tutor-container">
                            <div class="custom-block custom-block-full">
                                <div class="custom-block-image-wrap">
                                        <img src="../public/images/sauditutor.jpeg" class="custom-block-image img-fluid" alt="">
                                </div>
            
                                <div class="profile-block d-flex">
                                    <p class="namebesideflag">Mohammad</p>
                                        <a href="reviewsAsLearner.html" class="rating ratingmargin">★★★★☆ 4.2</a>
                                    
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


                        <div class="col-lg-3 col-12 mb-4 mb-lg-0 tutor-container ratingmargin">
                            <div class="custom-block custom-block-full">
                                <div class="custom-block-image-wrap">
                                        <img src="../public/images/David1.jpeg" class="custom-block-image img-fluid" alt="">
                                   
                                </div>
            
                                <div class="profile-block d-flex">
                                    <p class="namebesideflag">Daniella  </p> 
                                        <a href="reviewsAsLearner.html" class="rating ratingmargin">★★★★☆ 4.1</a>
                                    
                                </div>
                                <span class="bi-cash-coin purple"> &#36; 11/hr</span>

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
                        </div> -->

                <div class="row">
                <?php foreach ($tutors as $tutor): ?>
                        <div class="col-lg-3 col-12 mb-4 mb-lg-0">
                            <div class="custom-block custom-block-full">
                                <div class="custom-block-image-wrap">
                                <?php $mimeType = getMimeType($tutor['profilepic']); ?>
                                    <img src="data:<?php echo $mimeType; ?>;base64,<?php echo $tutor['profilepic']; ?>" class=" custom-block-image img-fluid" alt="Profile Picture">
                                </div>

                                <div class="profile-block d-flex">
                                    <p class="namebesideflag"><?php echo htmlspecialchars($tutor['Fname']); ?> &nbsp; <?php echo htmlspecialchars($tutor['Lname']); ?>
                                        
                                    <a href="reviewsLearner.php?tutor_id=<?php echo urlencode($tutor['email']); ?>" class="rating ratingmargin"> <?php echo htmlspecialchars(number_format($tutor['averageRating'] ?? 0, 1)); ?> ★ Rating</a>
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
                        <br>
                        <?php endforeach; ?>
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

</body>

</html>