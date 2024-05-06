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
    $user_email = $_SESSION['user_email'];
    // attempting to query the user's profile data
    try {
        $stmt = $pdo->prepare("SELECT Fname, Lname, age, gender, city, email, price, bio, phone FROM tutor WHERE email = :user_email");
        $stmt->execute(['user_email' => $user_email]);

        $stmt2 = $pdo->prepare("SELECT password FROM users WHERE emailID = :user_email");
        $stmt2->execute(['user_email' => $user_email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $user_password = $stmt2->fetch(PDO::FETCH_ASSOC);

    } catch(Exception $e) {
        echo "Database error: " . $e->getMessage();
        $user = [];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == 'save') {

        // Fname,Lname,age,gender,city,email,price,bio,phone
        // Handle form submission
        $first_name = $_POST['Fname'];
        $last_name = $_POST['Lname'];
        $password = $_POST['password'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $city = $_POST['city'];
        $price = $_POST['price'];
        $bio = $_POST['bio'];
        $phone = $_POST['phone'];
        

        // echo $_POST['Fname'];
        // echo $_POST['last_name'];
    
        try {
            $stmt = $pdo->prepare("UPDATE tutor SET Fname = :first_name, Lname = :last_name, age= :age, gender= :gender, price= :price, bio= :bio, phone= :phone, city = :city WHERE email = :email_id");
            $stmt->execute([
                ':first_name' => $first_name,
                ':last_name' => $last_name,
                ':email_id' => $user_email,
                ':age' => $age,
                ':gender' => $gender,
                ':price' => $price,
                ':bio' => $bio,
                ':phone' => $phone,
                ':city' => $city
            ]);

            $stmt2 = $pdo->prepare("UPDATE users SET password = :password WHERE emailID = :email_id");
            $stmt2->execute([
                ':password' => $password,
                ':email_id' => $user_email
            ]);

            $success = "Profile updated successfully!";

            // Redirect to the same page to refresh and show the success message
            header('Location: '.$_SERVER['PHP_SELF']);
            exit();

        } catch(Exception $e) {
            $error = "Error updating profile: " . $e->getMessage();
        }
    }
    else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == 'delete') {
        // echo "Delete triggered";
        try {
            // DELETE FROM users WHERE email = :email
            $stmt = $pdo->prepare("DELETE FROM tutor WHERE email = :email_id");
            $stmt->execute([
                ':email_id' => $user_email
            ]);

            $stmt2 = $pdo->prepare("DELETE FROM users WHERE emailID = :email_id");
            $stmt2->execute([
                ':email_id' => $user_email
            ]);

            $success = "Profile deleted successfully!";

            // Redirect to the same page to refresh and show the success message
            header('Location: ../public/index.php');
            exit();

        } catch(Exception $e) {
            $error = "Error deleting profile: " . $e->getMessage();
        }
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

        <title>Tutorverse - My Profile</title>

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
                                    <li><a class="dropdown-item" href="viewreviews.html">View Reviews</a></li>
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
            <div class="container">
                <div class="row ">

                    <div class="col-lg-12 col-12 mx-auto">
                        <div class="section-title-wrap mb-5">
                            <h4 class="section-title">My Profile</h4>
                        </div>
                    </div>
                </div>
            </div>      
            <div class="container">
                <div class="custom-block custom-block-full">
                    <div class="custom-block d-flex">
                        <div>
                            <div class="custom-block-icon-wrap">
                                <div class="custom-block-image-wrap">
                                    <img src="../public/images/elsa.webp" class="custom-block-image" alt="">
                                </div>
                            </div>
                        </div>
                        <div>
                            <form action="" method="POST">
                                <div class="custom-block-info">
                                    <p>Fist Name: <input type="text" name='Fname' value="<?php echo htmlspecialchars($user['Fname'] ?? ''); ?>"> <span contenteditable="true"><i class="bi bi-pencil-square"></i></span></p>
                                    <p>Last Name: <input type="text" name='Lname' value="<?php echo htmlspecialchars($user['Lname'] ?? ''); ?>"> <span contenteditable="true"> <i class="bi bi-pencil-square"></i></span></p>
                                    <p>Age:<input type="text" name='age' value="<?php echo htmlspecialchars($user['age'] ?? ''); ?>"> <span contenteditable="true"> <i class="bi bi-pencil-square"></i></span>
                                    </p>
                                    <p>Gender: <input type="text" name='gender' value="<?php echo htmlspecialchars($user['gender'] ?? ''); ?>"> <span contenteditable="true"><i class="bi bi-pencil-square"></i></span></p>
                                    <p>Email: <span contenteditable="false"><?php echo htmlspecialchars($user['email'] ?? ''); ?>
                                            <!-- <span><i class="bi bi-pencil-square"></i></span> -->
                                    </p>
                                    <p>Password:<input type="password" name='password' value="<?php echo htmlspecialchars($user_password['password'] ?? ''); ?>"> <span contenteditable="true"> <i class="bi bi-pencil-square"></i></span>
                                    </p>
                                    <p>City:  <input type="text" name='city' value="<?php echo htmlspecialchars($user['city'] ?? ''); ?>"><span contenteditable="true"> <i class="bi bi-pencil-square"></i></span></p>
                                    <p>Phone Number:<input type="text" name='phone' value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>"> <span contenteditable="true"><i class="bi bi-pencil-square"></i></span></p>
                                    <p>Session price per hour: <input type="text" name='price' value="<?php echo htmlspecialchars($user['price'] ?? ''); ?>"> <span contenteditable="true"> <i class="bi bi-pencil-square"></i></span></p>
                                    <div>
                                        <p>Bio: <input type="text" name='bio' value="<?php echo htmlspecialchars($user['bio'] ?? ''); ?>"><span contenteditable="true"><i class="bi bi-pencil-square"></i></span></p>
                                    </div>
                                    <br>
                                    <br>
                                    <br>
                                    <div class="custom-block-btn-group">
                                        <!-- <a href="mainHome.html" class="btn custom-btn customreject-btn">Delete</a>
                                        <a href="TutotHomepage.html" class="btn custom-btn customedit-btn">Save</a> -->
                                        <button type="submit" name="action" value="save" class="btn custom-btn customedit-btn">Save</button>
                                        <button type="submit" name="action" value="delete" class="btn custom-btn customreject-btn">Delete</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
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
            <!--end of footer-->

        </main>    
    </body>
          
</html>
