<?php
    $servername = "88.118.205.141";
    $username = "test";
    $password = "test";

    // Create connection
    $conn = new mysqli($servername, $username, $password, "sys");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

?>