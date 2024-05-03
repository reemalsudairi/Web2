<?php
session_start();
require('connect.php');
// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $email = $_POST['email'];
    $city = $_POST['city'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $bio = $_POST['bio'];
    $price = $_POST['price'];
    

    // Check if a file is uploaded
    if(isset($_FILES['profilepic']) && $_FILES['profilepic']['error'] == UPLOAD_ERR_OK) {
        // Get the temporary file path
        $file_tmp_name = $_FILES['profilepic']['tmp_name'];
        
        // Read file content
        $profilePic = file_get_contents($file_tmp_name);

        // Escape special characters to prevent SQL injection
        $profilePic = $conn->real_escape_string($profilePic);
    } else {
        // If no file is uploaded, load the default profile picture
        $defaultProfilePic = file_get_contents('images/profilepic2.jpg');

        // Escape special characters to prevent SQL injection
        $profilePic = $conn->real_escape_string($defaultProfilePic);
    }
    
    // SQL to insert data into tutor table
    $sql = "INSERT INTO tutor (Fname, Lname, email, city, phone, password, age, gender, bio, price, profilepic) VALUES ('$fname', '$lname', '$email', '$city', '$phone', '$password', '$age', '$gender', '$bio', '$price', '$profilePic')";

    if ($conn->query($sql) === TRUE) {
        // Data inserted successfully
        $_SESSION['tutor_email'] = $email;
        // Redirect or perform any other actions
        header('Location: tutorProfile.php');
        exit();
    } else {
        // Check if the error is due to a duplicate entry
        if ($conn->errno == 1062) {
            // Handle duplicate entry error
            echo "Error: This email is already registered.";
        } else {
            // Other errors
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Contact</a>
                        <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                            <li><a class="dropdown-item" href="tel:0508197538">Call us</a></li>
                            <li><a class="dropdown-item" href="mailto:tutorverse@hotmail.com">Email us</a></li>
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
                    <!-- Header content here -->
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
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="custom-form contact-form" >
                            <input type="file" name="profilepic" id="upload-input" accept="image/*" hidden>
                            <label for="upload-input" id="profile-pic-container">
                            <?php if(isset($profilePic)): ?>
                <!-- If a profile picture is uploaded, show the uploaded image -->
                <img id="profile-pic" src="data:image/jpeg;base64,<?php echo base64_encode($profilePic); ?>" alt="Profile Picture">
            <?php else: ?>
                <!-- If no profile picture is uploaded, show the default image -->
                                <img id="profile-pic" src="images/profileSignup.png" alt="Profile Picture">
                                <span id="upload-icon">Click to Upload</span>
                                <?php endif; ?>
                            </label>
                            <div class="col-lg-6 col-md-6 col-12">
           <!-- File path display -->
    <p id="file-path-display">No profile picture selected</p>
</div>

<script>
    document.getElementById('upload-input').addEventListener('change', function() {
        // Get the selected file name
        var fileName = this.files[0].name;
        // Update the file path display
        document.getElementById('file-path-display').innerText = fileName;
    });
</script>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-floating">
                                        <input type="text" name="firstname" id="first-name" class="form-control" placeholder="First Name" required>
                                        <label for="first-name">First Name</label>
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
                                        <label for="last-name">Last Name</label>
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

<footer class="site-footer">   
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-12 mb-4 mb-md-0 mb-lg-0">
                <h6 class="site-footer-title mb-3">Contact</h6>
                <p class="mb-2"><strong class="d-inline me-2">Phone:</strong> <a href="tel:0508197538">010-020-0340</a></p>
                <p><strong class="d-inline me-2">Email:</strong><a href="mailto:tutorverse@hotmail.com">tutorverse@hotmail.com</a></p>
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
                <p class="copyright-text mb-0">Copyright ©️ 2024 Tutorverse </p>
            </div>
        </div>
    </div>
</footer>

<!-- JavaScript code if needed -->

</body>
</html>


