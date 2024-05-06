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

    // echo $_SESSION['user_email'];
    try {
        $stmt = $pdo->prepare("SELECT t.*, p.* FROM tutor t INNER JOIN postrequest p ON t.email = p.Temail WHERE p.Lemail = ?");
        $stmt->execute([$_SESSION['user_email']]);
        $Reqtutors = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
        echo "Database error: " . $e->getMessage();
        $Lreq = [];
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

        <title>Tutorverse - Session Requests</title>

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
                        
                        <!-- <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="custom-block d-flex">
                                <div class="">
                                        
                                    <div class="custom-block-icon-wrap">
                                        <a class="custom-block-image-wrap">
                                            <img src="../public/images/sauditutor.jpeg" class="custom-block-image2  img-fluid" alt="">
                                        </a>
                                    </div>
    
                                    <div class="mt-2 buttonsbesideeachother">
                                        <a href="EditRequest.html" class="btn custom-btn customedit-btn" style="margin:1px;" >
                                            Edit
                                        </a> 
                                          
                                        <a href="#" class="btn custom-btn customreject-btn" style="margin:1px;">
                                            Delete
                                        </a>
                                    </div>
                                </div>
    
                                <div class="custom-block-info">
                                    <div class="custom-block-top d-flex mb-1">
                                        <small class="me-4">
                                            <i class="bi-hourglass-top custom-icon"></i>
                                                10 Minutes Remaining
                                        </small>
    
                                    </div>
    
                                    <div class="profile-block d-flex">
                                        
                                           <p class="namebesideflag">Omar</p>
                                               
                                    </div>
                                    <p class="mb-0 languagetext">Language: Arabic</p>
                                    <p class="mb-0 smallfont"> Date: 15/2/2024 <br> Time: 10:00pm <br> Proficiency: Intermediate<br> <i class="bi-clock-fill custom-icon "></i> 30 Minutes<br>status:<a class="custompending-btn accrejtag">
                                        Pending
                                    </a></p>
                                </div>
                                    
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="custom-block d-flex">
                                <div class="">
                                        
                                    <div class="custom-block-icon-wrap">
                                        <a class="custom-block-image-wrap">
                                            <img src="../public/images/elsa.webp" class="custom-block-image2  img-fluid" alt="">
                                        </a>
                                    </div>
    
                                    <div class="mt-2 buttonsbesideeachother">
                                        <a href="EditRequest.html" class="btn custom-btn customedit-btn" style="margin:1px;">
                                            Edit
                                        </a> 

                                        <a href="#" class="btn custom-btn customreject-btn" style="margin:1px;">
                                            Delete
                                        </a>
                                    </div>
                                </div>
    
                                <div class="custom-block-info">
                                    <div class="custom-block-top d-flex mb-1">
                                        <small class="me-4">
                                            <i class="bi-hourglass-top custom-icon"></i>
                                                30 Minutes Remaining
                                        </small>
    
                                    </div>
    
                                    <div class="profile-block d-flex">
                                       
                                           <p class="namebesideflag"> Elsa</p>
                                               
                                    </div>
                                    <p class="mb-0 languagetext">Language: English</p>
                                    <p class="mb-0 smallfont"> Date: 9/4/2024 <br> Time: 11:00pm <br> Proficiency: Intermediate<br> <i class="bi-clock-fill custom-icon "></i> 50 Minutes<br>status:<a class="custompending-btn accrejtag">
                                        Pending
                                    </a></p>
                                </div>
                                    
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="custom-block d-flex">
                                <div class="">
                                        
                                    <div class="custom-block-icon-wrap">
                                        <a class="custom-block-image-wrap">
                                            <img src="../public/images/kevincopy.png" class="custom-block-image2  img-fluid" alt="">
                                        </a>
                                    </div>
    
                                    <div class="mt-2 buttonsbesideeachother">
                                        <a href="EditRequest.html" class="btn custom-btn customedit-btn" style="margin:1px;">
                                            Edit
                                        </a> 

                                        <a href="#" class="btn custom-btn customreject-btn" style="margin:1px;">
                                            Delete
                                        </a>
                                    </div>
                                </div>
    
                                <div class="custom-block-info">
                                    <div class="custom-block-top d-flex mb-1">
                                        <small class="me-4">
                                            <i class="bi-hourglass-top custom-icon"></i>
                                                40 Minutes Remaining
                                        </small>
    
                                    </div>
    
                                    <div class="profile-block d-flex">
                                        
                                           <p class="namebesideflag"> Kavin</p>
                                               
                                    </div>
                                    <p class="mb-0 languagetext">Language: Spanish</p>
                                    <p class="mb-0 smallfont"> Date: 23/5/2024 <br> Time: 9:00pm <br> Proficiency: Intermediate<br> <i class="bi-clock-fill custom-icon "></i> 40 Minutes<br>status:<a class="custompending-btn accrejtag">
                                        Pending
                                    </a></p>
                                </div>
                                    
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="custom-block d-flex">
                                <div class="">
                                        
                                    <div class="custom-block-icon-wrap">
                                        <a class="custom-block-image-wrap">
                                            <img src="../public/images/profilepic2.jpg" class="custom-block-image2  img-fluid" alt="">
                                        </a>
                                    </div>
                                      
                                    <div class="mt-2 buttonsbesideeachother">
                                        <a href="EditRequest.html" class="btn custom-btn customedit-btn" style="margin:1px;" >
                                            Edit
                                        </a> 

                                        <a href="#" class="btn custom-btn customreject-btn" style="margin:1px;">
                                            Delete
                                        </a>
                                    </div>
                                </div>
    
                                <div class="custom-block-info">
                                    <div class="custom-block-top d-flex mb-1">
                                        <small class="me-4">
                                            <i class="bi-hourglass-top custom-icon"></i>
                                                50 Minutes Remaining
                                        </small>
    
                                    </div>
    
                                    <div class="profile-block d-flex">
                                        
                                           <p class="namebesideflag"> Ahmad</p>
                                               
                                    </div>
                                    <p class="mb-0 languagetext">Language: Arabic</p>
                                    <p class="mb-0 smallfont"> Date: 18/3/2024 <br> Time: 9:00pm <br> Proficiency: Intermediate<br> <i class="bi-clock-fill custom-icon "></i> 60 Minutes<br>status:<a class="custompending-btn accrejtag">
                                        Pending
                                    </a></p>
                                </div>
                                    
                            </div>
                        </div> -->

                        <div class="container">
                            <div class="row">
                                <?php foreach ($Reqtutors as $Reqtutor): ?>
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                        <div class="custom-block d-flex">
                                            <div class="">
                                                <div class="custom-block-icon-wrap">
                                                    <a class="custom-block-image-wrap">
                                                    <?php if (isset($Reqtutor['profilePic']) && $Reqtutor['profilePic']): ?>
                                                        <img src="data:image/jpeg;base64,<?php echo base64_encode($Reqtutor['profilePic']); ?>" class="custom-block-image img-fluid" alt="Profile Picture">
                                                    <?php else: ?>
                                                        <img src="../public/images/profilepic2.jpg" class="custom-block-image img-fluid" alt="Default Profile Picture">
                                                    <?php endif; ?>
                                                    </a>
                                                </div>
                                                
                                                <div class="mt-2 buttonsbesideeachother">
                                                    <a href="editRequestsLearner.php?req_id=<?php echo urlencode($Reqtutor['postReqID']); ?>" class="btn custom-btn customedit-btn" style="margin:1px;">
                                                        Edit
                                                    </a> 
                                                    <a href="#" class="btn custom-btn customreject-btn" style="margin:1px;">
                                                        Delete
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="custom-block-info">
                                                <div class="custom-block-top d-flex mb-1">
                                                    <small class="me-4">
                                                        <i class="bi-hourglass-top custom-icon"></i>
                                                        50 Minutes Remaining
                                                    </small>
                                                </div>

                                                <div class="profile-block d-flex">
                                                    <p class="namebesideflag"><?php echo htmlspecialchars($Reqtutor['Fname']); ?> &nbsp; <?php echo htmlspecialchars($Reqtutor['Lname']); ?></p>
                                                </div>
                                                <p class="mb-0 languagetext">Language: <?php echo htmlspecialchars($Reqtutor['language']); ?></p>
                                                <p class="mb-0 smallfont"> Date: <?php echo htmlspecialchars($Reqtutor['date']); ?> <br> Time: <?php echo htmlspecialchars($Reqtutor['Stime']); ?> <br> Proficiency: <?php echo htmlspecialchars($Reqtutor['Lproficiency']); ?><br> <i class="bi-clock-fill custom-icon"></i> 60 Minutes<br>status:<a class="custompending-btn accrejtag">
                                                    Pending
                                                </a></p>
                                            </div>
                                                
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>



                        <div class="col-lg-12 col-12 mx-auto">
                            <div class="section-title-wrap mb-5"><br>
                                <h4 id="acceptedreq" class="section-title">Accepted Requests</h4>
                   
                            </div>
                           
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="custom-block d-flex">
                                <div class="">
                                    <div class="custom-block-icon-wrap">
                                        
                                            <a href="detail-page.html" class="custom-block-image-wrap"> </a>
                                                 <img src="../public/images/profilepic2.jpg" class="custom-block-image img-fluid" alt="">    
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
                                            
 
                                             <p class="namebesideflag">chan cao</p>
                                        </div>
                                        <p class="mb-0 languagetext">Language:Chinese</p>
                                        <p class="mb-0 smallfont">Date: 18/2/2024 <br> Time: 10:00pm<br> Proficiency: Intermediate<br> 
                                            status: 
                                            <a class="customaccept-btn accrejtag">
                                              Accepted
                                            </a>
                                        </p>

                                    </div>
                                
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="custom-block d-flex">
                                <div class="">
                                    <div class="custom-block-icon-wrap">
                                        
                                            <a href="detail-page.html" class="custom-block-image-wrap"> </a>
                                                 <img src="../public/images/elsa.webp" class="custom-block-image img-fluid" alt="">    
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
                                           
 
                                             <p class="namebesideflag">Elsa</p>
                                        </div>
                                        <p class="mb-0 languagetext">Language:English</p>
                                        <p class="mb-0 smallfont">Date: 12/2/2024 <br> Time: 10:00pm<br> Proficiency: Intermediate<br> 
                                            status: 
                                            <a class="customaccept-btn accrejtag">
                                              Accepted
                                            </a>
                                        </p>

                                    </div>
                                
                            </div>
                        </div>



                        
                        <div class="col-lg-12 col-12 mx-auto">
                            <div class="section-title-wrap mb-5"><br>
                                <h4 id="Rejectedreq" class="section-title">Rejected Requests</h4>
                   
                            </div>
                        </div>


                            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                <div class="custom-block d-flex">
                                    <div class="">
                                        <div class="custom-block-icon-wrap">

                                            <div class="custom-block-icon-wrap">
                                            
                                                <div class="custom-block-icon-wrap">
                                            
                                                    <a class="custom-block-image-wrap">
                                                        <!--img-fluid-->
                                                        <img src="../public/images/profilepic2.jpg" class="custom-block-image2  img-fluid" alt="">
        
                                                    </a>
                                                </div>
                                                 
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="custom-block-info">
                                        <div class="custom-block-top d-flex mb-1">
                                            <small class="me-4">
                                                <i class="bi-clock-fill custom-icon"></i>
                                                40 Minutes
                                            </small>
    
                                        </div>
    
                                        <div class="profile-block d-flex">
                                            
    
                                            <p class="namebesideflag">Sarah</p>
                                        </div>
                                        <p class="mb-0 languagetext">Language:English</p>
                                        <p class="mb-0 smallfont">Date: 22/2/2024 <br> Time: 10:00pm<br> Proficiency: Intermediate<br> 
                                             status:
                                            <a class="customreject-btn accrejtag">
                                               Rejected
                                            </a>
                                        </p>
    
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                <div class="custom-block d-flex">
                                    <div class="">
                                        <div class="custom-block-icon-wrap">

                                            <div class="custom-block-icon-wrap">
                                            
                                                <div class="custom-block-icon-wrap">
                                            
                                                    <a class="custom-block-image-wrap">
                                                        <!--img-fluid-->
                                                        <img src="../public/images/Camila.webp" class="custom-block-image2  img-fluid" alt="">
        
                                                    </a>
                                                </div>
                                                 
                                            </div>
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
                                        <p class="mb-0 languagetext">Language:English</p>
                                        <p class="mb-0 smallfont">Date: 9/2/2024 <br> Time: 11:00pm<br> Proficiency: Intermediate<br> 
                                             status:
                                            <a class="customreject-btn accrejtag">
                                               Rejected
                                            </a>
                                        </p>
    
                                    </div>
                                </div>
                            </div>
                           

                            


                    </div>
                </div>  
                    
            </div>
                                    
    
    
    
                                                    
            
                                                       
                                                   
                                           
                                
               
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