update -y

install httpd wget php-fpm  mariadb105-server php-json php

sudo ufw allow 'Apache'

php -v

sudo a2enmod php8.1

install python2-minimal python2 dh-python python-is-python3 libapache2-mod-php8.1
--------------------------------------------------------------------------------------------------------

sudo mysql_secure_installation

sudo mysql -h hostname -u username -p databasname

CREATE DATABASE mywebsite;
CREATE USER 'myuser'@'localhost' IDENTIFIED BY 'mypassword';
GRANT ALL PRIVILEGES ON mywebsite.* TO 'myuser'@'localhost';
FLUSH PRIVILEGES;
 

USE mywebsite;


CREATE TABLE visitors (
    id INT PRIMARY KEY AUTO_INCREMENT UNIQUE,
    user_name VARCHAR(255) NOT NULL UNIQUE,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    dob DATE
);

CREATE TABLE comments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    comments VARCHAR(255) NOT NULL
    );

ALTER TABLE comments
    ADD FOREIGN KEY (id) REFERENCES visitors(id);
SHOW TABLES;


SELECT User, Host FROM mysql.user;

ALTER DATABASE your_database CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE visitors (
    ... (column definitions) ...,
    comments VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE visitors
MODIFY comments VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

--------------------------------------------------------------------------------------------------------

Undefined Function mysqli_connect() Error:
This error occurs because the mysqli extension is not loaded or enabled in your PHP configuration.
To resolve this, ensure that the MySQLi extension is installed and enabled:
Install the MySQLi extension (if not already installed):
sudo apt install php-mysql

Enable the extension by editing your php.ini file (usually located at /etc/php/8.1/apache2/php.ini):
Uncomment or add the following line:
extension=mysqli.so

Restart Apache to apply the changes:
sudo systemctl restart apache2

---------------------------------------------------------------------------------------------------------
