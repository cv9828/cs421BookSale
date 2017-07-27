<!-- 
        File: connect.php
        Contains connection credentials for database
-->
<?php
$host = "localhost";  // ip or domain name default
$username = "book";  // mysql username default
$password = "selling";  // password default for mysql
$database = "book_selling";  // student database


$mysqli = new mysqli($host, $username, $password, $database);
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

session_start();

$token = null;

if (!isset($_SESSION['token'])) {
    // Generate a random token 
    // php.net/manual/en/function.rand.php
    // php.net/manual/en/function.sha1.php
    // php.net/manual/en/function.uniqid.php

    $token = sha1(uniqid(RAND(), TRUE));
    $_SESSION['token'] = $token;
} else {
    $token = $_SESSION['token'];
}

function Redirect($url, $permanent = false) {
    header('Location: ' . $url, true, $permanent ? 301 : 302);

    exit();
}

function isLoginGoToHome() {
    if (isset($_SESSION["CurrentUser"]) && !empty($_SESSION["CurrentUser"]))
        Redirect("listbook.php");
}
function isLogOutGoToHome() {
    if (!isset($_SESSION["CurrentUser"]) || empty($_SESSION["CurrentUser"]))
        Redirect("login.php");
}


