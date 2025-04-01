# Visitor Data Management System

A secure web application for managing visitor information with PHP and MySQL, featuring form submission validation and search functionality.

## Features

- 📝 Visitor data collection form with client/server validation
- 🔍 Full-text search across visitor records and comments
- 🔒 Secure database configuration with prepared statements
- ♻️ Transaction management for data integrity
- 📅 Date validation (minimum age enforcement)
- 📊 Relationship database design (visitors ↔ comments)

## Prerequisites

- Ubuntu Server 24.04 LTS
- Apache 2.4+
- PHP 8.1+ with extensions:
  ```bash
  sudo apt install php8.1 php8.1-mysql php8.1-json php8.1-mbstring
  ```
- MySQL 8.0+
- Git

## Installation

1. Clone repository:
   ```bash
   sudo git clone https://github.com/MoAboDaif/html.git /var/www
   ```

2. Create MySQL database and user:
   ```sql
   CREATE DATABASE mywebsite;
   CREATE USER 'myuser'@'localhost' IDENTIFIED WITH mysql_native_password BY 'mypassword';
   GRANT ALL PRIVILEGES ON mywebsite.* TO 'myuser'@'localhost';
   FLUSH PRIVILEGES;
   ```

3. Create tables:
   ```sql
   USE mywebsite;
   
   CREATE TABLE visitors (
       id INT PRIMARY KEY AUTO_INCREMENT UNIQUE,
       user_name VARCHAR(255) NOT NULL UNIQUE,
       first_name VARCHAR(255) NOT NULL,
       last_name VARCHAR(255) NOT NULL,
       gender ENUM('Male', 'Female') NOT NULL,
       dob DATE NOT NULL
   );

   CREATE TABLE comments (
       id INT PRIMARY KEY AUTO_INCREMENT,
       visitor_id INT NOT NULL,
       comments VARCHAR(255) NOT NULL,
       FOREIGN KEY (visitor_id) REFERENCES visitors(id) ON DELETE CASCADE
   );
   ```

4. Configure database connection:
   ```bash
   sudo mkdir /etc/website_config
   sudo mv /var/www/html/config.php /etc/website_config/config.php
   ```
   
5. Set permissions:
   ```bash
   sudo chown -R www-data:www-data /var/www/html
   sudo chmod 750 /etc/website_config
   sudo chmod 640 /etc/website_config/config.php
   ```

## Security Best Practices

- 🔑 Always use `mysql_native_password` authentication plugin
- 🛡️ Keep database credentials outside web root
- 🔄 Regular security updates:
  ```bash
  sudo apt update && sudo apt upgrade -y
  ```
- 📁 File permissions:
  ```bash
  sudo find /var/www/html -type d -exec chmod 755 {} \;
  sudo find /var/www/html -type f -exec chmod 644 {} \;
  ```

## Usage

1. Access application:
   ```
   http://your-server-ip/
   ```

2. Form validation includes:
   - Required fields
   - Username format (4-20 alphanumeric)
   - Date of birth validation (minimum age 13)
   - Gender selection enforcement

3. Search functionality:
   - Full-text search across names and comments
   - Partial matches supported
   - Results displayed in tabular format

## Troubleshooting

Common issues and solutions:

### Database Connection Errors
```bash
# Test MySQL connection:
mysql -u myuser -p mywebsite -e "SELECT 1"

# Check error logs:
sudo tail -f /var/log/apache2/error.log
```

### Character Set Issues
```sql
-- Verify charset configuration:
SHOW VARIABLES LIKE 'character_set%';
SHOW VARIABLES LIKE 'collation%';
```

### Form Submission Errors
```php
// Temporary debug mode:
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

### Permission Issues
```bash
sudo chown -R www-data:www-data /var/www/html
sudo chmod -R 755 /var/www/html
```

## Maintenance

1. Database backup (crontab):
   ```bash
   0 2 * * * mysqldump -u myuser -p'mypassword' mywebsite > /backups/db_$(date +\%F).sql
   ```

2. Auto-update script:
   ```bash
   #!/bin/bash
   cd /var/www/html
   sudo git pull origin main
   sudo systemctl restart apache2
   ```

---

**Tested Environment**  
Ubuntu 24.04 LTS | PHP 8.1.2 | MySQL 8.0.41 | Apache 2.4.58
```

This README includes:
1. Detailed installation instructions from our setup process
2. Security measures implemented during configuration
3. Troubleshooting steps from our debugging sessions
4. Maintenance procedures based on server setup
5. Environment specifics from our testing