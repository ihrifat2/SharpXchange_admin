<?php

//database connection variable
$host = "localhost";
$user = "root";
$pass = "";
$db = "sharpxchanger_db";

//database connection
$dbconnect = mysqli_connect($host, $user, $pass, $db) or die ("Error while connecting to database.");
mysqli_query($dbconnect, 'SET CHARACTER SET utf8'); 
mysqli_query($dbconnect, "SET SESSION collation_connection ='utf8_general_ci'");

?>