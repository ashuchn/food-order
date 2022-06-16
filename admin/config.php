<?php 

$host = "localhost";
$user = "root";
$pass = "";
$db = "food";


$conn = mysqli_connect($host, $user, $pass, $db);

if(!$conn) {
    echo "db connection error";
}