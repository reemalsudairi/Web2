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

    $stmt = $pdo->prepare("SELECT l.*, r.* FROM review r INNER JOIN learner l ON r.Lemail = l.email WHERE Temail = ?");
    $stmt->execute([$tutorId]); 
    $ratings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt2 = $pdo->prepare("SELECT AVG(rating) AS averageRating FROM review WHERE Temail = ?");
    // Execute the query with the bound parameter
    $stmt2->execute([$tutorId]);
        
    // Fetch the result
    $avgrating = $stmt2->fetch(PDO::FETCH_ASSOC);
    // Check if a result was returned
    if ($avgrating && !is_null($avgrating['averageRating'])) {
        $averageRating = number_format($avgrating['averageRating'], 1);  // Formats the number to one decimal place
        // echo "The average rating for $tutorId is $averageRating.";
    } else {
        // echo "No ratings found for $tutorId.";
        $averageRating = 0;
    }

    function generateStarRating($rating) {
        $output = '';
        $fullStars = floor($rating); // Number of full stars
        $halfStar = ($rating - $fullStars >= 0.75) ? 1 : ($rating - $fullStars >= 0.25 ? 0.5 : 0); // Check if there should be a half star
        $emptyStars = 5 - $fullStars - ceil($halfStar); // Remaining stars are empty

        // Add full stars to output
        for ($i = 0; $i < $fullStars; $i++) {
            $output .= '★';
        }

        // Add half star to output if applicable
        if ($halfStar === 0.5) {
            $output .= '☆'; // Assuming ☆ is half filled star; adjust if you have a specific half star character
        }

        // Add empty stars to output
        for ($i = 0; $i < $emptyStars; $i++) {
            $output .= '☆';
        }

        // Return the star output along with the numerical rating
        return $output;
    }

