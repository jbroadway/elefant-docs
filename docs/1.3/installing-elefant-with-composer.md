# Installing Elefant with Composer

Using [Composer](http://getcomposer.org/), PHP's dependency manager and package library, you can install Elefant with the following command:

	php composer.phar create-project elefant/cms --stability=dev /var/www

> Note: The `--stability=dev` is required while Elefant 2 is still in beta.

You can then continue to use Composer to keep Elefant up-to-date via:

	php composer.phar update

For instructions on installing Elefant apps and themes via Composer, see [[Using Composer packages]].