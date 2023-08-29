<?php

if(!empty($_POST['email']) && !empty($_POST['password'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $result = array();
    $con = mysqli_connect("localhost", "username", "password", "database_name");
    if ($con){
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $res = mysqli_query($con, $sql);
        if (mysqli_num_rows($res) !== 0){
            $row = mysqli_fetch_assoc($res);
            if ($email == $row['email'] && password_verify($password, $row['password'])){
                try {
                    $apiKey = bin2hex(random_bytes(23));
                } catch (Exception $e){
                    $apiKey = bin2hex(uniqid($email, true));
                }
                $sqlUpdate = "UPDATE users SET apiKey = '$apiKey' WHERE email = '$email'";
                if (mysqli_query($con, $sqlUpdate)){
                    $result = array("status" => "success", "message" => "Login Success", "name" => $row['name'] , "email" => $row['email'], "apiKey" => $apiKey);
                }else $result = (array("status" => "error", "message" => "Login failed try again"));
            }else $result = (array("status" => "error", "message" => "Retry with correct login and password"));
        }else $result = (array("status" => "error", "message" => "Retry with correct login and password"));
    }else $result = (array("status" => "error", "message" => "database connection failed"));
} else $result = (array("status" => "error", "message" => "all fields are required"));

echo json_encode($result);
?>
