## Installation

Step by step:

1. Package Installation
2. Webserver Configuration
3. Database Configuration
4. Setting up FusionGEN
5. Troubleshooting

## 1) Package Installation

**We do not currently offer CentOS/RHEL 8 instructions, due to the removal of php-imagick and GraphicsMagick not yet being available to all of the main architectures.**

### Linux (Debian 10 "Buster")

- Install MariaDB server

```
sudo apt-get install mariadb-server mariadb-client
sudo systemctl enable mariadb --now
```

- Install Apache2 server

```
sudo apt-get install apache2
sudo systemctl enable apache2 --now
```

- Import the Sury PHP repository -- **Debian Buster comes with PHP 7.3 as the default version installable. PHP 7.1.33 can be fetched from this repository.**

```
sudo curl -Lo /etc/apt/trusted.gpg.d/php71.gpg https://packages.sury.org/php/apt.gpg
sudo echo 'deb https://packages.sury.org/php/ buster main' > /etc/apt/sources.list.d/php71.list
sudo apt-get update
```

- Install PHP 7.1.33 -- **FusionGEN does not currently support PHP 7.2 or above! Please install PHP Version 7.1.33.**

```
sudo apt-get install libapache2-mod-php7.1 php7.1 php7.1-common php7.1-curl php7.1-dev php7.1-gd php7.1-gmp php-imagick php7.1-json php7.1-mcrypt php7.1-mysql php7.1-mbstring php-pear php7.1-ps php7.1-soap php7.1-xsl
```

## 2) Webserver Configuration

### Linux (Debian 10 "Buster")

- Pull the latest FusionGEN source. -- **If you're using the latest emulation servers, you will need the master-srp6 branch, otherwise it won't work.**
```
sudo apt-get install git
git clone -b master-srp6 https://github.com/FusionGen/FusionGEN ~/
```

- Create the FusionGEN site directory and move the source files into it.
```
sudo mkdir -p /usr/share/fusiongen
sudo mv ~/FusionGEN /usr/share/fusiongen/html
sudo rm -rf /usr/share/fusiongen/html/{.git*,*.md,LICENSE}
```

- Fix the ownership and permissions of the FusionGEN site directory.
```
sudo chown -R www-data:www-data /usr/share/fusiongen/html
sudo chmod -R 640 /usr/share/fusiongen/html
sudo chmod -R ug+X /usr/share/fusiongen/html
```

#### Port 80 (HTTP) -- **If you follow this step, skip the Port 443 (HTTPS) instructions bellow**

- Create a copy of and disable the default Apache2 site configuration.

```
sudo cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/fusiongen.conf
sudo a2dissite 000-default
```

- Configure PHP logging and timezone settings.
```
sudo sed -i '/^;error_log[\t ]\+=[\t ]\+syslog/aerror_log = \/var\/log\/php\/error.log' /etc/php/7.1/apache2/php.ini
sudo sed -i 's/^;\(date\.timezone[\t ]\+=\)/\1 Europe\/Amsterdam/' /etc/php/7.1/apache2/php.ini
```

- Create additional Apache2 configuration for FusionGEN.
```
sudo echo -e '<Directory /usr/share/fusiongen/html>\n\tOptions Indexes FollowSymLinks MultiViews\n\tAllowOverride All\n\tRequire all granted\n</Directory>' > /etc/apache2/conf-available/fusiongen.conf
```

- Create the Apache2 site configuration for FusionGEN. -- **Edit the ServerAdmin and ServerName with your information.**

```
sudo sed -i 's/\(^[\t ]\+ServerAdmin[\t ]\+\).*/\1admin@localhost.localdomain/' /etc/apache2/sites-available/fusiongen.conf
sudo sed -i '/^[\t ]\+ServerAdmin[\t ]\+.*/a\\tServerName fusiongen.localhost.localdomain/' /etc/apache2/sites-available/fusiongen.conf
sudo sed -i 's/\(^[\t ]\+DocumentRoot[\t ]\+\).*/\1\/usr\/share\/fusiongen\/html/' /etc/apache2/sites-available/fusiongen.conf
sudo sed -i '/^[\t ]\+#Include.*/a\\n\t# Include fusiongen configuration\n\tInclude conf-available\/fusiongen.conf' /etc/apache2/sites-available/fusiongen.conf
```

- Enable the required Apache2 modules and the FusionGEN site configuration.

```
sudo a2enmod rewrite headers expires deflate
sudo a2ensite fusiongen
```

- Restart the Apache2 service.

```
sudo systemctl restart apache2
```

