# Slim Skeleton Application

[![Build Status](https://travis-ci.org/renatoaraujo/slim-skeleton.svg?branch=master)](https://travis-ci.org/renatoaraujo/slim-skeleton)
[![Join the chat at https://gitter.im/renatoaraujo/slim-skeleton](https://badges.gitter.im/renatoaraujo/slim-skeleton.svg)](https://gitter.im/renatoaraujo/slim-skeleton?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
Simple skelleton for [Slim Framework](https://github.com/slimphp/Slim) I did for personal projects.

You can use this skeleton application easily to create your awesome API's or websites.
You are welcome to collaborate and any suggestions please contact me.

Trello board for development https://trello.com/b/zsOp3dNi

Used for this project:
  - [Slim Framework 3](https://github.com/slimphp/Slim)
  - [Slim Twig View](https://github.com/slimphp/Twig-View)
  - [Monolog](https://github.com/Seldaek/monolog)
  - [Doctrine ORM 2](http://www.doctrine-project.org/projects/orm.html)
  - [Whoops](http://filp.github.io/whoops/)

### Installation
Clone the repo into your PATH
```
$ git clone https://github.com/renatoaraujo/slim-skeleton.git
```

Run the [Composer](https://getcomposer.org/) to install dependencies and create the autoload for application
```
$ composer install
```

Create the settings file just copying or changing the name of app/settings/settings.example.php to settings.php. Note: in this file you will settingsure your database connection when it's ready.

Go to public/ folder and run the command
```
$ php -S localhost:3000
```
Or create your Nginx/Apache virtual host pointing to /public/index.php

### Development

### Todo

Create a class to start up the application on bootstrap

Create the database layer using Doctrine ORM

Create simple example for register/login and services to get users

Finish the documentation
