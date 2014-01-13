# Making your own apps

An app is a collection of files that perform a common set of functionality. Elefant itself is written as a series of apps on top of the base framework.

Elefant's apps have the following folder structure:

	apps/
		myapp/
			conf/
				acl.php
				cli.php
				config.php
				embed.php
				helpers.php
				install_mysql.sql
				install_pgsql.sql
				install_sqlite.sql
				payments.php
			css/
				myapp.css
			elefant.json
			forms/
				update.php
			handlers/
				index.php
				update.php
			js/
				myapp.js
			lib/
				Class.php
			models/
				Model.php
			views/
				index.html
				update.html

Each app has its own sub-folder inside the `apps` folder. Each part of the app is optional, so you only need to create the parts that are necessary for the functionality you're building.

For example, if your app is just a couple classes, then you would only need a `lib` folder (of course, then you may as well make them usable by other projects and distribute them through [Packagist](https://packagist.org/)). Or if your app only needs a single handler script, then you only need a `handlers` folder with your handler in it.

## Generating your app scaffolding

You can use the following command to generate a base scaffold for a new app:

	./elefant build-app myapp

This will create a new barebones app structure in `apps/myapp`.

## Classes and namespaces

Elefant's autoloader will try to resolve class names, with or without namespaces, against the global `lib` folder, the `lib` and `models` folders of apps, and the `lib/vendor` folder. This means namespaces are optional, however it is encouraged that you use your app's name as the namespace for classes and models that belong to your app. For example:

~~~php
<?php

namespace myapp;

class SomeClass {
}

?>
~~~

This keeps namespaces concise and makes it easy to find the source of any given class.

The autoloader will fall back to [PSR-0](http://www.php-fig.org/psr/psr-0/) style autoloading if no class matches via the first method, or any other autoloader such as [PSR-4](http://www.php-fig.org/psr/psr-4/) or another framework's autoloader.

## The `elefant.json` file

`elefant.json` is a JSON-formatted file that describes your app (name, version, author, etc.) for sharing with others. It describes your app so that Elefant's app/theme installer can verify and install your app onto someone else's website (see [[:Sharing your apps]]).

Next: [[:Request-response cycle]]