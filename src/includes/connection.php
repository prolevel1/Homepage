<?php
$servername = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "course";
//$dbname = "course";

$conn = mysqli_connect($servername, $dbuser, $dbpassword, $dbname);
if(!$conn){
    die("Connection Failed:".mysqli_connect_error());
}
?>
