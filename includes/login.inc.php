<?php

$base_url = $_SERVER['DOCUMENT_ROOT'] ."/wholesale/";

if (isset($_POST["submit"])) {

    // Grabbing the data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Instantiate LoginContr class
    include_once $base_url."classes/dbh.class.php";
    include_once $base_url."classes/login.class.php";
    include_once $base_url."classes/login-contr.class.php";

    $login = new LoginContr($email, $password);

    // Running error handlers and user login
    $login->loginUser();
    
    // Goint back to front page
    header("location: ../index.php");

}