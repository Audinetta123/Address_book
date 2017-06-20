# REST API using Slim Framework 3 Skeleton Application

1 install composer

2 Run this command from the directory in which you want to create your new Slim Framework application

    php composer create-project slim/slim-skeleton [my-app-name]

* Point your virtual host document root to your new application's `public/` directory.

3 Run this command

    sudo php -S localhost:8080 -t public public/index.php OU
    sudo php -S 0.0.0.0:8080 -t public public/index.php -> ALL PORTS LISTENING

4 Insert db "addressBook.sql" into your database manager

5 Use Postman to test the API

