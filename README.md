Order-Tracker
============

[![Latest Stable Version](https://poser.pugx.org/kejvingl/order-tracker/v/stable)](https://packagist.org/packages/kejvingl/order-tracker)
[![License](https://poser.pugx.org/kejvingl/order-tracker/license)](https://packagist.org/packages/kejvingl/order-tracker)
[![Total Downloads](https://poser.pugx.org/kejvingl/order-tracker/downloads)](https://packagist.org/packages/kejvingl/order-tracker)


Requirements
------------

* PHP >= 8.0;
* composer.
* yajra/laravel-datatables-oracle
* yajra/laravel-datatables-buttons
* maatwebsite/excel
* spatie/browsershot
* spatie/laravel-pdf

Features
--------
* PSR-4 autoloading compliant structure;

Installation
============

    composer require kejvingl/order-tracker

    php artisan vendor:publish --tag=order-tracker

This will publish all neccesary structure to start implementing orders in your project:

* **/config/order-tracker.php** is where you can configure values and options relative to the use case
* **/Controllers/OrderController.php** The Controller in charge of handling Orders and the included views..
* **/resources/views** The optional premade views.
* **/public/css/app.css** Styling needed for views to function correctly.
* **/migrations** Migration needed to create the Orders table in the database.
* **routes/web.php** The routes which interact with orders.
* **/Exports/OrderExports.php** The configuration file for exporting orders as XLSX. 
* **/Models/Order.php**
* **OrderTrackerServiceProvider.php** 


Publishing All Resources:
--------
    php artisan vendor:publish --tag=order-tracker

Publishing Views & Public only:
--------
    php artisan vendor:publish --tag=order-tracker-config


Publishing Views & Public only:
--------
    php artisan vendor:publish --tag=order-tracker-views

Publishing Model only:
--------
    php artisan vendor:publish --tag=order-tracker-models

Publishing Migrations only:
--------
    php artisan vendor:publish --tag=order-tracker-migrations
.
License
=======

Please refer to [LICENSE](https://github.com/GinoPane/composer-package-template/blob/master/LICENSE).
