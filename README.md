# Installation Instructions

## 1. Configure the Hosts File

In order to get the mapping of the URL http://jobsitychatbot.com to the Apache folder /var/www/jobsitychatbot to work, the file /etc/hosts needs to be edited.

Add the following line to the /etc/hosts file:

    127.0.0.1    jobsitychatbot.com

## 2. Configure Apache Virtual Hosts

Edit the file httpd.conf and add the following:

    <VirtualHost 127.0.0.1:80>
      <Directory "{$path}/www/jobsitychatbot">
        Options FollowSymLinks Indexes
        AllowOverride All
        Order deny,allow
        allow from All
      </Directory>
      ServerName jobsitychatbot.com
      ServerAlias jobsitychatbot.com 127.0.0.1
      DocumentRoot "{$path}/www/jobsitychatbot"
      ErrorLog "{$path}/apache/logs/error.log"
      CustomLog "{$path}/apache/logs/access.log" combined
    </VirtualHost>

## 3. Clone the git repository with the assignment’s code

Enter the Apache’s www directory and clone the git repository:

    $ git clone git@github.com:f11lopez/jobsitychatbot.git

## 4. Install all dependencies

Inside the root folder of the cloned repository "{$path}/www/jobsitychatbot”, run the following command:

    $ composer install

## 5. Setup the MySQL database

Create the MySQL database “jobsitychatbot” and set a username and password.

In the newly created database “jobsitychatbot”, run the SQL script located at the root of the site: “jobsitychatbot.sql” to create all needed tables.

## 6. Setup the project’s configuration file “.env”

Rename the file “.env.example” located at the root of the site to “.env”.

Edit the “.env” file to configure the following:

    APP_NAME=JobSityChatbot
    APP_ENV=local
    APP_KEY= (you can use a key from another project or generate a new one)
    APP_DEBUG=true
    APP_URL=http://jobsitychatbot.com
    
    LOG_CHANNEL=stack
    LOG_LEVEL=debug
    
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    \# DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=jobsitychatbot
    DB_USERNAME=(the usersame just set)
    DB_PASSWORD=(the password just set)

## 7. Check the assignment

Using your browser enter http://jobsitychatbot.com

Follow the instructions shown at the home page to operate the chatbot.

You will need to register to access all chatbot’s functionality.
