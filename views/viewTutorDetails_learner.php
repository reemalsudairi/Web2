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

?>
<!-- HTML Code  -->
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
<body>
    <main>
        <!-- Tutor Information Section -->
        <div class="custom-block d-flex">
            <div>
                <div class="custom-block-icon-wrap">
                    <div class="custom-block-image-wrap">
                        <!-- <img src="profilepic2;" class="custom-block-image" alt="Tutor Image"> -->
                        <?php if (isset($tutor['profilePic']) && $tutor['profilePic']): ?>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($tutor['profilePic']); ?>" class="custom-block-image img-fluid" alt="Profile Picture">
                        <?php else: ?>
                            <img src="../public/images/profilepic2.jpg" class="custom-block-image img-fluid" alt="Default Profile Picture">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div>
                <div class="custom-block-info">
                    <div class="profile-block d-flex">
                        <span style="color: purple;" class="namebesideflag"><?php echo htmlspecialchars($tutor['Fname']); ?> &nbsp; <?php echo htmlspecialchars($tutor['Lname']); ?></span>
                    </div>
                    <a href="reviewsAsLearner.html" class="rating ratingmargin">★★★★☆ 4.5 </a>
                    <p class="bi-cash-coin purple"><?php echo htmlspecialchars($tutor['price']); ?>/hr</p>
                    <p class="mb-0"><?php echo htmlspecialchars($tutor['bio']); ?></p>
                    <div class="mt-2">
                        <a href="postRequestLearner.php?tutor_id=<?php echo urlencode($tutor['email']); ?>" class="btn custom-btn">Post request</a>
                    </div>
                    <div class="mt-2">
                        <a href="mailto:<?php echo htmlspecialchars($tutor['email']); ?>" class="btn custom-btn">Contact</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Footer -->

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
                    <a class="navbar-brand" href="TutotHomepage.html">
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
