# ekShop (Marketplace)

- [About](#about-dpg-marketplace)
- [Features](#features)
- [Requirements](#requirements)
- [Easy Installation](#easy-installation)
- [Server Setup](#server-setup)
    - [Ubuntu Server Setup](#update-os-dependency)
- [Install Project using Git](#install-project-using-git)

# About
ekShop is a fully open-source eCommerce platform that is customizable and configurable to your needs. It is completely free, adaptable and open to be supported by a worldwide community of volunteers and contributors. It’s free and open source nature allows users to maintain complete control of the data content and modify it as they wish and according to their needs. Our intended goal is to allow any potential entrepreneur to quickly get up and running with an online platform to sell goods online. 
Some key features of Marketplace include:


-	Showcase digital and physical goods in categories, sorting by brands
-	Multi-vendor support with management tools and configuration
-	Modular product blocks allow you to customize pages in minutes.
-	Built in campaign tools to allow for promotions and sales
-	SEO configuration input simplified to boost page rank in search results
-	Admin dashboard to import and export items in bulk
-	Inventory management
-	Multi-user access
-	Ticket based support system
-	Social media integration
-	Multiple payment integration supported
-	Privacy preserving with limited or no 3rd party data tracking

Our platform is open to modifications by developers by its open source nature. With this in mid, the platform is built with the best standards and practices to ensure ease with expanding the code base and making it scalable. Learn more by exploring the documentation or seeing the code in the Github repository.  


# Features
- [Merchant Features](https://github.com/a2i-dpg/ekShop-doc/blob/master/merchant/MerchantFeatures.md)
- [Admin Features](https://github.com/a2i-dpg/ekShop-doc/blob/master/admin/AdminFeature.md)
- [Marketing Features](https://github.com/a2i-dpg/ekShop-doc/blob/master/admin/MarketingFeature.md)
- [Product Features](https://github.com/a2i-dpg/ekShop-doc//blob/masteradmin/ProductFeature.md)
- [Checkout Process](https://github.com/a2i-dpg/ekShop-doc/blob/master/marketplace/CheckoutProcess.md)


# Requirements
- Ubuntu Server
- PHP 7.4
- mysql
- Mariadb Server
- Laravel 8

## Easy Installation

## Server Setup

#### Update OS Dependency
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

### Install Db
```shell
sudo apt install mariadb-server
mysql_secure_installation
GRANT ALL ON *.* TO 'admin'@'localhost' IDENTIFIED BY 'password' WITH GRANT OPTION;
```

### PHP 7.4 Install
```shell
sudo apt -y install php7.4

sudo apt-get install -y php7.4-cli php7.4-json php7.4-common php7.4-mysql php7.4-zip php7.4-gd php7.4-mbstring php7.4-curl php7.4-xml php7.4-bcmath

sudo apt-get install php7.4-mysqli

sudo apt-get install php7.4-xml
```

### Restart Apache
```shell
sudo service apache2 restart
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
vi [Your Domain Address].conf
```

```shell
    <VirtualHost *:80>
        ServerName [Your Domain Address]
        ServerAdmin webmaster@[Your Domain Address]
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
sudo a2ensite [Your domain address]
sudo a2enmod rewrite
sudo systemctl restart apache2
```


## Install Project using Git

```shell
    git clone https://github.com/a2i-dpg/ekShop.git
    cp .env.example .env
    import database (find DB in database folder)
    composer update
    php artisan storage:link
    php artisan key:generate
    php artisan passport:install --force
```

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
