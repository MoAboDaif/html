# Visitor Data Management System

## Overview
This is a visitor management system built using PHP, MySQL, and an MVC architecture. It allows you to add visitor details and search through stored visitors.

## Requirements
- PHP 7.4 or later
- MySQL
- Apache/Nginx or similar web server

## Installation

1. **Clone the Repository:**
    ```bash
    git clone https://github.com/MoAboDaif/html.git
    ```

2. **Setup the Database:**
    - Create a MySQL database (e.g. `visitor_db`).
    - Create the `visitors` table:
    ```sql
    CREATE TABLE visitors (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    ```

3. **Update the Configuration:**
    - Edit `config/db.php` with your database credentials.

4. **Configure Your Web Server:**
    - Set the document root to the `public/` directory.

5. **Access the Application:**
    - Open your browser and navigate to your server's URL.

## Security Considerations
- Uses prepared statements with PDO to prevent SQL injection.
- Validates and sanitizes all user inputs.
- Consider adding CSRF protection for forms in production.

## License
[MIT](LICENSE)
