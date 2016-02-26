# Gladiator [![StyleCI](https://styleci.io/repos/51176505/shield)](https://styleci.io/repos/51176505)

Welcome to **Gladiator**, the admin tool for DoSomething Competitions!

This application is built using the [Laravel](https://laravel.com) Framework.

### Getting Started
Fork and clone this repository, and set it up as a local app running inside [DS Homestead](https://github.com/DoSomething/ds-homestead) or regular [Homestead](https://github.com/laravel/homestead).

After the initial Homestead installation `ssh` into the vagrant box, head to the project directory and run composer to install all the project dependencies:

```shell
$ composer install
```

Once all vendor dependencies are installed, run the migrations to setup the database and seed it:

```shell
$ php artisan migrate
$ php artisan db:seed
```

Next, if you already exist as a DoSomething user within [Northstar]((https://www.github.com/dosomething/northstar), our user and activity API, run the following command to set yourself up as an admin in your local Gladiator instance:

```shell
$ php artisan add:user username@dosomething.org --role=admin
```

Finally, to setup the front-end build system, you can either be in the Homestead vagrant box or on your local.

Homestead already comes with `node` and `npm`, but if running on your local you will need to make sure both those dependecies are installed.

You need to install `gulp` globally using:

```shell
$ npm install --global gulp
```

Next, install all the `npm` dependencies:

```
$ npm install
```

Now you're all set to built the front-end assets by running:

```
$ gulp
```

All set!



---


## Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, queueing, and caching.

Laravel is accessible, yet powerful, providing powerful tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
