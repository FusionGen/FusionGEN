## Installation

Step by step:

- Install a webserver
- Configure Apache2 & create an empty fusiongen database
- Run the FusionGEN setup

## 1) Install a webserver
First of all you need to install a webserver in your machine like Apache Mysql PHP (AMP), there are several solutions for this like:

- LAMP for Linux
- MAMP for Mac
- XAMPP/WAMP/EasyPHP and similar for Windows

### - Linux (Debian-based)

- install MySQL

```
sudo apt-get install mysql-server mysql-client libmysqlclient-dev
```

- install Apache server

```
sudo apt-get install apache2 apache2-doc apache2-npm-prefork apache2-utils libexpat1 ssl-cert
```

- Install PHP (php7.2 latest version of PHP)

```
sudo apt-get install libapache2-mod-php7.2 php7.2 php7.2-common php7.2-curl php7.2-dev php7.2-gd php-pear php-imagick php7.2-mcrypt php7.2-mysql php7.2-ps php7.2-xsl php7.2-json php7.2-soap php7.2-
```

### - Mac

[Here](https://www.mamp.info/en/downloads/) the download link of MAMP.
MAMP can be installed by [hombrew](https://gist.github.com/alanthing/4089298)

### - Windows

Download [EasyPHP](http://www.easyphp.org/download.php)

### Alternative (cross-platform)
- [XAMPP](https://www.apachefriends.org/download.html)
- [WAMP](http://www.wampserver.com/en/)


## 2) Configure Apache2 & create an empty fusiongen database

### Linux & Mac

- On **Linux and Mac** you can use these commands to configure apache2
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


### Windows

**Enable PHP extensions**  
Go into your PHP directory and find the `php.ini` file. Mine was located in `C:\UwAmp\bin\php\php-7.2`. Open the file with a text editor and search (CTRL+F) for one of the modules you need to enable. To enable them, simply remove the `;` character in front of the line.
Save the file and restart your webserver to apply the changes.

![php extensions](/install/images/php.jpg)

**Enable Apache Modules**  
The Apache modules you'll need are:
- mod_rewrite
- mod_headers
- mod_deflate

Enable them!  
Go into your Apache directory and find the `httpd.conf` file. It should be located in `C:\UwAmp\bin\apache\conf`. Open the file with a text editor and search `CTRL+F` for one of the modules you need to enable. To enable them, simply remove the `#` character in front of the line.
Save the file and restart your webserver to apply the changes.

![apache modules](/install/images/apache.jpg)

**Create an empty fusiongen database**  
Execute this query SQL using mysql:
```
CREATE DATABASE fusiongen;
```

You will use this database during the FusionGEN setup.


## 3) Run the FusionGEN setup

Your webserver and mysql database is ready!

Put the source file of FusionGEN in your webserver directory 
- for Linux/Mac the directory should be `/var/www/html/`
- for Windows should be `htdocs`

Visit http://localhost/ and go to FusionGEN and run the setup.

Don't forget to rename or delete the `install` directory after you finished the installation.


## Troubleshooting

Open a issue if you find any troubles.
