<?php

if(!empty($_POST['email']) && !empty($_POST['apiKey'])){
    $email = $_POST['email'];
    $apiKey = $_POST['apiKey'];
    $result = array();
    $con = mysqli_connect("localhost", "root", "", "php_api");
    if ($con){
        $sql = "SELECT * FROM users WHERE email = '$email' AND apiKey = '$apiKey'";
        $res = mysqli_query($con, $sql);
        if (mysqli_num_rows($res) !== 0) {
            $row = mysqli_fetch_assoc($res);
            $result = array("status" => "success", "message" => "Data fetched successfully", "name" => $row['name'] , "email" => $row['email'], "apiKey" => $row['apiKey']);
        }else $result = (array("status" => "failed", "message" => "Unauthorized access"));
    } else $result = (array("status" => "failed", "message" => "database connection failed"));
} else $result = (array("status" => "failed", "message" => "all fields are required"));

echo json_encode($result);
?>