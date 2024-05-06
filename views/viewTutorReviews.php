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
?>
<!-- HTML Code -->
<!doctype html>
<html lang="en">
    <head> <!--هذي الي عدلتها-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title> Tutorverse - My Reviews</title>

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
            <div class="latest-podcast-section section-padding" id="section_2">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-12 col-12">
                            <div class="section-title-wrap mb-5">
                                <h4 class="section-title"> My Reviews</h4>
                            </div>
                        
                                

<div class="row">
    <div class="col-lg-20 col-md-10 col-sm-12 mb-4">
        <div class="custom-block d-flex">
            <div class="">
                <div class="custom-block-icon-wrap">
                    <div class="section-overlay"></div>
                        <img src="images/ahmad.avif" class="custom-block-image img-fluid" alt="">
                   
                        
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
</div>

<div class="row">
    <div class="col-lg-20 col-md-10 col-sm-12 mb-4">
        <div class="custom-block d-flex">
            <div class="">
                <div class="custom-block-icon-wrap">
                    <div class="section-overlay"></div>
                        <img src="images/profilepic2.jpg" class="custom-block-image img-fluid" alt="">
                   
                        
                </div>
                
            </div>
            

            <div class="custom-block-info">
                <div class="custom-block-top d-flex mb-1">
                    <div class="profile-block d-flex">
                        

                        <p class="namebesideflag">Fatima</p>
                        <div class="ratingrev">★★★★☆ </div>

                        


                    
                </div>
    
            
                </div>
                
           <p>Learning English with you is so much fun. Thank you for helping me improve every day !!.</p>
                </div>
                
        
                

            </div>

        
    

</div>  
</div>
<div class="row">
    <div class="col-lg-20 col-md-10 col-sm-12 mb-4">
        <div class="custom-block d-flex">
            <div class="">
                <div class="custom-block-icon-wrap">
                    <div class="section-overlay"></div>
                        <img src="images/profilepic2.jpg" class="custom-block-image img-fluid" alt="">
                   
                        
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
</div>

<div class="row">
    <div class="col-lg-20 col-md-10 col-sm-12 mb-4">
        <div class="custom-block d-flex">
            <div class="">
                <div class="custom-block-icon-wrap">
                    <div class="section-overlay"></div>
                        <img src="images/rana.jpeg" class="custom-block-image img-fluid" alt="">
                   
                        
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
</div>
<div class="row">
    <div class="col-lg-20 col-md-10 col-sm-12 mb-4">
        <div class="custom-block d-flex">
            <div class="">
                <div class="custom-block-icon-wrap">
                    <div class="section-overlay"></div>
                        <img src="images/profilepic2.jpg" class="custom-block-image img-fluid" alt="">
                        
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

