<?php
    include '../src/dbConnect.php';
    session_start();

    // Handle signup submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $city = $_POST['city'];
        $location = $_POST['location'];

        try {

            if (isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] == 0) {
                $profilePic = $_FILES['profilePic']['tmp_name'];
                $imageData = file_get_contents($profilePic);
                $base64Image = base64_encode($imageData); // Convert the image to Base64
            } else {
                // Default image if none is uploaded
                $defaultImagePath = '../public/images/profilepic2.jpg';
                $imageData = file_get_contents($defaultImagePath);
                $base64Image = base64_encode($imageData); // Convert the image to Base64
            }
            
            // $imageBlob = $pdo->quote($imageData); // Safe way to prepare BLOB data

            // Prepare and bind
            $stmt = $pdo->prepare("INSERT INTO users (emailID, isTutor, isLearner, password) VALUES (?, ?, ?, ?)");
            $stmt->execute([$email, 0, 1, $password]);

            $stmt2 = $pdo->prepare("INSERT INTO learner (Fname, Lname, email, profilepic, city, location) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt2->execute([$firstname, $lastname, $email, $base64Image, $city, $location]);

            $_SESSION['user_email'] = $email;

            // Redirect to another page after successful signup
            header("Location: learnerHomePage.php"); // Adjust this to your target page
            exit;
        }catch(Exception $e) {
            echo "Database error:  " . $e->getMessage();
        }
    }

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

        <title>Tutorverse - Sign Up</title>

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
                            
                        <h4 class="section-title">Create An Account</h4>
                        
                    </div>
                    <div class="row">
                        

                        <div class="col-lg-8 col-12 mx-auto">
                            <div class="custom-block custom-block-full">
                                <div class="custom-block-image-wrap">
                                    
                                <form action="#" method="post" enctype="multipart/form-data" class="custom-form contact-form" id="myForm">
                                    <input type="file" id="upload-input" name="profilePic" accept="image/*" hidden>
                                    <label for="upload-input" id="profile-pic-container">
                                        <img id="profile-pic" src="../public/images/profileSignup.png" alt="Profile Picture" onclick="document.getElementById('upload-input').click();">
                                        <span id="upload-icon">Click to Upload</span>
                                    </label>
                                      
                                        
        
                                        <div class="row">
        
                                            <div class="col-lg-6 col-md-6 col-12">
                                                
                                                <div class="form-floating">
                                                    <input type="text" name="firstname" id="first-name" class="form-control" placeholder="First Name" required>
                                                    
                                                    <label for="first-name">First Name</label>
                                                </div>
        
        
                                                <div class="form-floating">
                                                    <!-- added more strict pattern vaildator so that it takes the correct value -->
                                                    <input type="email" name="email" id="email" pattern="[a-z0-9._%+\\-]+@[a-z0-9.-]+\.[a-z]{2,}$" class="form-control" placeholder="Email address" required>
                                                    
                                                    <label for="email">Email Address</label>
                                                </div>
                                                
        
                                                <div class="form-floating">
                                                    <input type="text" name="city" id="city" class="form-control" placeholder="city" required>
                                                    
                                                    <label for="city">City</label>
                                                </div>
                            
                                            </div>
        
                                            <div class="col-lg-6 col-md-6 col-12"> 
                                                <div class="form-floating">
                                                    <input type="text" name="lastname" id="last-name" class="form-control" placeholder="Last Name" required>
                                                    
                                                    <label for="last-name">Last Name</label>
                                                </div>
        
                                                <div class="form-floating">
                                                    <input type="password" name="password" id="password" minlength="8"  class="form-control" placeholder="password" required>
                                                    
                                                    <label for="password">Password</label>
                                                </div>
        
                                                <div class="form-floating">
                                                    <input type="text" name="location" id="location" class="form-control" placeholder="location" required>
                                                    
                                                    <label for="location">Location</label>
                                                </div>
        
                                            </div>
        
        
                                            <div class="col-lg-4 col-12 ms-auto">
                                                <button type="submit" class="form-control">Sign Up</button>
                                                <label id="link1">Already have an account? <a href="login.php" id="link2">Log in</a></label>
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

    <script>
        document.getElementById('upload-input').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgElement = document.getElementById('profile-pic');
                    imgElement.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>



</html>