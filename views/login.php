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

    $message = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password']; // Assume password is sent as plain text

        // Attempt to query the user data
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE emailID = ? AND password = ?"); 
            $stmt->execute([$email, $password]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($user) {
                // Set session variables
                $_SESSION['user_id'] = $user['userID'];
                $_SESSION['user_email'] = $user['emailID']; 
                // $_SESSION['user_tutor'] = $user['isTutor'];
    
                // Redirect based on user type
                if ($user['isLearner'] == TRUE) {
                    header('Location: learnerHomePage.php');
                    exit;
                } else if ($user['isTutor'] == TRUE) {
                    header('Location: tutorHomePage.php');
                    exit;
                }
            } else {
                $message = "<p>Login failed. Invalid email or password.</p>";
            }
        } catch (Exception $e) {
            $message = "Database error: " . $e->getMessage();
        }
    }

?>
<!-- HTML -->
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>Tutorverse - Log In</title>

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
                    <a class="navbar-brand me-lg-5 me-0" href="../public/index.php">
                        <img src="../public/images/logotuterverse.png" class="logo-image img-fluid" alt="Tutorverse logo">
                    </a>
                    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-lg-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="../public/index.php">Home</a>
                            </li> <!--لينك صفحة الهوم-->


                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Contact</a>
                                <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                                    <li><a class="dropdown-item" href="tel:0508197538">Call us</a></li>
                                    <li><a class="dropdown-item" href="mailto:tutorverse@hotmail.com">Email us</a></li>
                                </ul>
                            </li><!--لينك كونتاكت-->
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


            <section class="contact-section section-padding pt-0">
                
                <div class="container">
                    <br><br>
                    <div class="section-title-wrap mb-5">
                            
                        <h4 class="section-title">Log Into An Account</h4>
                        
                    </div>
                    <div class="row">
                        

                        <div class="col-lg-8 col-12 mx-auto">
                            <div class="custom-block custom-block-full">
                                <div class="custom-block-image-wrap">
                                    
                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="custom-form contact-form" >

        
                                        <div class="row">
        
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <br><br>
        
        
                                                <div class="form-floating">
                                                    <input type="email" name="email" id="email" pattern="[^ @]*@[^ @]*" class="form-control" placeholder="Email address" required>
                                                    
                                                    <label for="email">Email Address</label>
                                                </div>

                            
                                            </div>
        
                                            <div class="col-lg-6 col-md-6 col-12"> 
                                                <br><br>
        
                                                <div class="form-floating">
                                                    <input type="password" name="password" id="password" class="form-control" placeholder="password" required>
                                                    
                                                    <label for="password">Password</label>
                                                </div>
        

        
                                            </div>
        
                                            <div class="col-lg-4 col-12 ms-auto">
                                                <button type="submit" class="form-control">Log In</button>
                                                <label id="link1">Don't have an account? <br> Sign Up <a href="signupLearner.php" id="link2">as learner</a> or <a href="signupTutor.php" id="link3">as tutor</a></label>
                                                

                                            </div>

                                           
        
        
                            
        
                                        </div>
        
                                    </form>
                                    <?php if ($message !== '') echo "<p>$message</p>"; ?>
                               
                                </div>
                            </div>

                         




                           


                        </div>

                    </div>
                </div>
            </section>
            

           
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