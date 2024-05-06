<?php

    include '../src/dbConnect.php';

    // attempting to query the application version
    try {
        $stmt = $pdo->query("SELECT * FROM version WHERE id = 1"); // getting data from the dummy table to get the version
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(Exception $e) {
        echo "Database error:  " . $e->getMessage();
        $rows = [];
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
                    <a class="navbar-brand me-lg-5 me-0" href="index.php">
                        <img src="images/logotuterverse.png" class="logo-image img-fluid" alt="tutorverse logo">
                    </a>
                    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-lg-auto">
                            <li class="nav-item">
                                <a class="nav-link active" href="index.php">Home</a>
                            </li> <!--لينك صفحة الهوم-->

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Contact</a>
                                <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                                    <li><a class="dropdown-item" href="tel:0508197538">Call us</a></li>
                                    <li><a class="dropdown-item" href="mailto:tutorverse@hotmail.com">Email us</a></li>
                                </ul>
                            </li><!--لينك كونتاكت-->

                        </ul>


                        <div class="ms-4 nav-item dropdown">
                      
                            <a href="" class="btn custom-btn .custom-btn-signlogin smoothscroll" role="button" data-bs-toggle="dropdown" aria-expanded="false">sign up</a>
                            <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                                <li><a class="dropdown-item" href="../views/signupLearner.php">as a learner</a></li>
                                <li><a class="dropdown-item" href="../views/signupTutor.php">as a tutor</a></li>
        
                            </ul>
                        </div>

                        <div class="ms-4">
                            <a href="../views/login.php" class="btn custom-btn .custom-btn-signlogin smoothscroll">Log in</a>
                        </div>

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

                
            <!-- ***** Welcome Area Start ***** -->
            <div class="welcome-area" id="welcome">

                <!-- ***** Header Text Start ***** -->
                <div class="header-text">
                    <div class="container">
                        <div class="row">
                            <div class=" col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
                             <h1><strong>Tutorverse, Where Fluency Begins.</strong></h1>
                             <p>Whether you're a learner seeking language mastery or a tutor looking to inspire and empower, Tutorverse is your gateway to language excellence.</p>
                                <a href="#about" class="btn custom-btn custom-border-btn smoothscroll">Find Out More</a>
                            </div>  
                                
                               


                        

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" >
                                <img src="images/Kids-Online-Classes.png" class="rounded img-fluid d-block mx-auto" alt="Online-Classes"> 
                                </div>
                        </div>
                    </div>
                </div>
                 <!-- ***** Header Text End ***** -->
             </div>
            <!-- ***** Welcome Area End ***** -->





            <div class="col-lg-11 col-12 mx-auto">
                <div class="pb-5 mb-5">
                    <div class="section-title-wrap mb-4">
                        <h4 id="about"  class = "section-title">About Us</h4>
                    </div>

                    <div class="col-lg-8 col-12 mx-auto">
                    <p>At Tutorverse, we believe that learning knows no bounds. Our platform is designed to connect eager learners with passionate tutors from around the globe, creating a dynamic and personalized learning experience for students of all ages and backgrounds.</p>

                    <p>Founded on the principles of accessibility, affordability, and excellence, Tutorverse aims to revolutionize the way people learn and teach. Whether you're looking to master a new language, brush up on academic subjects, prepare for standardized tests, or delve into a specialized skill, Tutorverse has got you covered.</p>

                    <p>Our community of tutors consists of dedicated professionals, experts in their respective fields, who are committed to empowering students to reach their full potential. They bring not only their knowledge and expertise but also their enthusiasm and encouragement to every session.</p>

                    <p>What sets Tutorverse apart is our commitment to flexibility and convenience. With our user-friendly platform, students can schedule sessions at their convenience, connect with tutors from anywhere in the world, and access a wealth of resources to support their learning journey.</p>

                    <p>At Tutorverse, we believe that education is the key to unlocking endless possibilities. Join us today and embark on a journey of discovery, growth, and success!</p>

                    </div>
                </div>
            </div>

            <div class="col-lg-11 col-12 mx-auto">
                <div class="pb-5 mb-5">
                    <div class="section-title-wrap mb-4">
                        <h4 id="reviews"  class = "section-title">Happy Users</h4>
                        
                    </div>

                   
                <div class="row">
                    <div class="col-lg-8 col-12 mx-auto">
                        <div class="custom-block d-flex">
                            <div class="">
                                <div class="custom-block-icon-wrap">
                                    <div class="section-overlay"></div>
                                    <a href="" class="custom-block-image-wrap">
                                        <img src="images/rana.jpeg" class="custom-block-image img-fluid" alt="">
                                    </a>
                                   
                                        
                                </div>
                                
                            </div>
                            

                            <div class="custom-block-info">
                                <div class="custom-block-top d-flex mb-1">
                                    <div class="profile-block d-flex">
                                        

                                        <p class="namebesideflag"> Rana</p>
                                        
                                        <div class="ratingrev col-lg-8 col-12 mx-auto"></div>

                                    
                                </div>
                    
                            
                                </div>
                                
                           <p>Tutorverse is amazing! Great courses and supportive tutors.</p>
                                </div>
                                
                        
                                

                            </div>

                        
                    
                
                </div>  
            </div>

            <br>

            <div class="row">
                <div class="col-lg-8 col-12 mx-auto">
                    <div class="custom-block d-flex">
                        <div class="">
                            <div class="custom-block-icon-wrap">
                                <div class="section-overlay"></div>
                                <a href="" class="custom-block-image-wrap">
                                    <img src="images/David1.jpeg" class="custom-block-image img-fluid" alt="">
                                </a>
                               
                                    
                            </div>
                            
                        </div>
                        

                        <div class="custom-block-info">
                            <div class="custom-block-top d-flex mb-1">
                                <div class="profile-block d-flex">
                                    

                                    <p class="namebesideflag"> David</p>
                                    
                                    <div class="ratingrev col-lg-8 col-12 mx-auto"></div>

                                
                            </div>
                
                        
                            </div>
                            
                       <p>Tutorverse empowers me as a tutor to witness my students' language improvements.</p>
                            </div>
                            
                    
                            

                        </div>

                    
                
            
            </div>  
        </div>

        <br>
        <div class="row">
            <div class="col-lg-8 col-12 mx-auto">
                <div class="custom-block d-flex">
                    <div class="">
                        <div class="custom-block-icon-wrap">
                            <div class="section-overlay"></div>
                            <a href="" class="custom-block-image-wrap">
                                <img src="images/profilepic2.jpg" class="custom-block-image img-fluid" alt="">
                            </a>
                           
                                
                        </div>
                        
                    </div>
                    

                    <div class="custom-block-info">
                        <div class="custom-block-top d-flex mb-1">
                            <div class="profile-block d-flex">
                                

                                <p class="namebesideflag"> omar</p>
                                
                                <div class="ratingrev col-lg-8 col-12 mx-auto"></div>

                            
                        </div>
            
                    
                        </div>
                        
                   <p>Tutorverse made language learning a breeze. Excellent platform! </p>
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
                        <a class="navbar-brand" href="mainHome.html">
                            <img src="images/logo.png" class="logo-image img-fluid" alt="tutorverse logo">
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
