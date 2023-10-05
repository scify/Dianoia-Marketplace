# Dianoia Marketplace Web Application

[![GitHub Issues](https://img.shields.io/github/issues/scify/Dianoia-Marketplace)](https://img.shields.io/github/issues/scify/Dianoia-Marketplace)
[![GitHub Stars](https://img.shields.io/github/stars/scify/Dianoia-Marketplace)](https://img.shields.io/github/stars/scify/Dianoia-Marketplace)
[![GitHub forks](https://img.shields.io/github/forks/scify/Dianoia-Marketplace)](https://img.shields.io/github/forks/scify/Dianoia-Marketplace)
[![JavaScript Style Guide: Good Parts](https://img.shields.io/badge/code%20style-goodparts-brightgreen.svg?style=flat)](https://github.com/dwyl/goodparts "JavaScript The Good Parts")
[![contributions welcome](https://img.shields.io/badge/contributions-welcome-brightgreen.svg?style=flat)](https://github.com/dwyl/esta/issues)
[![License](https://img.shields.io/badge/License-Apache%202.0-blue.svg)](https://opensource.org/licenses/Apache-2.0)
[![Maintenance](https://img.shields.io/badge/Maintained%3F-yes-green.svg)](https://GitHub.com/Naereen/StrapDown.js/graphs/commit-activity)
[![Ask Me Anything !](https://img.shields.io/badge/Ask%20me-anything-1abc9c.svg)](https://GitHub.com/scify)

Laravel 10 Web Application for Creating content for the Dianoia mobile app

[Project URL](https://dianoia.scify.org/)

# Installation Instructions:

## Pre-initialization steps

After cloning the project, create an .env file (should be a copy of .env.example),
containing the information about your database name and credentials:

```bash
cp .env.example .env
```

Take a look at the `.env` file that was created. You may need to update the `DB_*` variables, in order to set up the DB connection.
Also, make sure that the `APP_URL` is set to the correct domain and port that you will be using.

<hr>

## First time install (setup database and install dependencies)

0. Make sure php 8.0 (or newer) is installed.


1. After cloning the project, create an .env file (should be a copy of .env.example),
   containing the information about your database name and credentials.
   Then run ```php artisan migrate``` to create the DB schema and
   ```php artisan db:seed``` in order to insert the starter data to the DB

2. Install laravel/back-end dependencies
```bash
composer install

composer dump-autoload
```

3. Front-end dependencies

It is very easy to install multiple versions of NodeJS and npm, by using [Node Version Manager (nvm)](https://github.com/creationix/nvm).

If you are using [`nvm`](https://github.com/nvm-sh/nvm), run this command in order to sync to the correct NodeJS version for the project:

```bash
nvm use
```

Then, install and compile the front-end dependencies:

```bash
npm install

npm run dev #(use prod if in production)
```

4. Create the symbolic link for user-uploaded files.

```bash
php artisan storage:link
```

in order to link the `/public/storage` folder with the `/storage/app/public` directory

## SEO - Generate Sitemap

This application uses [Spatie - Laravel Sitemap](https://github.com/spatie/laravel-sitemap) plugin, in order to create
the `public/sitemap.xml` file (which is excluded from git), that will be crawled by the search engines.
In order to run the generator for the current application installation, run the embedded Laravel command:

```bash
php artisan sitemap:generate
```
## PHP code style - Laravel Pint

This application uses [Laravel Pint](https://laravel.com/docs/9.x/pint) in order to perform code-style.

In order to run the styler, run :

```bash
./vendor/bin/pint --test -v # the --test will not do any changes, it will just output the changes needed

./vendor/bin/pint -v # this command will actually perform the code style changes 
```

## Apache configuration example:

```
% sudo touch /etc/apache2/sites-available/dianoiamarketplace.conf
% sudo nano /etc/apache2/sites-available/dianoiamarketplace.conf
<VirtualHost *:80>
       
        ServerName dev.dianoiamarketplace
        ServerAlias dev.dianoiamarketplace
        DocumentRoot "/home/path/to/project/public"
        <Directory "/home/path/to/project/public">
            Require all granted
            AllowOverride all
        </Directory>
       
        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined

</VirtualHost>
```
Make the symbolic link:
```
% cd /etc/apache2/sites-enabled && sudo ln -s ../sites-available/dianoiamarketplace.conf
```
Enable mod_rewrite, mod_ssl and restart apache:
```
% sudo a2enmod rewrite && sudo a2enmod ssl && sudo service apache2 restart
```

Fix permissions for storage directory:

```bash
sudo chown -R ${USER}:www-data storage

chmod 775 storage

cd storage/

find . -type f -exec chmod 664 {} \;

find . -type d -exec chmod 775 {} \;
```

Or run the `set-file-permissions.sh` script (needs sudo):

```bash
sudo ./set-file-permissions.sh www-data {{app_user}} .
```

Change hosts file so dev.dianoiamarketplace points to localhost
```$xslt
sudo nano /etc/hosts

127.0.0.1       dev.dianoiamarketplace
```

## How to debug
- Install and configure Xdebug on your machine
- At Chrome install [Xdebug helper](https://chrome.google.com/webstore/detail/xdebug-helper/eadndfjplgieldjbigjakmdgkmoaaaoc?utm_source=chrome-app-launcher-info-dialog)
- At PhpStorm/IntelliJ click the "Start listening for PHP debug connections"
