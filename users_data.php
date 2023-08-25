<?php
require "DataBase.php";
$db = new DataBase();
$users = "SELECT id, fullname, email, username FROM users";
if ($db->dbConnect()) {
    if ($db->Data("users")) {
        echo "Login Success";
    } else echo "Username or Password wrong";
} else echo "Error: Database connection";


?>



    <!-- while ($row = mysql_fetch_array(MYSQL_NUM)) {
        echo
            "id : {$row[0]}  <br> " .
            "FULLNAME : {$row[1]} <br> " .
            "EMAIL : {$row[2]} <br> " .
            "USERNAME : {$row[3]} <br> " .
            "PASSWORD : {$row[4]} <br> ";
    }
 -->
