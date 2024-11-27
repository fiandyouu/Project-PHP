<?php

$host = "localhost";
$user = "root";
$password = "";
$db = "kingfour_jastip";

$kon = mysqli_connect($host, $user, $password, $db);
if (!$kon){
    die("koneksi gagal:".mysqli_connect_error());
}


?>