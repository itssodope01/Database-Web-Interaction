# Database-Web-Interaction

This project demonstrates interaction with a database through a web interface using PHP, JavaScript, CSS, and HTML.

## Local Setup

### Prerequisites

- MySQL (download from Oracle website)
- VSCode
- PHP (download from official PHP website)

### Installation

1. Install MySQL and PHP.
2. Add MySQL and PHP to your system's PATH variable for easier command-line access.

### Database Setup

1. Open MySQL in the source folder (where you stored the .sql files):

   ```
   mysql -u [username] -p
   ```

   (The default username is generally 'root')

2. Create and populate the database:

   ```sql
   source Database_create.sql;
   source insertdata.sql;
   ```

3. Create a table for users and passwords:
   ```sql
   USE database_a;
   CREATE TABLE users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       username VARCHAR(60) NOT NULL UNIQUE,
       hashed_password VARCHAR(255) NOT NULL
   );
   ```

### Configuration

1. Update `db_connection.php` with your database name and password (Database name: database_a).

### Running the Application

1. Open a terminal in the main PHP project folder.
2. Start the PHP development server:
   ```
   php -S localhost:8000
   ```
3. Open a web browser and go to:
   - http://localhost:8000/index.php (Login Page)
   - http://localhost:8000/pritam.php (Main Page, requires login)

### Adding Users

1. Modify `hashpass.php` with your desired username and password.
2. Run the script:
   ```
   php hashpass.php
   ```
   Default credentials: Username: Pritam, Password: OpenSesame

## File Structure

Ensure all files are saved in their proper locations within the project folder. Do not save `hashpass.php` in the main project folder.

## Notes

- The login page is `index.php`
- The main page is `pritam.php`
- Always use secure practices when handling passwords and sensitive data.

## Contributing

Feel free to fork this project and submit pull requests for any improvements or bug fixes.

## License

MIT License
