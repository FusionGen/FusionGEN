## Installation

Step by step:

- Install a webserver
- Configure Apache2 & create an empty fusiongen database
- Run the FusionGEN setup

## 1) Install a webserver
First of all you need to install a webserver in your machine like Apache Mysql PHP (AMP), there are several solutions for this like:

- LAMP for Linux

### - Linux (Debian-based)

- install MySQL

```
sudo apt-get install mysql-server mysql-client libmysqlclient-dev
```

- install Apache server

```
sudo apt-get install apache2 apache2-doc apache2-npm-prefork apache2-utils libexpat1 ssl-cert
```

- Install PHP (php7.1.33 latest version of PHP) -- **FusionGEN Maintainer Edit: We don't support 7.2 or above! , please install PHP Version 7.1.33**

```
sudo apt-get install libapache2-mod-php7.1 php7.1 php7.1-common php7.1-curl php7.1-dev php7.1-gd php-pear php-imagick php7.1-mcrypt php7.1-mysql php7.1-ps php7.1-xsl php7.1-json php7.1-soap php7.1-
```

## 2) Configure Apache2 & create an empty fusiongen database

### Linux

- On **Linux** you can use these commands to configure apache2
```
sudo a2enmod rewrite
sudo a2enmod headers
sudo a2enmod expires
sudo a2enmod deflate
```

Edit the virtualhost configuration allowing the rewrite on localhost:
```
sudo nano /etc/apache2/sites-available/000-default.conf
```

Insert the following code between the `<VirtualHost *:80>` tags replacing `/var/www/html` with your directory path of the webserver (on Ubuntu the default path is `/var/www/html`):
```html
    <Directory /var/www/html>
        Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        Require all granted
    </Directory>
```

Than restart apache2 service:
```
/etc/init.d/apache2 restart
```

**Create an empty fusiongen database**  
Execute this query SQL using mysql:
```
CREATE DATABASE fusiongen;
```

You will use this database during the FusionGEN setup.


## Troubleshooting

Open a issue if you find any troubles.
