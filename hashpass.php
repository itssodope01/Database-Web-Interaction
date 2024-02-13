<?php
// Include the password_m.php file containing the password hashing functions
include('password_m.php');

include('db_connection.php');

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
