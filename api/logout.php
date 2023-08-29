<?php

if(!empty($_POST['email']) && !empty($_POST['apiKey'])){
    $email = $_POST['email'];
    $apiKey = $_POST['apiKey'];
    $con = mysqli_connect("localhost", "root", "", "php_api");
    if ($con){
        $sql = "SELECT * FROM users WHERE email = '$email' AND apiKey = '$apiKey'";
        $res = mysqli_query($con, $sql);
        if (mysqli_num_rows($res) != 0) {
            $row = mysqli_fetch_assoc($res);
            $sqlUpdate = "UPDATE users SET apiKey = '' WHERE email = '$email'";
            if (mysqli_query($con, $sqlUpdate)){
                echo "success";
            }else echo "Logout Failed";
         }else echo "Unauthorized access";
    } else echo "database connection failed";
} else echo "All fields are required";
?>