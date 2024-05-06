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
        $stmt = $pdo->prepare("SELECT l.*, p.* FROM learner l INNER JOIN postrequest p ON l.email = p.Lemail WHERE p.Temail = ?");
        $stmt->execute([$_SESSION['user_email']]);
        $ReqLearners = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
        echo "Database error: " . $e->getMessage();
        $Lreq = [];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == 'save') {

        // Handle form submission
        $reqID = $_POST['reqID'];
        $learnerMail = $_POST['learnerMail'];
        $userMail = $_SESSION['user_email'];
        
        try {
            // Prepare the query to fetch the request details
            $stmt = $pdo->prepare("SELECT * FROM postrequest WHERE postReqID = :reqID");
            $stmt->execute([':reqID' => $reqID]); // Bind parameter correctly using associative array
            $reqPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Check if any post requests were fetched and then proceed
            if ($reqPosts) {
                $reqPost = $reqPosts[0]; // Assuming you are fetching one post by ID, get the first result.

                // Now prepare the insert statement
                $stmt2 = $pdo->prepare("INSERT INTO request (Stime, date, duration, status, language, remainingT, Lemail, Temail) VALUES (:Stime, :date, :duration, :status, :language, :remainingT, :Lemail, :Temail)");

                // Execute the insert statement with parameters bound
                $stmt2->execute([
                    ':Stime' => $reqPost['Stime'],
                    ':date' => $reqPost['date'],
                    ':duration' => $reqPost['requestDuration'],
                    ':status' => "Accepted",
                    ':language' => $reqPost['language'],
                    ':remainingT' => $reqPost['Stime'], // This should possibly be a different value?
                    ':Lemail' => $reqPost['Lemail'],
                    ':Temail' => $reqPost['Temail']
                ]);

                $stmt3 = $pdo->prepare("INSERT INTO session (date, Stime, duration, status, language, Lemail, Temail) VALUES (:Stime, :date, :duration, :status, :language, :Lemail, :Temail)");
                $stmt3->execute([
                    ':Stime' => $reqPost['Stime'],
                    ':date' => $reqPost['date'],
                    ':duration' => $reqPost['requestDuration'],
                    ':status' => "Accepted",
                    ':language' => $reqPost['language'],
                    ':Lemail' => $reqPost['Lemail'],
                    ':Temail' => $reqPost['Temail']
                ]);

                // If update is successful, proceed to delete the request from 'postrequest'
                $stmt4 = $pdo->prepare("DELETE FROM postrequest WHERE postReqID = :reqID");
                $stmt4->execute([':reqID' => $reqID]);

                $success = "Request updated successfully!";
            } else {
                $success = "No post request found with the specified ID.";
            }

            // echo $success;


            // Redirect to the same page to refresh and show the success message
            header('Location: '.$_SERVER['PHP_SELF']);
            exit();

        } catch(Exception $e) {
            $error = "Error updating request: " . $e->getMessage();
        }
    }
    else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == 'delete') {
        // echo "Delete triggered";
        // Handle form submission
        $reqID = $_POST['reqID'];
        $learnerMail = $_POST['learnerMail'];
        $userMail = $_SESSION['user_email'];
        try {
            $stmt = $pdo->prepare("SELECT * FROM postrequest WHERE postReqID = :reqID");
            $stmt->execute([':reqID' => $reqID]); // Bind parameter correctly using associative array
            $reqPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Check if any post requests were fetched and then proceed
            if ($reqPosts) {
                $reqPost = $reqPosts[0]; // Assuming you are fetching one post by ID, get the first result.

                // Now prepare the insert statement
                $stmt2 = $pdo->prepare("INSERT INTO request (Stime, date, duration, status, language, remainingT, Lemail, Temail) VALUES (:Stime, :date, :duration, :status, :language, :remainingT, :Lemail, :Temail)");

                // Execute the insert statement with parameters bound
                $stmt2->execute([
                    ':Stime' => $reqPost['Stime'],
                    ':date' => $reqPost['date'],
                    ':duration' => $reqPost['requestDuration'],
                    ':status' => "Rejected",
                    ':language' => $reqPost['language'],
                    ':remainingT' => $reqPost['Stime'], // This should possibly be a different value?
                    ':Lemail' => $reqPost['Lemail'],
                    ':Temail' => $reqPost['Temail']
                ]);

                // If update is successful, proceed to delete the request from 'postrequest'
                $stmt3 = $pdo->prepare("DELETE FROM postrequest WHERE postReqID = :reqID");
                $stmt3->execute([':reqID' => $reqID]);

                $success = "Request updated successfully!";
            } else {
                $success = "No post request found with the specified ID.";
            }

        } catch(Exception $e) {
            $error = "Error updating request: " . $e->getMessage();
        }
    }

    try {
        $stmt = $pdo->prepare("SELECT l.*, r.* FROM learner l INNER JOIN request r ON l.email = r.Lemail WHERE status = 'Accepted' AND r.Temail = ?");
        $stmt->execute([$_SESSION['user_email']]);
        $acceptedReqs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
        echo "Database error: " . $e->getMessage();
        $Lreq = [];
    }

    try {
        $stmt = $pdo->prepare("SELECT l.*, r.* FROM learner l INNER JOIN request r ON l.email = r.Lemail WHERE status = 'Rejected' AND r.Temail = ?");
        $stmt->execute([$_SESSION['user_email']]);
        $rejectedReqs = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

<style>
.custompending-btn{
    background: gray;
    border:2px solid grey;
    margin-bottom:5px
    }
    </style>
    </head>
    <body>

            <main>

            <nav class="navbar navbar-expand-lg">
                <div class="container">
                    <a class="navbar-brand me-lg-5 me-0" href="tutorHomePage.php">
                        <img src="../public/images/logotuterverse.png" class="logo-image img-fluid" alt="Tutorverse logo">
                    </a>
                    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-lg-auto">

                            <li class="nav-item">
                                <a class="nav-link " href="tutorHomePage.php">Home</a>
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
                                    <li><a class="dropdown-item" href="tutorViewProfile.php">View Profile</a></li>
                                    <li><a class="dropdown-item" href="viewTutorRequests.php">View Requests</a></li>
                                    <li><a class="dropdown-item" href="viewTutorReviews.php">View Reviews</a></li>
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

                            <!--لينك كونتاكت-->
                        
                            

                                    
                            <!-- <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                <div class="custom-block d-flex">
                                    <div class="">
                                        
                                        <div class="custom-block-icon-wrap">
                                            
                                            <a class="custom-block-image-wrap">
                                                <img src="../public/images/profilepic2.jpg" class="custom-block-image2  img-fluid" alt="">

                                            </a>
                                        </div>
    
                                        <div class="mt-2 buttonsbesideeachother">
                                            <a href="#" class="btn custom-btn customaccept-btn" style="margin:1px;">
                                                Accept
                                            </a> 

                                            <a href="#" class="btn custom-btn customreject-btn" style="margin:1px;">
                                                Reject
                                            </a>
                                        </div>
                                    </div>
    
                                    <div class="custom-block-info">
                                        <div class="custom-block-top d-flex mb-1">
                                            <small class="me-4">
                                                <i class="bi-hourglass-bottom custom-icon"></i>
                                                1 Minute Remaining
                                            </small>
    
                                        </div>
    
                                        <div class="profile-block d-flex">
    
                                           <p class="namebesideflag"> Ahmad</p>
                                               
                                        </div>
                                        <p class="mb-0 languagetext">Language: Arabic</p>
                                        <p class="mb-0 smallfont"> Date: 15/2/2024 <br> Time: 10:00pm <br> Proficiency: Intermediate<br> <i class="bi-clock-fill custom-icon "></i> 60 Minutes<br>status:<a class="custompending-btn accrejtag">
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
                                            <a href="#" class="btn custom-btn customaccept-btn" style="margin:1px;" >
                                                Accept
                                            </a> 

                                            <a href="#" class="btn custom-btn customreject-btn" style="margin:1px;">
                                                Reject
                                            </a>
                                        </div>
                                    </div>
    
                                    <div class="custom-block-info">
                                        <div class="custom-block-top d-flex mb-1">
                                            <small class="me-4">
                                                <i class="bi-hourglass-bottom custom-icon"></i>
                                                10 Minutes Remaining
                                            </small>
    
                                        </div>
    
                                        <div class="profile-block d-flex">
                                            <p class="namebesideflag">Kate
                                                </p>
                                        </div>
                                       <p class="mb-0 languagetext"> Language: Arabic</p>
                                        <p class="mb-0 smallfont">Date: 15/2/2024 <br> Time: 10:00pm <br> Proficiency: Beginner<br> <i class="bi-clock-fill custom-icon "></i> 60 Minutes<br> status: <a class="custompending-btn accrejtag">
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
                                                <img src="../public/images/Henry_Cao-Web.jpeg" class="custom-block-image2  img-fluid" alt="">

                                            </a>
                                        </div>
    
                                        <div class="mt-2 buttonsbesideeachother">
                                            <a href="#" class="btn custom-btn customaccept-btn" style="margin:1px;" >
                                                Accept 
                                            </a> 

                                            <a href="#" class="btn custom-btn customreject-btn" style="margin:1px;">
                                                Reject
                                            </a>
                                        </div>
                                    </div>
    
                                    <div class="custom-block-info">
                                        <div class="custom-block-top d-flex mb-1">
                                            <small class="me-4">
                                                <i class="bi-hourglass-bottom custom-icon"></i>
                                                60 Minutes Remaining
                                            </small>
    
                                        </div>
    
                                        <div class="profile-block d-flex">
    
                                            <p class="namebesideflag">Wang</p>
                                        </div>
                                        <p class="mb-0 languagetext">Language: Chinese</p>
                                        <p class="mb-0 smallfont">Date: 15/2/2024 <br> Time: 10:00pm <br> Proficiency: Intermediate<br> <i class="bi-clock-fill custom-icon "></i> 60 Minutes<br> status: <a class="custompending-btn accrejtag">
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
                                                <img src="../public/images/rana.jpeg" class="custom-block-image2 img-fluid" alt="">

                                            </a>
                                        </div>
    
                                        <div class="mt-2 buttonsbesideeachother">
                                            <a href="#" class="btn custom-btn customaccept-btn" style="margin:1px;" >
                                                Accept
                                            </a> 

                                            <a href="#" class="btn custom-btn customreject-btn" style="margin:1px;">
                                                Reject
                                            </a>
                                        </div>
                                    </div>
    
                                    <div class="custom-block-info">
                                        <div class="custom-block-top d-flex mb-1">
                                            <small class="me-4">
                                                <i class="bi-hourglass-bottom custom-icon"></i>
                                                5 Hours Remaining
                                            </small>
    
                                        </div>
    
                                        <div class="profile-block d-flex">
    
                                            <p class="namebesideflag">Rana</p>
                                        </div>
                                        <p class="mb-0 languagetext">Language: English</p>
                                        <p class="mb-0 smallfont">Date: 15/2/2024 <br> Time: 10:30am <br> Proficiency: Intermediate<br> <i class="bi-clock-fill custom-icon "></i> 60 Minutes<br> status: <a class="custompending-btn accrejtag">
                                            Pending
                                        </a></p>
    
                                    </div>
                                    
                                </div>
                            </div> -->

                            <div class="row">
                            <?php foreach ($ReqLearners as $ReqLearner): ?>
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                    <div class="custom-block d-flex">
                                        <form action="" method="post">
                                        <div class="">
                                            <div class="custom-block-icon-wrap">
                                                
                                                <a class="custom-block-image-wrap">
                                                <?php if (isset($ReqLearner['profilePic']) && $ReqLearner['profilePic']): ?>
                                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($ReqLearner['profilePic']); ?>" class="custom-block-image img-fluid" alt="Profile Picture">
                                                <?php else: ?>
                                                    <img src="../public/images/profilepic2.jpg" class="custom-block-image img-fluid" alt="Default Profile Picture">
                                                <?php endif; ?>

                                                </a>
                                            </div>
        
                                            <div class="mt-2 buttonsbesideeachother">
                                                <button type ="submit" name="action" value="save" class="btn custom-btn customaccept-btn" style="margin:1px;" >
                                                    Accept 
                                                </button> 

                                                <button type="submit" name="action" value="delete" class="btn custom-btn customreject-btn" style="margin:1px;">
                                                    Reject
                                                </button>
                                            </div>
                                        </div>
        
                                        <div class="custom-block-info">
                                            <div class="custom-block-top d-flex mb-1">
                                                <small class="me-4">
                                                    <i class="bi-hourglass-bottom custom-icon"></i>
                                                    60 Minutes Remaining
                                                </small>
        
                                            </div>
        
                                            <div class="profile-block d-flex">
        
                                                <p class="namebesideflag"><?php echo htmlspecialchars($ReqLearner['Fname']); ?> &nbsp; <?php echo htmlspecialchars($ReqLearner['Lname']); ?></p>
                                                <input type="text" name="learnerMail" value="<?php echo htmlspecialchars($ReqLearner['email']); ?>" hidden>
                                                <input type="text" name="reqID" value="<?php echo htmlspecialchars($ReqLearner['postReqID']); ?>" hidden>
                                            </div>
                                            <p class="mb-0 languagetext">Language: <?php echo htmlspecialchars($ReqLearner['language']); ?></p>
                                            <p class="mb-0 smallfont">Date: <?php echo htmlspecialchars($ReqLearner['date']); ?> <br> Time: <?php echo htmlspecialchars($ReqLearner['requestDuration']); ?> <br> Proficiency: <?php echo htmlspecialchars($ReqLearner['Lproficiency']); ?><br> <i class="bi-clock-fill custom-icon "></i> <?php echo htmlspecialchars($ReqLearner['Stime']); ?>  Minutes<br> status: <a class="custompending-btn accrejtag">
                                                Pending
                                            </a></p>
        
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        
                            <!--end requests-->
                            <div class="col-lg-12 col-12 mx-auto">
                                <div class="section-title-wrap mb-5"><br>
                                    <h4 id="acceptedreq" class="section-title">Accepted Requests</h4>
                       
                                </div>
                                
                                    
                                    
                                </div>

                            <!-- <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                <div class="custom-block d-flex">
                                    <div class="custom-block-top d-flex mb-1">
                                        

                                    </div>
                                    <div class="">
                                        <div class="custom-block-icon-wrap">
                                            <div class="section-overlay"></div>
                                            <a href="detail-page.html" class="custom-block-image-wrap"> </a>
                                                <img src="../public/images/profilepic2.jpg" class="custom-block-image img-fluid" alt="">
    
                                                <a href="#" class="custom-block-icon">
                                                    <i class="bi-play-fill"></i>
                                                </a>
                                           
                                        </div>
    
                                        <div class="mt-2">
                                            <a href="chat2.html" class="btn custom-btn" style="margin-left: 7px;">
                                                Contact
                                            </a>
                                        </div>
                                    </div>
    
                                    <div class="custom-block-info">
                                        <div class="custom-block-top d-flex mb-1">
                                            <small>
                                            <i class="bi-clock-fill custom-icon "></i> 60 Minutes
                                        </small>
                                        </div>
    
                                        <div class="profile-block d-flex">
    
                                            <p class="namebesideflag">Kevin</p>
                                        </div>
                                        <p class="mb-0 languagetext">Language: Chinese</p>
                                        <p class="mb-0 smallfont">Date: 26/2/2024 <br> Time: 11:00am<br> Proficiency: Intermediate<br> status: <a class="customaccept-btn accrejtag">
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
                                            <div class="section-overlay"></div>
                                            <a href="detail-page.html" class="custom-block-image-wrap"></a>
                                                <img src="../public/images/profilepic2.jpg" class="custom-block-image img-fluid" alt="">
    
                                                <a href="#" class="custom-block-icon">
                                                    <i class="bi-play-fill"></i>
                                                </a>
                                            
                                        </div>
    
                                        <div class="mt-2">
                                            <a href="chat2.html" class="btn custom-btn " style="margin-left: 7px">
                                                Contact
                                            </a>
                                        </div>
                                    </div>
    
                                    <div class="custom-block-info">
                                        <div class="custom-block-top d-flex mb-1">
                                            <small>
                                            <i class="bi-clock-fill custom-icon "></i> 60 Minutes
                                        </small>
                                        </div>
                                        <div class="custom-block-top d-flex mb-1">
                                            
    
                                        </div>
    
                                        <div class="profile-block d-flex">
    
                                            <p class="namebesideflag">Jessica</p>
                                        </div>
                                        <p class="mb-0 languagetext">Language: Spanish</p>
                                        <p class="mb-0 smallfont">Date: 22/2/2024 <br> Time: 10:00pm<br> Proficiency: Intermediate<br> status: <a class="customaccept-btn accrejtag">
                                            Accepted
                                        </a></p>
    
                                    </div>
                                </div>
                            </div> -->

                            <div class="row">
                                <?php foreach ($acceptedReqs as $acceptedReq): ?>
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                    <div class="custom-block d-flex">
                                        <div class="">
                                            <div class="custom-block-icon-wrap">
                                                <div class="section-overlay"></div>
                                                <a href="detail-page.html" class="custom-block-image-wrap"></a>
                                                    <?php if (isset($acceptedReq['profilePic']) && $acceptedReq['profilePic']): ?>
                                                        <img src="data:image/jpeg;base64,<?php echo base64_encode($acceptedReq['profilePic']); ?>" class="custom-block-image img-fluid" alt="Profile Picture">
                                                    <?php else: ?>
                                                        <img src="../public/images/profilepic2.jpg" class="custom-block-image img-fluid" alt="Default Profile Picture">
                                                    <?php endif; ?>
        
                                                    <!-- <a href="#" class="custom-block-icon">
                                                        <i class="bi-play-fill"></i>
                                                    </a> -->
                                                
                                            </div>
        
                                            <div class="mt-2">
                                                <a href="mailto:<?php echo htmlspecialchars($acceptedReq['Lemail']); ?>" class="btn custom-btn " style="margin-left: 7px">
                                                    Contact
                                                </a>
                                            </div>
                                        </div>
        
                                        <div class="custom-block-info">
                                            <div class="custom-block-top d-flex mb-1">
                                                <small>
                                                <i class="bi-clock-fill custom-icon "></i> 60 Minutes
                                            </small>
                                            </div>
                                            <div class="custom-block-top d-flex mb-1">
                                                
        
                                            </div>
        
                                            <div class="profile-block d-flex">
        
                                                <p class="namebesideflag"><?php echo htmlspecialchars($acceptedReq['Fname']); ?> &nbsp; <?php echo htmlspecialchars($acceptedReq['Lname']); ?></p>
                                            </div>
                                            <p class="mb-0 languagetext">Language: <?php echo htmlspecialchars($acceptedReq['language']); ?></p>
                                            <p class="mb-0 smallfont">Date: <?php echo htmlspecialchars($acceptedReq['date']); ?> <br> Time: <?php echo htmlspecialchars($acceptedReq['duration']); ?>
                                            <!-- <br> Proficiency: <?php echo htmlspecialchars($acceptedReq['Lproficiency']); ?> -->
                                            <br> 
                                            status: <a class="customaccept-btn accrejtag">
                                                Accepted
                                            </a></p>
        
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>



                            <div class="col-lg-12 col-12 mx-auto">
                                <div class="section-title-wrap mb-5"><br>
                                    <h4 id="Rejectedreq" class="section-title">Rejected Requests</h4>
                       
                                </div>
                            </div>


                                <!-- <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                    <div class="custom-block d-flex">
                                        <div class="">
                                            <div class="custom-block-icon-wrap">

                                                <div class="custom-block-icon-wrap">
                                                
                                                    <div class="custom-block-icon-wrap">
                                                
                                                        <a class="custom-block-image-wrap">
                                                            <img src="../public/images/profilepic2.jpg" class="custom-block-image2  img-fluid" alt="">
            
                                                        </a>
                                                    </div>
                                                     
                                                </div>
                                               
                                                
        
                                                   
                                               
                                            </div>
                                        </div>
        
                                        <div class="custom-block-info">
                                            <div class="custom-block-top d-flex mb-1">
                                                <small>
                                                <i class="bi-clock-fill custom-icon "></i> 60 Minutes
                                            </small>
                                            </div>
                                            <div class="custom-block-top d-flex mb-1">
                                                
        
                                            </div>
        
                                            <div class="profile-block d-flex">
        
                                                <p class="namebesideflag">Sarah</p>
                                            </div>
                                            <p class="mb-0 languagetext">Language: Spanish</p>
                                            <p class="mb-0 smallfont">Date: 22/2/2024 <br> Time: 10:00pm<br> Proficiency: Intermediate<br> status: <a class="customreject-btn accrejtag">
                                                Rejected
                                            </a></p>
        
                                        </div>
                                    </div>
                                </div>
                            


                                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                    <div class="custom-block d-flex">
                                        <div class="">
                                            <div class="custom-block-icon-wrap">
                                                
                                                <div class="custom-block-icon-wrap">
                                            
                                                    <a class="custom-block-image-wrap">
                                                        <img src="../public/images/profilepic2.jpg" class="custom-block-image2  img-fluid" alt="">
        
                                                    </a>
                                                </div>
                                                 
                                            </div>
                                        </div>
        
                                        <div class="custom-block-info">
                                            <div class="custom-block-top d-flex mb-1">
                                                <small>
                                                <i class="bi-clock-fill custom-icon "></i> 60 Minutes
                                            </small>
                                            </div>
                                            <div class="profile-block d-flex">
        
                                                <p class="namebesideflag">Khalid</p>
                                            </div>
                                            <p class="mb-0 languagetext">Language: Chinese</p>
                                            <p class="mb-0 smallfont">Date: 22/2/2024 <br> Time: 10:00pm<br> Proficiency: Beginner<br> status: <a class="customreject-btn accrejtag">
                                                Rejected
                                            </a></p>
        
                                        </div>
                                    </div>
                                </div> -->


                                <div class="row">
                                <?php foreach ($rejectedReqs as $rejectedReq): ?>
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                    <div class="custom-block d-flex">
                                        <div class="">
                                            <div class="custom-block-icon-wrap">
                                                <div class="section-overlay"></div>
                                                <a href="detail-page.html" class="custom-block-image-wrap"></a>
                                                    <?php if (isset($rejectedReq['profilePic']) && $rejectedReq['profilePic']): ?>
                                                        <img src="data:image/jpeg;base64,<?php echo base64_encode($rejectedReq['profilePic']); ?>" class="custom-block-image img-fluid" alt="Profile Picture">
                                                    <?php else: ?>
                                                        <img src="../public/images/profilepic2.jpg" class="custom-block-image img-fluid" alt="Default Profile Picture">
                                                    <?php endif; ?>
        
                                                    <!-- <a href="#" class="custom-block-icon">
                                                        <i class="bi-play-fill"></i>
                                                    </a> -->
                                                
                                            </div>
        
                                            <div class="mt-2">
                                                <a href="mailto:<?php echo htmlspecialchars($rejectedReq['Lemail']); ?>" class="btn custom-btn " style="margin-left: 7px">
                                                    Contact
                                                </a>
                                            </div>
                                        </div>
        
                                        <div class="custom-block-info">
                                            <div class="custom-block-top d-flex mb-1">
                                                <small>
                                                <i class="bi-clock-fill custom-icon "></i> 60 Minutes
                                            </small>
                                            </div>
                                            <div class="custom-block-top d-flex mb-1">
                                                
        
                                            </div>
        
                                            <div class="profile-block d-flex">
        
                                                <p class="namebesideflag"><?php echo htmlspecialchars($rejectedReq['Fname']); ?> &nbsp; <?php echo htmlspecialchars($rejectedReq['Lname']); ?></p>
                                            </div>
                                            <p class="mb-0 languagetext">Language: <?php echo htmlspecialchars($rejectedReq['language']); ?></p>
                                            <p class="mb-0 smallfont">Date: <?php echo htmlspecialchars($rejectedReq['date']); ?> <br> Time: <?php echo htmlspecialchars($rejectedReq['duration']); ?>
                                            <!-- <br> Proficiency: <?php echo htmlspecialchars($rejectedReq['Lproficiency']); ?> -->
                                            <br> 
                                            status: <a class="customreject-btn accrejtag">
                                                Rejected
                                            </a></p>
        
                                        </div>
                                    </div>
                                </div>
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