?>
<!-- HTML Code  -->
<!doctype html>
<html lang="en">
    <head> <!--هذي الي عدلتها-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title> Tutorverse - Reviews</title>

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
    <style>
        .review-container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .overall-rating {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
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
            <div class="latest-podcast-section section-padding" id="section_2">

            <div class="container">
                <div class="overall-rating ">
                    <h4 class='section-title'>Overall Rating</h4>
                    <div class="star-rating"><?php
                    // Assuming the average rating is fetched and stored in $averageRating
                    if (isset($averageRating)) {
                        $stars = generateStarRating($averageRating);
                        echo "<p style='font-size: 50px;color: gold;'>$stars</p>";
                    } else {
                        echo "<p>No ratings available.</p>";
                    }
                    ?> <?php echo htmlspecialchars($averageRating); ?> stars</p></div>
                </div>
            </div>

                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-12 col-12">
                            <div class="section-title-wrap mb-5">
                                <h4 class="section-title"> Reviews</h4>
                            </div>
                        
                                

<!-- <div class="row">
    <div class="col-lg-20 col-md-10 col-sm-12 mb-4">
        <div class="custom-block d-flex">
            <div class="">
                <div class="custom-block-icon-wrap">
                    <div class="section-overlay"></div>
                        <img src="../public/images/ahmad.avif" class="custom-block-image img-fluid" alt="">
                   
                        
                </div>
                
            </div>
            

            <div class="custom-block-info">
                <div class="custom-block-top d-flex mb-1">
                    <div class="profile-block d-flex">

                        <p class="namebesideflag">Ahmad</p>
                        
                        <div class="ratingrev">   ★★★★★</div>



                    
                </div>

            
                </div>
                
           <p>Thank you for teaching!</p>

                </div>
                



            </div>

        


</div>  
</div> -->

<!-- <div class="row">
    <div class="col-lg-20 col-md-10 col-sm-12 mb-4">
        <div class="custom-block d-flex">
            <div class="">
                <div class="custom-block-icon-wrap">
                    <div class="section-overlay"></div>
                        <img src="../public/images/profilepic2.jpg" class="custom-block-image img-fluid" alt="">
                   
                        
                </div>
                
            </div>
            

            <div class="custom-block-info">
                <div class="custom-block-top d-flex mb-1">
                    <div class="profile-block d-flex">
                        

                        <p class="namebesideflag">Fatima</p>
                        <div class="ratingrev">★★★★☆</div>

                        


                    
                </div>
    
            
                </div>
                
           <p>Learning English with you is so much fun. Thank you for helping me improve every day !!.</p>
                </div>
                
        
                

            </div>

        
    

</div>   
</div>-->
<!-- <div class="row">
    <div class="col-lg-20 col-md-10 col-sm-12 mb-4">
        <div class="custom-block d-flex">
            <div class="">
                <div class="custom-block-icon-wrap">
                    <div class="section-overlay"></div>
                        <img src="../public/images/profilepic2.jpg" class="custom-block-image img-fluid" alt="">
                   
                        
                </div>
                
            </div>
            


            <div class="custom-block-info">
                <div class="custom-block-top d-flex mb-1">
                    <div class="profile-block d-flex">
                        

                        <p class="namebesideflag">omar</p>
                        
                        <div class="ratingrev">   ★★★★★</div>


                    
                </div>
    
            
                </div>
                
           <p>"She is a good listener and has aided in the refinement of my English skills."</p>
                </div>
                
        
                

            </div>

        
    

</div>  
</div> -->

<!-- <div class="row">
    <div class="col-lg-20 col-md-10 col-sm-12 mb-4">
        <div class="custom-block d-flex">
            <div class="">
                <div class="custom-block-icon-wrap">
                    <div class="section-overlay"></div>
                        <img src="../public/images/rana.jpeg" class="custom-block-image img-fluid" alt="">
                   
                        
                </div>
                
            </div>
            

            <div class="custom-block-info">
                <div class="custom-block-top d-flex mb-1">
                    <div class="profile-block d-flex">
                        

                        <p class="namebesideflag">Rana</p>
                        <div class="ratingrev">★★★★★</div>

                        


                    
                </div>
    
            
                </div>
                
           <p>I love how you always listen to me and help me when I don't understand something:)</p>
                </div>
                
        
                

            </div>

        
    

</div>  
</div> -->
<!-- <div class="row">
    <div class="col-lg-20 col-md-10 col-sm-12 mb-4">
        <div class="custom-block d-flex">
            <div class="">
                <div class="custom-block-icon-wrap">
                    <div class="section-overlay"></div>
                        <img src="../public/images/profilepic2.jpg" class="custom-block-image img-fluid" alt="">
                        
                </div>
                
            </div>
            

            <div class="custom-block-info">
                <div class="custom-block-top d-flex mb-1">
                    <div class="profile-block d-flex">
                        

                        <p class="namebesideflag">Joury</p>
                        
                        <div class="ratingrev">★★★☆☆</div>


                    
                </div>
    
            
                </div>
                
           <p> Still struggling with public speaking fears in English, but grateful for the support.</p>
                </div>
                
        
                

            </div>

        </div>
        </div>-->

        <div class="row">
        <?php foreach ($ratings as $rating): ?>
        <div class="col-lg-20 col-md-10 col-sm-12 mb-4">
            <div class="custom-block d-flex">
                <div class="">
                    <div class="custom-block-icon-wrap">
                        <div class="section-overlay"></div>
                            <!-- <img src="../public/images/profilepic2.jpg" class="custom-block-image img-fluid" alt=""> -->
                            <?php if (isset($tutor['profilePic']) && $tutor['profilePic']): ?>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($tutor['profilePic']); ?>" class="custom-block-image img-fluid" alt="Profile Picture">
                        <?php else: ?>
                            <img src="../public/images/profilepic2.jpg" class="custom-block-image img-fluid" alt="Default Profile Picture">
                        <?php endif; ?>
                    </div>
                    
                </div>
                

                <div class="custom-block-info">
                    <div class="custom-block-top d-flex mb-1">
                        <div class="profile-block d-flex">
                            

                            <p class="namebesideflag"><?php echo htmlspecialchars($rating['Fname']); ?> &nbsp; <?php echo htmlspecialchars($rating['Lname']); ?></p>
                            
                            <div class="ratingrev"><?php
                            // Assuming the average rating is fetched and stored in $averageRating
                            if (isset($rating['rating'])) {
                                $stars = generateStarRating($rating['rating']);
                                echo "<p style='color: gold;'>$stars</p>";
                            } else {
                                echo "<p>No ratings available.</p>";
                            }
                            ?></div>


                        
                    </div>
        
                
                    </div>
                    
            <p> <?php echo htmlspecialchars($rating['review']); ?></p>
                    </div>
                    
            
                    

                </div>

            </div>
            </div>
            
        </div>
        <?php endforeach; ?>
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