#### Port 443 (HTTPS) -- **If you follow this step, skip the Port 80 (HTTP) instructions above**

- Create a copy of and disable the default Apache2 site configuration.

```
sudo cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/fusiongen.conf
sudo a2dissite 000-default
```

- Configure PHP logging and timezone settings.
```
sudo sed -i '/^;error_log[\t ]\+=[\t ]\+syslog/aerror_log = \/var\/log\/php\/error.log' /etc/php/7.1/apache2/php.ini
sudo sed -i 's/^;\(date\.timezone[\t ]\+=\)/\1 Europe\/Amsterdam/' /etc/php/7.1/apache2/php.ini
```

- Disable Port 80 on Apache2.

```
sudo sed -i 's/\(^Listen[\t ]\+80$\)/#\1/' /etc/apache2/ports.conf
```

- Create additional Apache2 configuration for FusionGEN.

```
sudo echo -e '<Directory /usr/share/fusiongen/html>\n\tOptions Indexes FollowSymLinks MultiViews\n\tAllowOverride All\n\tRequire all granted\n</Directory>' > /etc/apache2/conf-available/fusiongen.conf
```

- Create the Apache2 site configuration for FusionGEN. -- **Edit the ServerAdmin and ServerName with your information. You will also have to place your certificates into /etc/ssl/certs and your keys into /etc/ssl/private accordingly, then edit SSLCertificateFile, SSLCertificateKeyFile and SSLCACertificateFile with the respective filenames of your certificates/keys.**

```
sudo sed -i 's/\(^<VirtualHost[\t ]\+\*:\)[0-9]\+\(>\)/\1443\2/' /etc/apache2/sites-available/fusiongen.conf
sudo sed -i 's/\(^[\t ]\+ServerAdmin[\t ]\+\).*/\1admin@localhost.localdomain/' /etc/apache2/sites-available/fusiongen.conf
sudo sed -i '/^[\t ]\+ServerAdmin[\t ]\+.*/a\\tServerName fusiongen.localhost.localdomain/' /etc/apache2/sites-available/fusiongen.conf
sudo sed -i 's/\(^[\t ]\+DocumentRoot[\t ]\+\).*/\1\/usr\/share\/fusiongen\/html/' /etc/apache2/sites-available/fusiongen.conf
sudo sed -i '/^[\t ]\+DocumentRoot[\t ]\+.*/a\\n\tSSLEngine on\n\tSSLSessionTickets off\n\tSSLProtocol -all +TLSv1.2 +TLSv1.3\n\tSSLCipherSuite HIGH:!aNULL\n\tSSLProxyCipherSuite HIGH:!aNULL\n\tSSLCertificateFile \/etc\/ssl\/certs\/ServerCertificate.pem\n\tSSLCertificateKeyFile \/etc\/ssl\/private\/ServerCertificate.key\n\tSSLCACertificateFile \/etc\/ssl\/certs\/CACertificate.pem' /etc/apache2/sites-available/fusiongen.conf
sudo sed -i '/^[\t ]\+#Include.*/a\\n\t# Include fusiongen configuration\n\tInclude conf-available\/fusiongen.conf' /etc/apache2/sites-available/fusiongen.conf
```

- Enable the required Apache2 modules and the FusionGEN site configuration.

```
sudo a2enmod ssl rewrite headers expires deflate
sudo a2ensite fusiongen
```

- Restart the Apache2 service.

```
sudo systemctl restart apache2
```

## 3) Database Configuration

### Linux (Debian 10 "Buster")

- Perform the initial MariaDB configuration.

```
sudo mysql_secure_installation
```

### MariaDB

- Create a new MariaDB user and database for FusionGEN, by executing the following queries. -- **You're going to be using this information for the FusionGEN setup, so please use a strong/secure password.**

```
CREATE USER fusiongen@'%' IDENTIFIED BY 'PASSWORD';
CREATE DATABASE fusiongen;
GRANT ALL PRIVILEGES ON fusiongen.* TO fusiongen@'%';
FLUSH PRIVILEGES;
```

## 4) Setting up FusionGEN

Open up your web browser and type in the address of your webserver, then follow the onscreen instructions.

## Troubleshooting

- If you get stuck by the end of the FusionGEN web setup, in an indefinite "writing config" screen, and you're getting a lot of `fgets()` and `feof()` `expects parameter 1 to be resource, boolean given` in your Apache2 error logs; your permissions in `/usr/share/fusiongen/html` are most likely wrong.

If you run into any issues, feel free to open up an issue on github.

Alternatively, you can join our discord at https://discord.gg/5nSt9puU4V
