<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutorverse - Tutor Information</title>
    <!-- CSS FILES -->        
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-icons.css">
    <link rel="stylesheet" href="css/templatemo-pod-talk.css">
    <link rel="icon" type="img/png" href="images/logo.png">
</head>
<body>
    <main>
        <!-- Tutor Information Section -->
        <div class="container">
            <div class="custom-block custom-block-full">
                <?php
                    // Decrypt the tutor's email from the URL parameter
                    if(isset($_GET['email'])) {
                        $encrypted_email = $_GET['email'];
                        $tutor_email = openssl_decrypt(base64_decode($encrypted_email), 'AES-256-CBC', 'YourSecretKey', 0, 'YourInitializationVector');
                    } else {
                        // Handle case where email parameter is not provided
                        echo "<p>Tutor email not provided.</p>";
                        exit(); // Terminate further execution
                    }

                    // Start session and include database connection file
                    session_start();
                    require('connect.php');

                    // Fetch tutor details based on decrypted email
                    $sql = "SELECT * FROM tutor WHERE email = '$tutor_email'";
                    $result = $conn->query($sql);

                    // Display tutor information
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                ?>
                    <div class="custom-block d-flex">
                        <div>
                            <div class="custom-block-icon-wrap">
                                <div class="custom-block-image-wrap">
                                    <img src="<?php echo $row['profile_pic']; ?>" class="custom-block-image" alt="Tutor Image">
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="custom-block-info">
                                <div class="profile-block d-flex">
                                    <span style="color: purple;" class="namebesideflag"><?php echo $row['Fname'] . ' ' . $row['Lname']; ?></span>
                                </div>
                                <a href="reviewsAsLearner.html" class="rating ratingmargin"><?php echo $row['rating'] . ' ' .'☆'?></a>
                                <p class="bi-cash-coin purple"><?php echo $row['price']; ?> /hr</p>
                                <p class="mb-0"><?php echo $row['bio']; ?></p>
                                <div class="mt-2">
                                    <a href="PostRequest.html" class="btn custom-btn">Post request</a>
                                </div>
                                <div class="mt-2">
                                    <a href="chat1.html" class="btn custom-btn">Contact</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    } else {
                        echo "<p>Tutor not found.</p>";
                    }

                    // Close database connection
                    $conn->close();
                ?>
            </div>
        </div>
    </main>
    <!-- Footer -->
    <footer class="site-footer">   
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12 mb-4 mb-md-0 mb-lg-0">
                    <h6 class="site-footer-title mb-3">Contact</h6>
                    <p class="mb-2"><strong class="d-inline me-2">Phone:</strong> <a href="tel:0508197538">010-020-0340</a> </p>
                    <p><strong class="d-inline me-2">Email:</strong> <a href="mailto:tutorverse@hotmail.com">tutorverse@hotmail.com</a></p>
                </div>
            </div>
        </div>
    </footer>
    <div class="container pt-5">
        <div class="row align-items-center">
            <div class="col-lg-2 col-md-3 col-12">
                <a class="navbar-brand" href="LearnerHomepage.html">
                    <img src="images/logo.png" class="logo-image img-fluid" alt="Tutorverse logo">
                </a>
            </div>
            <div class="col-lg-3 col-12">
                <p class="copyright-text mb-0">Copyright © 2024 Tutorverse</p>
            </div>
        </div>
    </div>
</body>
</html>

