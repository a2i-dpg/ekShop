# EKSHOP MARKETPLACE

> ### ekShop is a fully open-source eCommerce platform that is customizable and configurable to your needs.

This repo is functionality complete — PRs and issues welcome!
----------

- [About](#about-dpg-marketplace)
- [Features](#features)
- [Requirements](#requirements)
- [Easy Installation](#easy-installation)
- [Server Setup](#server-setup)
    - [Linux Server Setup For Production Deployment](#linux-server-setup-for-production-deployment)
    - [Windows Server Setup For Local Deployment](#windows-server-setup-for-local-deployment)
- [Install Project using Git](#install-project-using-git)

# About
ekShop is a fully open-source eCommerce platform that is customizable and configurable to your needs. It is completely free, adaptable and open to be supported by a worldwide community of volunteers and contributors. It’s free and open source nature allows users to maintain complete control of the data content and modify it as they wish and according to their needs. Our intended goal is to allow any potential entrepreneur to quickly get up and running with an online platform to sell goods online. 
Some key features of Marketplace include:


-   Showcase digital and physical goods in categories, sorting by brands
-   Multi-vendor support with management tools and configuration
-   Modular product blocks allow you to customize pages in minutes.
-   Built in campaign tools to allow for promotions and sales
-   SEO configuration input simplified to boost page rank in search results
-   Admin dashboard to import and export items in bulk
-   Inventory management
-   Multi-user access
-   Ticket based support system
-   Social media integration
-   Multiple payment integration supported
-   Privacy preserving with limited or no 3rd party data tracking

Our platform is open to modifications by developers by its open source nature. With this in mid, the platform is built with the best standards and practices to ensure ease with expanding the code base and making it scalable. Learn more by exploring the documentation or seeing the code in the Github repository.  


# Features
- [Merchant Features](https://github.com/a2i-dpg/ekShop-doc/blob/master/merchant/MerchantFeatures.md)
- [Admin Features](https://github.com/a2i-dpg/ekShop-doc/blob/master/admin/AdminFeature.md)
- [Marketing Features](https://github.com/a2i-dpg/ekShop-doc/blob/master/admin/MarketingFeature.md)
- [Product Features](https://github.com/a2i-dpg/ekShop-doc//blob/masteradmin/ProductFeature.md)
- [Checkout Process](https://github.com/a2i-dpg/ekShop-doc/blob/master/marketplace/CheckoutProcess.md)


# Requirements
- Ubuntu Server
- Apache 2.4.52
- PHP 7.3
- Laravel 8.0
- MySQL 8.0  
or  
- MariaDB 10.4.22


## Easy Installation

## Server Setup

## Linux Server Setup For Production Deployment

<hr /> <br />

```shell
sudo apt-get update
```

#### install apache server
```shell
sudo apt-get install apache2
```

#### checking your Apache configuration for syntax errors:
```shell
sudo apache2ctl configtest
```

<!-- ### Install Db
```shell
sudo apt install mariadb-server
mysql_secure_installation
GRANT ALL ON *.* TO 'admin'@'localhost' IDENTIFIED BY 'password' WITH GRANT OPTION;
``` -->

### Install MySQL
```shell
sudo apt update
sudo apt install mysql-client mysql-server
sudo mysql_secure_installation

CREATE DATABASE laravel;
mysql -u root -p
CREATE USER 'laravel'@'localhost' IDENTIFIED BY 'secret';
GRANT ALL ON laravel.* to 'laravel'@'localhost';
FLUSH PRIVILEGES;
quit
```

### PHP 7.3 Install
```shell
sudo apt -y install php7.3

sudo apt-get install -y php7.3-cli php7.3-json php7.3-common php7.3-mysql php7.3-zip php7.3-gd php7.3-mbstring php7.3-curl php7.3-xml php7.3-bcmath

sudo apt-get install php7.3-mysqli

php -v
```

### Restart Apache
```shell
sudo service apache2 restart
```

### Composer Install 

Once php installed, need to install composer if not installed on machine. To install composer please follow following steps. [Reference link](https://getcomposer.org/download/)

```shell
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"

sudo mv composer.phar /usr/local/bin/composer

composer -v
```

### Apache Config and  virtual hosts
```shell
    <Directory "/var/www/html">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
```

### copy the virtual config
```shell
vi [Real Domain Address or Dummy Domain Address Like (www.dummy-host.com)].conf
```

```shell
    <VirtualHost *:80>
        ServerName [Real Domain Address or Dummy Domain Address Like (www.dummy-host.com)]
        ServerAdmin webmaster@[Real Domain Address or Dummy Domain Address Like (www.dummy-host.com)]
        DocumentRoot /var/www/html

        <Directory /var/www/html>
            AllowOverride All
        </Directory>

        ErrorLog /var/www/html/error.log
        CustomLog /var/www/html/access.log combined
    </VirtualHost>
```

```shell
sudo a2dissite 000-default.conf
sudo a2ensite [Real Domain Address or Dummy Domain Address Like (www.dummy-host.com)]
sudo a2enmod rewrite
sudo systemctl restart apache2
```


## Windows Server Setup For Local Deployment
<hr /> <br />


Use XAMPP or WAMP, if use XAMPP (PHP development environment) for installing php and Mysql or MariaDB server in windows local machine, for this case download xampp version (7.3 / PHP 7.3) in c drive.

Once installed xapmm, update configure apache server if needed, in this case go to C:\xampp\php\php.ini and extend limit max_execution_time = 10000 , max_input_time = 10000, memory_limit = 2048M, post_max_size = 2048M, upload_max_filesize = 2048M .


### Composer Install
Once XAMPP installed successfully, need to install composer if not installed on machine. To install composer please follow following steps. [Download link](https://getcomposer.org/download/)

Download and run Composer-Setup.exe - it will install the latest composer version whenever it is executed.
Once downloaded composer.exe, install this file and use command line path (C:\xampp\php\php.exe)

Now open the xampp server then run Apache and MySQL service.

Project folder path should be C:\xampp\htdocs 

To check composer version run this command into cli

```shell
composer -v
```



## Install Project using Git

```shell
    git clone https://github.com/a2i-dpg/ekShop.git
    cp .env.example .env
    import database (find DB in database folder)
    composer install
    php artisan storage:link
    php artisan key:generate
    php artisan passport:install --force
```

### Site URL Shoud Be Like
- http://localhost/project_folder  
or
- http://www.dummy-host.com (Or Real Domain Address)




### Default Users

#Login as an Admin
Username: admin@admin.com
Password: 123456

#Login as a Customer
Username: customer@example.com
Password: 123456

#Login as a Seller
Username: seller@example.com
Password: 123456

### Licensing & Copyright
Copyright 2022 @a2i, Bangladesh

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
