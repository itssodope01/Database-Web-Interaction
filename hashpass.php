<?php

$servername = "localhost";
$username = "root";
$password = "08090";
$dbname = "database_a";

//Creating connection
$conn = new mysqli($servername, $username, $password, $dbname);

//Checking connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Username and password to be inserted
$username = "Prakash";
$password = "Prakash2004*";

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// SQL statement to insert into the users table
$sql = "INSERT INTO users (username, hashed_password) VALUES ('$username', '$hashed_password')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
