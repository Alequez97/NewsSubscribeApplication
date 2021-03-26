# News subscribe app

## General info
Simple news subscription web project. User can subscribe for news mailing.

## Technologies
Project created with
* PHP 7.3
* MySQL
* jQuery
* Bootstrap 4 (Subscribers page)

## Setup
To run this project you have to install web-server on your computer.
Easiest way is install WAMP or XAMPP technology stack, 
which includes Apache web-server, MySQL and PHP.
Then clone project repository inside servers web folder.
In wamp it would be for example C:\wamp64\www
In xampp it would be C:\xampp\htdocs

Make sure to start server working.
Before to start work with project you need to create database.
Go to localhost/phpmyadmin and run SQL script which is in backend/databse directory.

By default phpmyadmin should have username "root", and empty password.
Than specify database connection credentials in database_credentials.txt file 
if you change it.

After all project will be reachable at localhost/magebit in browser.
If you want to use another url, you should create virtualhost.