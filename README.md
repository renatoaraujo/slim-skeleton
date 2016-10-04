# Slim Skeleton Application

[![Build Status](https://travis-ci.org/renatoaraujo/slim-skeleton.svg?branch=master)](https://travis-ci.org/renatoaraujo/slim-skeleton)
[![Code Climate](https://codeclimate.com/github/renatoaraujo/slim-skeleton/badges/gpa.svg)](https://codeclimate.com/github/renatoaraujo/slim-skeleton)

Simple skelleton for [Slim Framework](https://github.com/slimphp/Slim) I did for personal projects.

You can use this skeleton application easily to create your awesome API's or websites.

Used for this project:
  - [Slim Framework 3](https://github.com/slimphp/Slim)
  - [Slim Twig View](https://github.com/slimphp/Twig-View)
  - [Monolog](https://github.com/Seldaek/monolog)
  - [Doctrine ORM 2](http://www.doctrine-project.org/projects/orm.html)

### Installation
Clone the repo into your PATH
```
$ git clone https://github.com/renatoaraujo/slim-skeleton.git
```

Run the [Composer](https://getcomposer.org/) to install dependencies and create the autoload for application
```
$ composer install
```

Update the config.php located at app/config/config.php with your database connection parameters and run the doctrine to create schema
```
$ php ./bin/doctrine orm:schema-tool:create
```

Run the application using composer
```
$ composer serve
```

Or create your Nginx/Apache virtual host pointing to /public/index.php
