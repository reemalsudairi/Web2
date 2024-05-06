<?php

    // database connection
    $host = 'web2-database.cgazsz7ngx1b.us-east-2.rds.amazonaws.com';  // Your Database endpoint
    $dbname = 'Web2_dev';                     // Your database name
    $username = 'admin';                   // Your database username
    $password = '12345678';                   // Your database password

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Connected successfully";
    } catch (PDOException $e) {
        die("Could not connect to the database $dbname :" . $e->getMessage());
    }

?>