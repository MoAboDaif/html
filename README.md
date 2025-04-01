# Visitor Data Management System

## Prerequisites

- Fresh Ubuntu 24.04 LTS Server
- Minimum 1GB RAM
- Root or sudo privileges
- Open ports: 80 (HTTP), 443 (HTTPS), 22 (SSH)

## Installation Guide

### 1. Server Setup

**Update System:**
```bash
sudo apt update && sudo apt upgrade -y
sudo apt install -y software-properties-common
```

### 2. Install Latest PHP & Apache

**Add PHP Repository:**
```bash
sudo add-apt-repository -y ppa:ondrej/php
sudo apt update
```

**Install Components:**
```bash
sudo apt install -y \
apache2 \
php8.3 \
libapache2-mod-php8.3 \
php8.3-mysql \
php8.3-mbstring \
php8.3-curl \
php8.3-xml \
php8.3-zip
```

**Verify PHP:**
```bash
php -v
# Should show PHP 8.3.x
```

### 3. Install MySQL 8.0

**Install Database Server:**
```bash
sudo apt install -y mysql-server
```

**Secure MySQL:**
```bash
sudo mysql_secure_installation
```
- Follow prompts to set root password and secure installation

### 4. Application Setup

**Clone Repository:**
```bash
sudo rm -rf /var/www/html/*
sudo git clone https://github.com/MoAboDaif/html.git /var/www/html
```

**Configure Permissions:**
```bash
sudo chown -R www-data:www-data /var/www/html
sudo find /var/www/html -type d -exec chmod 755 {} \;
sudo find /var/www/html -type f -exec chmod 644 {} \;
```

### 5. Database Configuration

**MySQL Root Login:**
```bash
sudo mysql -u root -p
```

**Create Application Database:**
```sql
CREATE DATABASE mywebsite 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

CREATE USER 'webuser'@'localhost' 
IDENTIFIED WITH mysql_native_password 
BY 'StrongPassword123!';

GRANT ALL PRIVILEGES ON mywebsite.* 
TO 'webuser'@'localhost';

FLUSH PRIVILEGES;
```

**Create Tables:**
```sql
USE mywebsite;

CREATE TABLE visitors (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_name VARCHAR(255) NOT NULL UNIQUE,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    gender ENUM('Male','Female') NOT NULL,
    dob DATE NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE comments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    visitor_id INT NOT NULL,
    comments VARCHAR(255) NOT NULL,
    FOREIGN KEY (visitor_id) 
    REFERENCES visitors(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### 6. Application Configuration

**Create Config File:**
```bash
sudo mkdir /etc/webapp
sudo nano /etc/webapp/config.php
```

**Config Contents:**
```php
<?php
return [
    'host' => 'localhost',
    'username' => 'webuser',
    'password' => 'StrongPassword123!',
    'dbname' => 'mywebsite',
    'charset' => 'utf8mb4'
];
```

**Secure Config File:**
```bash
sudo chown root:www-data /etc/webapp/config.php
sudo chmod 640 /etc/webapp/config.php
```

### 7. Apache Configuration

**Create Virtual Host:**
```bash
sudo nano /etc/apache2/sites-available/webapp.conf
```

**Virtual Host Content:**
```apache
<VirtualHost *:80>
    ServerAdmin admin@yourdomain.com
    DocumentRoot /var/www/html
    ServerName your-domain.com

    <Directory /var/www/html>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

**Enable Configuration:**
```bash
sudo a2dissite 000-default.conf
sudo a2ensite webapp.conf
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### 8. SSL Setup (Recommended)

**Install Certbot:**
```bash
sudo apt install -y certbot python3-certbot-apache
```

**Obtain Certificate:**
```bash
sudo certbot --apache
```

## Verification

**Check Web Server:**
```bash
systemctl status apache2
curl -I http://localhost
```

**Test Database Connection:**
```bash
mysql -u webuser -p mywebsite -e "SHOW TABLES;"
```

**PHP Info Test:**
```bash
sudo nano /var/www/html/phpinfo.php
```
```php
<?php phpinfo(); ?>
```
Access via browser and then remove the file.

## Maintenance

**Automatic Updates:**
```bash
sudo crontab -e
```
Add:
```cron
0 3 * * * apt update && apt upgrade -y
0 4 * * * cd /var/www/html && git pull
```

**Backup Script:**
```bash
sudo nano /usr/local/bin/backup-webapp.sh
```
```bash
#!/bin/bash
mysqldump -u webuser -p'StrongPassword123!' mywebsite > /backups/db-$(date +\%F).sql
tar -czf /backups/webapp-$(date +\%F).tar.gz /var/www/html
```

## Security Best Practices

1. **Firewall Configuration:**
```bash
sudo ufw allow OpenSSH
sudo ufw allow 'Apache Full'
sudo ufw enable
```

2. **Daily Log Monitoring:**
```bash
sudo nano /etc/logrotate.d/webapp
```
```
/var/log/apache2/*.log {
    daily
    missingok
    rotate 14
    compress
    delaycompress
    notifempty
    create 640 root adm
    sharedscripts
    postrotate
        systemctl reload apache2 > /dev/null
    endscript
}
```

3. **Intrusion Detection:**
```bash
sudo apt install -y fail2ban
```
**Post-Install Checklist**
- [ ] HTTPS working with valid certificate
- [ ] Database connection verified
- [ ] File permissions set correctly
- [ ] Firewall rules active
- [ ] Backup system in place