<?php
session_start();
require('connect.php');

// Retrieve tutor information
$email = $_SESSION['tutor_email'];
$sql = "SELECT * FROM `tutor` WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $fname = $row['Fname'];
    $lname = $row['Lname'];
    $gender = $row['gender'];
    $age = $row['age'];
    $city = $row['city'];
    $phone = $row['phone'];
    $bio = $row['bio'];
    $password = $row['password'];
    $profilePic = $row['profilepic'];
} else {
    echo "Tutor not found.";
}

// Check if the form for deleting the account is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['action']) && $_POST['action'] == "delete") {
        // Deletion logic here
        $email = $_SESSION['email'];
        $delete_query = "DELETE FROM `tutor` WHERE email = '$email'";
        $delete_result = mysqli_query($conn, $delete_query);
        
        if ($delete_result) {
            // Redirect user to sign out after successful deletion
            header("Location: signupTutot.php");
            exit();
        } else {
            echo "Error deleting account: " . mysqli_error($conn);
            exit;
        }
    } else {
        // Update profile logic here
        $old_email = $_SESSION['email'];
        $new_email = $_POST['email'];
        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];
        $gender = $_POST['gender'];
        $age = $_POST['age'];
        $city = $_POST['city'];
        $phone = $_POST['phone'];
        $bio = $_POST['bio'];
        $password = $_POST['password'];

        $email_check_query = "SELECT * FROM `tutor` WHERE email = '$new_email' AND email != '$old_email'";
        $email_check_result = mysqli_query($conn, $email_check_query);
        if (mysqli_num_rows($email_check_result) > 0) {
            echo '<script>alert("Email already in use. Please choose another email."); window.location.href="tutorProfile.php";</script>';
            exit;
        }

          // Check if a new profile picture is uploaded
    if(isset($_FILES['new-profile-pic']) && $_FILES['new-profile-pic']['error'] == UPLOAD_ERR_OK) {
        // Get the temporary file path
        $file_tmp_name = $_FILES['new-profile-pic']['tmp_name'];
        
        // Read file content
        $newProfilePic = file_get_contents($file_tmp_name);

        // Escape special characters to prevent SQL injection
        $newProfilePic = $conn->real_escape_string($newProfilePic);

        // Update the profile picture in the database
        $updatePicSql = "UPDATE tutor SET profilepic = '$newProfilePic' WHERE email = '$email'";
        if ($conn->query($updatePicSql) === TRUE) {
            // Profile picture updated successfully
            $profilePic = $newProfilePic; // Update the profile picture variable
        } else {
            // Handle error
            echo "Error updating profile picture: " . $conn->error;
        }
    }

        $sql = "UPDATE `tutor` SET email = '$new_email', Fname = '$fname', Lname = '$lname', gender = '$gender', age = '$age', city = '$city', phone = '$phone', bio = '$bio', password = '$password' WHERE email = '$old_email'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $_SESSION['email'] = $new_email;
            echo '<script>alert("Profile updated successfully!"); window.location.href="tutorProfile.php";</script>';
        } else {
            echo "Error updating profile: " . mysqli_error($conn);
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
    <title>Tutorverse - My Profile</title>
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
                    <a class="navbar-brand me-lg-5 me-0" href="TutotHomepage.html">
                        <img src="images/logotuterverse.png" class="logo-image img-fluid" alt="Tutorverse logo">
                    </a>
                    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-lg-auto">

                            <li class="nav-item">
                                <a class="nav-link " href="TutotHomepage.html">Home</a>
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
                                    <img src="images/profilePic.png"  class="logo-image img-fluid" alt="Photo"> 
                                </a>
                                <ul class="dropdown-menu dropdown-menu-light" >
                                    <li><a class="dropdown-item" href="tutorProfile.html">View Profile</a></li>
                                    <li><a class="dropdown-item" href="requestacceptreject.html">View Requests</a></li>
                                    <li><a class="dropdown-item" href="viewreviews.html">View Reviews</a></li>
                                    <li><a class="dropdown-item" href="mainHome.html">Sign out</a></li>
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
            <div class="row">
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
                                <!-- Profile Picture -->
                               
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="custom-block-info">
                            
                            <!-- Tutor Profile Information -->
                            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <label for="upload-input" id="profile-pic-container">
    <?php if(isset($newProfilePic)): ?>
        <img id="profile-pic" src="<?php echo $newProfilePic; ?>" alt="Profile Picture" width="150" height="150">
    <?php elseif(isset($profilePic)): ?>
        <img id="profile-pic" src="<?php echo $profilePic; ?>" alt="Profile Picture" width="150" height="150">
    <?php endif; ?>
    <input type="file" name="new-profile-pic" id="upload-input" accept="image/*" hidden>
    <span id="file-path-display">Click to change profile picture</span>
</label>
<br>


<script>
document.getElementById('upload-input').addEventListener('change', function() {
    if (this.files.length === 0) {
        document.getElementById('file-path-display').innerText = 'No file selected';
        return;
    }

    var file = this.files[0];

    if (file.type.startsWith('image/')) {
        var fileName = file.name;
        document.getElementById('file-path-display').innerText = fileName;

        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profile-pic').src = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        document.getElementById('file-path-display').innerText = 'Please select an image file.';
    }
});
</script>

                                <p>First Name: <input type="text" name="firstname" value="<?php echo $fname; ?>"><i class="bi bi-pencil-square"></i></p>
                                <p>Last Name: <input type="text" name="lastname" value="<?php echo $lname; ?>"><i class="bi bi-pencil-square"></i></p>
                                <p>Age: <input type="text" name="age" value="<?php echo $age; ?>"><i class="bi bi-pencil-square"></i></p>
                                <p>Gender: 
                                    <select name="gender">
                                        <option value="male" <?php if($gender == "male") echo "selected"; ?>>Male</option>
                                        <option value="female" <?php if($gender == "female") echo "selected"; ?>>Female</option>
                                    </select><i class="bi bi-pencil-square"></i>
                                </p>
                                <p>Email: <input type="text" name="email" value="<?php echo $email; ?>"><i class="bi bi-pencil-square"></i></p>
                                <p>Password: <input type="password" name="password" value="<?php echo $password; ?>"><i class="bi bi-pencil-square"></i></p>
                                <p>City: <input type="text" name="city" value="<?php echo $city; ?>"><i class="bi bi-pencil-square"></i></p>
                                <p>Phone Number: <input type="text" name="phone" value="<?php echo $phone; ?>"><i class="bi bi-pencil-square"></i></p>
                                <p>Bio: <textarea name="bio"><?php echo $bio; ?></textarea><i class="bi bi-pencil-square"></i></p>
                                <br>
                                <br>
                                <br>
                                <div class="custom-block-btn-group">
                                    <button type="submit" name="submit" class="btn custom-btn customedit-btn">Save</button>
                                    <button type="button" class="btn custom-btn customreject-btn" onclick="confirmDelete()">Delete</button>

                               </div>
                            </form>
                            <form id="deleteForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="hidden" name="action" value="delete">
</form>

<script>
    function confirmDelete() {
        if (confirm("Are you sure you want to delete your account?")) {
            // Submit the delete form
            document.getElementById("deleteForm").submit();
        }
    }
</script>
                            
                            
                        </div>
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
                              <img src="images/logo.png" class="logo-image img-fluid" alt="Tutorverse logo">
                          </a>
                        </div>
          
                        <div class="col-lg-3 col-12">
                          <p class="copyright-text mb-0">Copyright © 2024 Tutorverse </p>
                        </div>
                    </div>
                </div>
            </footer>
    </main>    
</body>   
</html>
