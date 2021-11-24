<?php

$base_url = $_SERVER['DOCUMENT_ROOT'] ."/wholesale/";

if (isset($_POST["submit"])) {

    // Grabbing the data
    $name = $_POST["name"];
    $type = $_POST["type"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $created_at = date("Y-m-d H:i:s");
    $updated_at = $created_at;

    // Instantiate SignupContr class
    include_once $base_url."classes/dbh.class.php";
    include_once $base_url."classes/signup.class.php";
    include_once $base_url."classes/signup-contr.class.php";

    $signup = new SignupContr($name, $type, $email, $password, $created_at, $updated_at);

    // Running error handlers and user signup
    $signup->signupUser();
    
    // Goint back to front page
    header("location: ../login.php?response=signupsuccess");
}