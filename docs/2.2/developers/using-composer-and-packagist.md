# Using Composer and Packagist

[Composer](http://getcomposer.org/) is a PHP dependency manager. [Packagist](http://packagist.org/)
is a directory of available packages for Composer. Packages can be anything
from single classes to complete frameworks.

> You'll notice in the Elefant [installation steps](/docs/2.2/getting-started/installation)
that we recommend using Composer to install Elefant itself!

## Installing packages via Composer

Composer packages live in Elefant's `lib/vendor` folder. To install a new package, you
can either edit the `composer.json` file and add the packages to the `require` block,
then run:

~~~bash
$ php composer.phar install
~~~

Or you can specify the package itself on the command line, and Composer will add it to
your `composer.json` file automatically:

~~~bash
$ php composer.phar require vendor/package-name
~~~

## Using Composer's autoloader

Elefant's own autoloader will play nice with any subsequently loaded autoloader. To add
the Composer autoloader to your site, create a file named `bootstrap.php` in the root
of your site with the following contents:

~~~php
<?php

require 'lib/vendor/autoload.php';

?>
~~~

Now you should be able to autoload your installed Composer packages. For example, if
you've installed the [merk/Dough](https://packagist.org/packages/merk/dough) package,
the following handler code should work:

~~~php
<?php // apps/test/handlers/dough.php

use Dough\Money\Money;

$money = new Money (5.75);
$money = $money->tmes (1.12);
echo $money->getAmount ();

?>
~~~

## Installing Elefant apps and themes

Many of Elefant's own apps and themes can be installed via Composer. These will be
correctly installed into the `apps` or `layouts` folders, respectively, instead of
the `lib/vendor` folder for regular Composer packages.

For example, you can install the [Form Builder](https://github.com/jbroadway/form) app
like this:

~~~bash
$ php composer.phar require elefant/app-form
~~~

> [Click here for a full list of Elefant's apps and themes available through Composer.](https://packagist.org/packages/elefant/)

## Updating packages via Composer

Updating your packages via Composer is as easy as this:

~~~bash
$ php composer.phar update
~~~

This will update all Composer-installed packages, apps, and themes to the latest release
based on the version specified in your `composer.json` file.
[Click here for more info about package versioning.](https://getcomposer.org/doc/01-basic-usage.md#package-versions)

Next: [[Developers / Sharing your apps]]