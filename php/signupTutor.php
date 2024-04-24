<?php
require("../php/query.php");
$fname_err = $lname_err = $password_err = $age_err = $gender_err = $city_err = $email_err = $profilepic_err = $price_err =  $bio_err = $phone_err = $notification = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fname_err = $lname_err = $password_err = $age_err = $gender_err = $city_err = $email_err = $profilepic_err = $price_err =  $bio_err = $phone_err = $notification = "";

    $fname = validate($_POST["firstname"]);
    $lname = validate($_POST["lastname"]);
    if (isset($_POST["gender"]))
        $gender = $_POST["gender"];
    else
        $gender = "";
    $age = validate($_POST["age"]);
    $email = validate($_POST["email"]);
    $city = validate($_POST["city"]);
    $phone = validate($_POST["phone"]);
    $password = validate($_POST["password"]);
    //$confirmpassword= validate($_POST["confirmpassword"]);
    $bio = validate($_POST["bio"]);

    $valid = true;
    if ($fname == "" || !ctype_alpha(str_replace(" ", "", $fname))) {
        $fname_err = " please enter a valid name!";
        $valid = false;
    }
    if ($lname == "" || !ctype_alpha(str_replace(" ", "", $lname))) {
        $lname_err = " please enter a valid name!";
        $valid = false;
    }
    if ($email == "" || !filter_var($email,FILTER_VALIDATE_EMAIL)) {
        $email_err = " please enter a valid email!";
        $valid = false;
    }
     
    if ($password == "") {
        $password_err = " please enter a valid password!";
        $valid = false;
    }
   /* if($confirmpassword!==$password){
        $password_err = " please enter the same password!";
        $valid = false;
    }*/
    if (strlen($password) < 8) {
        $password_err = " password needs to be at least 8 characters!";
        $valid = false;
    }
    if ($city == "" || !ctype_alpha(str_replace(" ", "", $city))) {
        $city_err = " please enter a valid city!";
        $valid = false;
    }
    if ($gender == "") {
        $gender_err = " please select a gender!";
        $valid = false;
    }
    if ($age == "") {
        $age_err = " please enter a valid age number!";
        $valid = false;
    }
    if(!preg_match("/[a-zA-Z]/i", $bio)){
        $bio_err = " please enter a valid bio (must contain letters)!";
        $valid = false;
    }
    if (!preg_match("/^05\d{8}$/", $phone)) {
        $phone_err = " please enter a valid phone number (must start with 05)!";
        $valid = false;
    }

    if (get_tutor_email($email) > 0) {
        $email_err = " this email is already registered, please enter a different email!";
        $valid = false;
    }
    
    // dd();
    if ($valid) {
        $userImage = $_FILES['profilepic'];
        $imageName = $userImage['name'];
        if ($imageName == "")
            $imageName = "images/profilePic.png";

        if (tutor_signup_handler($fname, $lname, $password, $age, $gender, $city, $email, $profilepic, $price, $bio, $phone)) {
            $notification = 'Registration successful!';
            $_POST["firstname"] = $_POST["lastname"] = $_POST["password"] = $_POST["age"] = $_POST["gender"] = $_POST["city"] = $_POST["email"] = $_POST["price"] = $_POST["bio"] = $_POST["phone"] = "";

//            $target_dir = "../public/userImages/";
//            $target_file = $target_dir . basename($_FILES["img"]["name"]);
//            move_uploaded_file($_FILES["img"]["tmp_name"], $target_file);

            $fileTmpName = $userImage['tmp_name'];
            $fileNewName = "../public/userImages/".$imageName;//مو فاهمين
            $uploaded = move_uploaded_file($fileTmpName,$fileNewName);


            $_POST["firstname"] = $_POST["lastname"] = $_POST["password"] = $_POST["age"] = $_POST["gender"] = $_POST["city"] = $_POST["email"] = $_POST["price"] = $_POST["bio"] = $_POST["phone"] = "";
            echo '<script>alert("Registration successful!");window.location.href="login.php";</script>';//نعدل لوكيشن اللوق ان

        }
    }
}
?>

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
                                <h4 class="section-title">Create An Account</h4>
                            </div>
                        <div class="row">
                            <div class="col-lg-8 col-12 mx-auto">
                               
                                

                                <div class="custom-block custom-block-full">
                                    <div class="custom-block-image-wrap">
                                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" class="custom-form contact-form" onsubmit="return redirectToHomepage()">

                                            <input type="file" id="upload-input" accept="image/*" hidden>
                                            <label for="upload-input" id="profile-pic-container">
                                              <img id="profile-pic" src="images/profileSignup.png" alt="Profile Picture">
                                              <span id="upload-icon">Click to Upload</span>
                                            </label>
                                            <div class="row">
            
                                                <div class="col-lg-6 col-md-6 col-12">
                                                    
                                                    <div class="form-floating">
                                                        <input type="text" name="firstname" id="first-name" class="form-control" placeholder="First Name" required>
                                                        
                                                        <label for="first-name">First Name <?php echo $fname_err; ?> </label>
                                                    </div>
            
            
                                                    <div class="form-floating">
                                                        <input type="email" name="email" id="email" pattern="[^ @]*@[^ @]*" class="form-control" placeholder="Email address" required>
                                                        
                                                        <label for="email">Email Address</label>
                                                    </div>
                                                    
            
                                                    <div class="form-floating">
                                                        <input type="text" name="city" id="city" class="form-control" placeholder="city" required>
                                                        
                                                        <label for="city">City</label>
                                                    </div>
            
            
            
                                                    <div class="form-floating">
                                                        <input type="tel" name="phone" id="phone" class="form-control" placeholder="phone" required>
                                                        
                                                        <label for="phone">Phone Number</label>
                                                    </div>
                                
                                
                                                </div>
            
                                                <div class="col-lg-6 col-md-6 col-12"> 
                                                    <div class="form-floating">
                                                        <input type="text" name="lastname" id="last-name" class="form-control" placeholder="Last Name" required>
                                                        
                                                        <label for="last-name">Last Name <?php echo $lname_err; ?></label>
                                                    </div>
            
                                                    <div class="form-floating">
                                                        <input type="password" name="password" id="password" minlength="8" class="form-control" placeholder="password" required>
                                                        
                                                        <label for="password">Password</label>
                                                    </div>
            
                                                    <div class="form-floating">
                                                        <input type="number" name="age" min="18" id="age" class="form-control" placeholder="age" required>
                                                        
                                                        <label for="age">Age</label>
                                        
                                                    </div>

                                                    <div class="form-floating">
                                                        <input type="number" name="price" id="price" class="form-control" placeholder="price" min="0" required >
                                                        
                                                        <label for="price">Price</label>
                                                    </div>
            
            
                                                    <div class="form-floating">
                                                    <select id="gender" name="gender" class="form-control">
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                    </select>
                                                    <label for="gender">Gender</label>
                                                </div>
                                                </div>
            
                                                <div class="col-lg-12 col-12">
                                    
                                                    <div class="form-floating">
                                                        <textarea class="form-control" id="bio" name="bio" placeholder="Describe bio here"></textarea>
                                                        
                                                        <label for="bio">Tell us more about yourself, your spoken languages, and your cultural knowledge!</label>
                                                    </div>
                                                </div>
            
            
            
            
            
            
                                                <div class="col-lg-4 col-12 ms-auto">
                                                 <button type="submit" class="form-control" >Sign Up</button>
                                                    <label id="link1">Already have an account? <a href="login.html" id="link2">Log in</a></label>
                                                   

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
      window.location.href = "TutotHomepage.html";
      
      // Prevent the form from submitting immediately
      return false;
    }
</script>
        </body>




</html>