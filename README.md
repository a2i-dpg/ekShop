# EKSHOP MARKETPLACE

> ### ekShop is a fully open-source eCommerce platform that is customizable and configurable to your needs.

This repo is functionality complete — PRs and issues welcome!
----------

# About

---
Marketplace is a fully open-source eCommerce platform that is customizable and configurable to your needs. It is completely free, adaptable and open to be supported by a worldwide community of volunteers and contributors. It’s free and open source nature allows users to maintain complete control of the data content and modify it as they wish and according to their needs. Our intended goal is to allow any potential entrepreneur to quickly get up and running with an online platform to sell goods online.
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

This project is open to modify to developers. With this in mid, the platform is built with the best standards and practices to ensure ease with expanding the code base and making it scalable. Learn more by exploring the documentation or seeing the code in the Github repository.


# Features
- [Merchant Features](docs//merchant/MerchantFeatures.md)
- [Admin Features](docs/admin/AdminFeature.md)
- [Marketing Features](docs/admin/MarketingFeature.md)
- [Product Features](docs/admin/ProductFeature.md)
- [Merchant Management](docs/admin/SellerFeature.md)



# Server Requirements
- PHP v7.4 or higher
- mysql v5.7xx / mariadb 10.8xx
- Composer v2.3.10+


#### Prerequisites:
You need to have: 
- A domain address: i.e: yourname.com, domain.com
- A functional hosting environment with prescribed server requirements met.
- Basic understanding of php based web hosting (Laravel)
- Basic know how of using command line

## Installation
The official laravel installation guide and server requirements for laravel v8.0 can be followed. [Official Documentation](https://laravel.com/docs/8.x/installation)

### Windows Server deployement
The environment can be created in a windows PC using PHP, mysql development stack such as [XAMPP](https://www.apachefriends.org/) or [Laragon](https://laragon.org/) (recommended)

##### Setup environment using XAMPP 
You can find out how to setup windows environemt using XAMP from [here](https://www.youtube.com/watch?v=081xcYZKOZA). 

To learn how to setup a project form git using composer please follow [this link](https://www.youtube.com/watch?v=EotvApQ3X8U)

##### Setup environment using Laragon
You can find out how to setup windows environemt using Laragon from [here](https://laragon.org/download/index.html).

To learn how to setup a project form git using composer please follow this [link](https://www.youtube.com/watch?v=WMoiQO5SYKc)

laragon will automatically configure the other setup part.
> In Laragon there will be a folder named **WWW**. Here we'll create or copy our project folder and reload apache 

If you want to use **phpmyadmin** in laragon then follow this [link](https://www.youtube.com/watch?v=uilYeu7PIOQ) for downloading and configure phpmyadmin with laragon.

##### Configure php.ini settings
After installation done;change these settings in php.ini file 
- max_execution_time = 10000 
- max_input_time = 10000
- memory_limit = 2048M
- post_max_size = 2048M
- upload_max_filesize = 2048M

To learn how to change php,ini file in XAMP follow [this link](https://www.youtube.com/watch?v=JTT_HwjaUQw)



##### Setup global php environment (optional)
With the installation of XAMPP or Laragon php environment setup automatically. Incase windows doesn't recognise php environment globally you can follow [these steps](https://www.youtube.com/watch?v=UjqdRiOiBZ8)


#### Docker

If you wish to use docker environment we suggest you go with linux environment. To setup the project with docker please follow the instruction [here](https://www.youtube.com/watch?v=G5Nk4VykcUw) 

You can also install Docker for windows from  [here](https://www.docker.com)


----------

## Cpanel Project Deployment
You can follow this link to learn how to deploy laravel project in cpanel from [here](https://bobcares.com/blog/cpanel-laravel-install/)



## Linux Server Setup For Project Deployment
***Note*** : You need to have ssh access to setup the project

###### Update OS Dependency
``` shell
sudo apt-get update
```
Now open ports 22 (for SSH), 80 and 443 and enable Ubuntu Firewall (ufw):
``` shell
sudo ufw allow ssh
sudo ufw allow 80
sudo ufw allow 443
sudo ufw enable
```

#### install apache server
```shell
sudo apt-get install apache2
```

#### checking your Apache configuration for syntax errors:
```shell
sudo apache2ctl configtest
```


#### Confirm that Apache is now running with the following command:
```shell
sudo systemctl status apache2
```

### You should the get an output showing that the apache2.service is running and enabled.

```shell
● apache2.service - The Apache HTTP Server
     Loaded: loaded (/lib/systemd/system/apache2.service; enabled; vendor preset: enabled)
     Active: active (running) since Tue 2020-11-03 10:32:26 UTC; 1min 6s ago
       Docs: https://httpd.apache.org/docs/2.4/
   Main PID: 52943 (apache2)
      Tasks: 7 (limit: 2282)
     Memory: 11.9M
     CGroup: /system.slice/apache2.service
             ├─52943 /usr/sbin/apache2 -k start
             ├─52944 /usr/sbin/apache2 -k start
             ├─52945 /usr/sbin/apache2 -k start
             ├─52946 /usr/sbin/apache2 -k start
             ├─52947 /usr/sbin/apache2 -k start
             ├─52948 /usr/sbin/apache2 -k start
             └─52953 /usr/sbin/apache2 -k start

```
### Once installed, test by accessing your server’s IP in your browser:
```shell
http://YOURSERVERIPADDRESS/
```
### Install mariadb database server
```shell
sudo apt install mariadb-server mariadb-client
```
```shell
mysql_secure_installation
```
```shell
GRANT ALL ON *.* TO 'admin'@'localhost' IDENTIFIED BY 'password' WITH GRANT OPTION;
```

### PHP 7.4 Install
Install php 7.4 and all dependencies
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


----
## Project deployment in Mac OS
To setup php environment in a MAC OS please follow the steps [here](https://www.javatpoint.com/how-to-install-laravel-on-mac)

## Install Project using Git

```shell
    git clone https://github.com/dp4pm/marketplace.git
    cp .env.example .env
    import database (find DB in database folder)
    composer update
    php artisan storage:link
    php artisan key:generate
    php artisan passport:install --force
```



## Install composer
Once environment setup installed successfully, you need to install composer if not installed on machine. Note that, XAMPP, GIT etc comes in a package with Laragon. This should be already installed in your PC if you use Laragon.

To install composer please follow following steps. [Download link](https://getcomposer.org/download/)

To learn how to install composer in windows follow [this link](https://www.youtube.com/watch?v=BGyuKpfMB9E)
To learn how to install composer in linux follow [this link](https://www.youtube.com/watch?v=rK02cVOwhUw)

## Install Git
You need **git** for clonning the project from any version control system ex: github, Bitbucket etc.

You can simply download and install git from [here](https://git-scm.com/downloads)

or you can learn how to to this, follow the [link](https://www.youtube.com/watch?v=2j7fD92g-gE)

> ## Install Project using Git
Clone the repository

    git clone https://github.com/dp4pm/marketplace.git
Switch to the repo folder

    cd marketplace

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Create Database (name: **dpg_shop**)

Set the database connection in .env

    DB_DATABASE="dpg_shop"
    DB_USERNAME="root"
    DB_PASSWORD=""    

Import database from database folder.(***project-root-folder/database/marketplace_db.sql***)

Link the storage for images and other file contents

    php artisan storage:link

Generate a new application key

    php artisan key:generate

Install laravel passport

    php artisan passport:install --force

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**TL; DR command list**

    git clone https://github.com/dp4pm/marketplace.git
    cd marketplace
    composer install
    cp .env.example .env
    php artisan storage:link
    php artisan key:generate
    php artisan passport:install --force

> ## Default Users

##Login as an Admin
Username: admin@admin.com
Password: 123456

##Login as a Customer
Username: customer@example.com
Password: 123456

##Login as a Seller
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

