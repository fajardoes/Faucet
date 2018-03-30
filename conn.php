<?php
// Connection variables 
$host = "localhost"; // MySQL host name eg. localhost
$user = "root"; // MySQL user. eg. root ( if your on localserver)
$password = "MrRobot.2018"; // MySQL user password  (if password is not set for your root user then keep it empty )
$database = "faucet"; // MySQL Database name
 
// Connect to MySQL Database
$cnn = mysqli_connect($host, $user, $password, $database);
 
// Check connection
if ($cnn->connect_error) {
    die("Connection fallida: " . $cnn->connect_error);
} 
?>
