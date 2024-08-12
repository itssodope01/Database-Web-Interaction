<?php
$servername = "localhost";
$username = "root";
$password = "08090";
$dbname = "final_project";

//Creating connection
$conn = new mysqli($servername, $username, $password, $dbname);

//Checking connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

