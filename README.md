# CodeIgniter 4 Application Starter

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](http://codeigniter.com).

This repository holds a composer-installable app starter.
It has been built from the
[development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [the announcement](http://forum.codeigniter.com/thread-62615.html) on the forums.

The user guide corresponding to this version of the framework can be found
[here](https://codeigniter4.github.io/userguide/).

## Installation & updates

`composer create-project codeigniter4/appstarter` then `composer update` whenever
there is a new release of the framework.

When updating, check the release notes to see if there are any changes you might need to apply
to your `app` folder. The affected files can be copied or merged from
`vendor/codeigniter4/framework/app`.

## Setup

Copy `env` to `.env` and tailor for your app, specifically the baseURL
and any database settings.

## Important Change with index.php

`index.php` is no longer in the root of the project! It has been moved inside the *public* folder,
for better security and separation of components.

This means that you should configure your web server to "point" to your project's *public* folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the
framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!

## Repository Management

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## Server Requirements

PHP version 7.3 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php)
- xml (enabled by default - don't turn it off)

------------------------------------------------------------------------------------------------------------------------------------------------------------
To run app use php spark serve on command prompt and access the homepage on http://localhost:8080/clothes/index

JClothe is an ecommerce site that sells clothes.

Existing users: Admin
Email/Username: khumph@yahoo.com
Password: humphrey

Client Login
Register a new user at localhost:8080/clothes/registration and login at localhost:8080/clothes/login

Alternatively, use:
Email/Username: shassan@gmail.com
Password: sarahHassan

Homepage screenshot:
<img width="943" alt="homepage" src="https://user-images.githubusercontent.com/69391540/184017977-67665695-9b5b-45d6-80bf-d6977a5bbfcc.png">
<img width="947" alt="homepagefooter" src="https://user-images.githubusercontent.com/69391540/184017985-21e4e17f-2db5-40ad-a852-456461214b44.png">

Login Page:

<img width="946" alt="login" src="https://user-images.githubusercontent.com/69391540/184018863-a85eff2c-42eb-48f4-a5d2-03d044712754.png">

Products page:
<img width="947" alt="products" src="https://user-images.githubusercontent.com/69391540/184020275-7fd8c79b-b60e-4930-b4ce-ee730b092dad.png">
<img width="945" alt="products1" src="https://user-images.githubusercontent.com/69391540/184018608-e8e37516-3061-4ca9-bbe1-a87b5dd6c4a6.png">
<img width="944" alt="products2" src="https://user-images.githubusercontent.com/69391540/184018648-bab2831c-9b70-4ea9-9ae1-9ce1484cd4f5.png">

Cart Page:
<img width="944" alt="cart" src="https://user-images.githubusercontent.com/69391540/184019381-a35e831f-66f4-4f85-bf28-6f6dc80d66f3.png">
<img width="946" alt="cartfooter" src="https://user-images.githubusercontent.com/69391540/184019392-7dedda0c-70d5-405d-8e05-04a6ff75c79d.png">

Order Confirmation:
<img width="946" alt="orderconfirmation" src="https://user-images.githubusercontent.com/69391540/184019843-1e025040-3b99-48be-ac62-d803af50caba.png">
<img width="946" alt="orderconfirmation1" src="https://user-images.githubusercontent.com/69391540/184019853-3ad14e30-eb19-477f-baf6-cf3e2ef6ac86.png">

And so much more functionality 😃! Admin's panel - editing and adding products, viewing purchase analytics amongst others, some API functionality embedded, adding money to wallet, checking the balance, viewing user profile, viewig purchase history among others!!!

Attached screenshots are just but a sneak peek😁!
