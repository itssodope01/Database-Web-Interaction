# Database-Web-Interaction
Interacting with database through web using PHP, JavaScript, CSS, HTML

Installion needed: mySQL(oracle website), VSCODE, PHP(from official PHP website)
Add mySQL,PHP to your system's PATH variable for easier command-line access.

LocalHost. Login Page: Index.php
          Main Page:Pritam.php

Create the database to interact with:
open mySQL in source folder(where you stored the .sql files): mySQL -u [username] -p (default username is generally 'root')
> source Database_create.sql;
> source insertdata.sql;

Creating Connection:
Change [Database name] and [password] in db_connection.php (Database name:database_a)
open terminal in source folder(where you saved the PHP files).
> php -S localhost:8000

Open Web Browser and go to:
>http://localhost:8000/pritam.php


Add to existing Database table for users and Passwords:
>use database_a;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(60) NOT NULL UNIQUE,
    hashed_password VARCHAR(255) NOT NULL );

Add new User with: hashpass.php
