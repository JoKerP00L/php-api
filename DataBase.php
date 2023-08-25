<?php
require "DataBaseConfig.php";

class DataBase
{
    public $connect;
    public $data;
    private $sql;
    private $sqlupdate;
    protected $servername;
    protected $username;
    protected $password;
    protected $databasename;

    public function __construct()
    {
        $this->connect = null;
        $this->data = null;
        $this->sql = null;
        $dbc = new DataBaseConfig();
        $this->servername = $dbc->servername;
        $this->username = $dbc->username;
        $this->password = $dbc->password;
        $this->databasename = $dbc->databasename;
    }

    function dbConnect()
    {
        $this->connect = mysqli_connect($this->servername, $this->username, $this->password, $this->databasename);
        return $this->connect;
    }

    function prepareData($data)
    {
        return mysqli_real_escape_string($this->connect, stripslashes(htmlspecialchars($data)));
    }

    function logIn($table, $email, $password)
    {
        $email = $this->prepareData($email);
        $password = $this->prepareData($password);
        $this->sql = "select * from " . $table . " where email = '" . $email . "'";
        $res = mysqli_query($this->connect, $this->sql);
        if (mysqli_num_rows($res) != 0) {
            $row = mysqli_fetch_assoc($res);
            $dbemail = $row['email'];
            $dbpassword = $row['password'];
            if ($dbemail == $email && password_verify($password, $dbpassword)) {
                try {
                    $apiKey = bin2hex(random_bytes(23));
                } catch (Exception $e) {
                    $apiKey = bin2hex(uniqid($email, true));
                }
                $this->sqlupdate = "update user set apiKey = '".$apiKey."' where email = '".$email."'";
                if (mysqli_query($this->connect, $this->sqlupdate)) {
                    $login = array("status" =>"success", "message" =>"login success",
                    "name" => $row['name'], "email" => $row['email'], "apiKey" => $row['apiKey']);
                    // $login = true;
                }
                else 
                    $result = array("status" => "error", "message" => "login failed try again");
            } else $login = false;
        } else $login = false;

        return $login;
    }

    function signUp($table, $name, $email, $password)
    {
        $name = $this->prepareData($name);
        $password = $this->prepareData($password);
        $email = $this->prepareData($email);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $this->sql =
            "INSERT INTO " . $table . " (name, password, email) VALUES ('" . $name . "','" . $password . "','" . $email . "')";
        if (mysqli_query($this->connect, $this->sql)) {
            return true;
            echo $this->sql;
        } else
             return false;
    }

    function otp($table, $fullname, $email, $username, $password)
    {
        $fullname = $this->prepareData($fullname);
        $username = $this->prepareData($username);
        $password = $this->prepareData($password);
        $email = $this->prepareData($email);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $this->sql =
            "INSERT INTO " . $table . " (fullname, username, password, email) VALUES ('" . $fullname . "','" . $username . "','" . $password . "','" . $email . "')";
        if (mysqli_query($this->connect, $this->sql)) {
            return true;
        } else
             return false;
    }

    


}
?>
