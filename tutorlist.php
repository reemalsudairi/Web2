<?php
// Start session
session_start();

// Include database connection file
require('connect.php');

// Function to encrypt email
function encryptEmail($email) {
    $key = 'YourSecretKey'; // Change this to your secret key
    $iv = 'YourInitializationVector'; // Change this to your initialization vector

    // Encrypt email
    $encrypted_email = base64_encode(openssl_encrypt($email, 'AES-256-CBC', $key, 0, $iv));

    return $encrypted_email;
}
?>

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
        <!-- Navbar content -->
    </nav>

    <header class="site-header d-flex flex-column justify-content-center align-items-center">
        <!-- Header content -->
    </header>

    <div class="latest-podcast-section section-padding" id="section_2"><!-- Section content -->
        <div class="container">
            <div class="row align-items-center">
                <?php
                // Fetch all tutors from the database
                $sql = "SELECT * FROM tutor";
                $result = $conn->query($sql);

                // Display tutor information
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Encrypt the tutor's email before passing it in the URL
                        $encrypted_email = encryptEmail($row['email']);
                        ?>
                        <div class="col-lg-3 col-12 mb-4 mb-lg-0 tutor-container ratingmargin">
                            <!-- Tutor information -->
                            <div class="custom-block custom-block-full">
                                <div class="custom-block-image-wrap">
                                    <img src="<?php echo $row['profile_image']; ?>" class="custom-block-image img-fluid" alt="Tutor Image">
                                </div>
                                <div class="profile-block d-flex">
                                    <p class="namebesideflag"><?php echo $row['Fname'] . ' ' . $row['Lname']; ?></p>
                                    <a href="reviewsAsLearner.html" class="rating ratingmargin"><?php echo $row['rating']; ?></a><br>
                                </div>
                                <div class="mt-2">
                                    <a href="tutorInfo.php?email=<?php echo $encrypted_email; ?>" class="btn custom-btn">View Details</a>
                                </div>
                                <div class="mt-2">
                                    <a href="PostRequest.php" class="btn custom-btn">Post request</a>
                                </div>
                                <div class="mt-2">
                                    <a href="chat1.html" class="btn custom-btn">Contact</a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>No tutors found.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</main>

<!-- Footer -->
<footer class="site-footer">
    <!-- Footer content -->
</footer>

</body>
</html>


