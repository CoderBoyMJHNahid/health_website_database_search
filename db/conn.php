<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "health_db";

$conn = mysqli_connect($hostname, $username, $password, database: $database) or die("Couldn't connect to database: " . mysqli_connect_error());