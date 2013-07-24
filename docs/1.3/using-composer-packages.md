# Using Composer packages

Using [Composer](http://getcomposer.org/) and [Packagist](http://packagist.org/), PHP's dependency manager and package library, you can install any Elefant apps and themes, as well as third party libraries.

You can even install Elefant itself via:

	php composer.phar create-project elefant/cms --stability=dev /var/www

> Note: The `--stability=dev` is required while Elefant 2 is still in beta.

To use Composer to install packages in your Elefant website, here are the steps you need to do:

1. Create a `composer.json` file in the root of your site with a custom `vendor-dir` pointing to `lib/vendor`:

	{
		""require"": {
			""merk/Dough"": ""*"",
			""elefant/app-assetic"": ""*"",
			""elefant/app-form"": ""*"",
			""elefant/theme-montreal"": ""*""
		},
		""config"": {
			""vendor-dir"": ""lib/vendor""
		}
	}

The above example will install the `merck/Dough` library, as well as the [Assetic](https://github.com/jbroadway/assetic) and [Form Builder](https://github.com/jbroadway/form) apps and the [Montreal theme](https://github.com/jbroadway/montreal) for Elefant. Apps are automatically installed into the `apps/` folder, and themes into the `layouts/` folder. Third party libraries will be available under `lib/vendor/`.

2. To use third party libraries, you'll need to require the Composer autoloader. Create a file named `bootstrap.php` in the root of your site and add this line:

	<?php
	
	require 'lib/vendor/autoload.php';
	
	?>

3. Run the Composer install from the command line:

	$ cd /path/to/your/site
	$ php composer.phar install

You should now be able to use any Composer package in your apps, complete with autoloading. For example:

	<?php // apps/test/handlers/test.php
	
	use DoughMoneyMoney;
	
	$money = new Money (5.75);
	$money = $money->times (1.12);
	echo $money->getAmount ();
	
	?>

Simply edit the `require` list in `composer.json` to add new packages you want to use, then run `php composer.phar update` to update your libraries, apps, and themes.

> [Click here for a full list of Elefant's apps and themes available through Composer.](http://packagist.org/packages/elefant/)