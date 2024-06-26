<?php
session_start();
require('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    
    // Check if user is a tutor
    $query = "SELECT * FROM tutor WHERE email='$email' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $_SESSION['email'] = $email;
        $_SESSION['tutor_email'] = $email;
        header("Location: tutorProfile.php"); // Redirect to the tutor's homepage
        exit();
    } else {
        // If not a tutor, check if user is a learner
        $query = "SELECT * FROM learner WHERE email='$email' AND password='$password'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $_SESSION['email'] = $email;
            $_SESSION['learner_email'] = $email;
            header("Location: signuplearner.php"); // Redirect to the learner's homepage
            exit();
        } else {
            // If no records match, set an error message
            $_SESSION['login_error'] = "Invalid email or password";
            header("Location: login.php"); // Redirect back to the login page
            exit();
        }
    }
}

$conn->close();
?>

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
                    <a class="navbar-brand me-lg-5 me-0" href="mainHome.html">
                        <img src="images/logotuterverse.png" class="logo-image img-fluid" alt="Tutorverse logo">
                    </a>
                    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-lg-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="mainHome.html">Home</a>
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
                                <?php
        session_start();
        if (isset($_SESSION['login_error'])) {
            echo '<p style="color:red;">' . $_SESSION['login_error'] . '</p>';
            unset($_SESSION['login_error']); // Clear the error message after it's displayed
        }
        ?>
                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="custom-form contact-form">

        
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
                                                <label id="link1">Don't have an account? Sign Up<a href="signupLearner.html" id="link2">as learner</a> or <a href="signupTutor.html" id="link3">as tutor</a></label>
                                                

                                            </div>

                                           
        
        
                            
        
                                        </div>
        
                                    </form>
                               
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



<script>
    function redirectToHomepage() {
      // Perform any form validation if needed
      
      // Redirect the user to the homepage
      window.location.href = "LearnerHomepage.html";
      
      // Prevent the form from submitting immediately
      return false;
    }
  </script>

        </body>

</html>