
# Visitor Data Management System

A PHP-based application for managing visitor information using LAMP stack (Linux, Apache, MySQL, PHP).

## Table of Contents
- [Server Setup](#server-setup)
- [Application Installation](#application-installation)
- [Database Configuration](#database-configuration)
- [Apache Configuration](#apache-configuration)
- [Troubleshooting](#troubleshooting)
- [Security Considerations](#security-considerations)


## Server Setup

### 1. Update System Packages
```bash
sudo apt update && sudo apt upgrade -y
```

### 2. Install LAMP Stack
**Apache:**
```bash
sudo apt install apache2 -y
sudo ufw allow in "Apache Full"
sudo systemctl enable --now apache2
```

**MySQL:**
```bash
sudo apt install mysql-server -y
sudo mysql_secure_installation
sudo systemctl enable --now mysql
```

**PHP:**
```bash
sudo apt install php libapache2-mod-php php-mysql -y
```

### 3. Verify PHP Installation
```bash
echo "<?php phpinfo(); ?>" | sudo tee /var/www/html/info.php
```
Access `http://your-server-ip/info.php` then remove:
```bash
sudo rm /var/www/html/info.php
```

---

## Application Installation

### 1. Clone Repository
```bash
sudo apt install git -y
sudo git clone https://github.com/MoAboDaif/html.git /var/www/html
```

### 2. Set Permissions
```bash
sudo chown -R www-data:www-data /var/www/html
sudo chmod -R 755 /var/www/html
```

---

## Database Configuration

### 1. Create Database and User
```sql
CREATE DATABASE visitor_db;
CREATE USER 'visitor_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON visitor_db.* TO 'visitor_user'@'localhost';
FLUSH PRIVILEGES;
```

### 2. Create Visitors Table
```sql
USE visitor_db;

CREATE TABLE visitors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    visit_date DATE NOT NULL,
    check_in_time TIME,
    check_out_time TIME,
    purpose_of_visit TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 3. Configure Database Connection
Edit `/var/www/html/src/config/db.php`:
```php
<?php
$host = 'localhost';
$db   = 'visitor_db';
$user = 'visitor_user';
$pass = 'secure_password';
// ... rest of the configuration
```

---

## Apache Configuration

### 1. Set Document Root
Edit `/etc/apache2/sites-available/000-default.conf`:
```apache
DocumentRoot /var/www/html/public

<Directory /var/www/html/public>
    AllowOverride All
    Require all granted
</Directory>
```

### 2. Enable Mod_Rewrite
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

---

## Troubleshooting

### Common Errors & Solutions

**1. HTTP 500 Error:**
```bash
# Enable error reporting
sudo nano /etc/php/7.4/apache2/php.ini
```
Set:
```ini
display_errors = On
display_startup_errors = On
```

**2. Missing Database Table:**
```bash
sudo mysql -u root -p
USE visitor_db;
SHOW TABLES;  # Verify table exists
```

**3. Field Validation Errors:**
```sql
ALTER TABLE visitors MODIFY visit_date DATE DEFAULT CURRENT_DATE;
```

**4. View Apache Logs:**
```bash
sudo tail -f /var/log/apache2/error.log
```

---

## Security Considerations

1. **Firewall Configuration:**
```bash
sudo ufw allow 'Apache Full'
sudo ufw enable
```

2. **Regular Updates:**
```bash
sudo apt update && sudo apt upgrade -y
```

3. **File Permissions:**
```bash
sudo find /var/www/html -type d -exec chmod 755 {} \;
sudo find /var/www/html -type f -exec chmod 644 {} \;
```

4. **MySQL Security:**
- Use strong passwords
- Remove anonymous users
- Disable remote root login

---

## Access Application
Visit `http://your-server-ip` in your web browser.

**Default Admin Interface:**
`http://your-server-ip/admin` (configure credentials in application settings)

This README covers all installation steps, configuration details, and troubleshooting solutions from your deployment experience. It includes:
1. Full LAMP stack setup
2. Database configuration with proper table structure
3. Apache optimization for public directory
4. Common error solutions encountered during deployment
5. Security best practices
6. Maintenance instructions

Adjust passwords (replace 'secure_password') and PHP version numbers according to your environment.