# Making your own apps

An app is a collection of files that perform a common set of functionality. Elefant itself is written as a series of apps on top of the base framework.

Elefant's apps have the following folder structure:

	apps/
		myapp/
			conf/                                # configurations
				acl.php
				cli.php
				config.php
				embed.php
				fields.php
				helpers.php
				install_mysql.sql
				install_pgsql.sql
				install_sqlite.sql
				payments.php
			css/                                 # custom stylesheets
				myapp.css
			elefant.json
			forms/                               # form validations
				update.php
			handlers/                            # request handlers (aka controllers)
				index.php
				update.php
			js/                                  # custom javascript
				myapp.js
			lib/                                 # class libraries
				Class.php
			models/                              # data models
				Model.php
			views/                               # view templates
				index.html
				update.html

Each app has its own sub-folder inside the `apps` folder. Each part of the app is optional, so you only need to create the parts that are necessary for the functionality you're building.

For example, if your app is just a couple classes, then you would only need a `lib` folder (of course, then you may as well make them usable by other projects and distribute them through [Packagist](https://packagist.org/)). Or if your app only needs a single handler script, then you only need a `handlers` folder with your handler in it.

## Generating your app scaffolding

You can use the following command to generate a base scaffold for a new app:

~~~bash
./elefant build-app myapp
~~~

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

## Configuration files {#configuration-files}

### `acl.php`

The ACL file lists any custom resources your app should add to Elefant's user roles, for example:

~~~ini
; <?php /*

designer = "Edit design themes"
designer/installer = "Install new apps/themes"

; */ ?>
~~~

### `cli.php`

The CLI file lists any handlers that should be run from the command line. These are added to the `./elefant` command's list of extended commands. For example:

~~~ini
; <?php /*

commands[resque/run] = Start running the Resque workers

; */ ?>
~~~

### `config.php`

The config file stores the custom configuration options for your app, as well as an `[Admin]` section that Elefant uses to include apps in the Tools menu. Your configuration options here are available anywhere via `Appconf::get ('myapp', 'Section', 'setting')`.

See [[:App Configurations]] for more information on the config file options.

### `embed.php`

The embed file lists handlers that you want to include in the [[User Manual / Dynamic Objects]] menu of the WYSIWYG editor. Since dynamic objects can specify input parameters, we use INI section blocks named after the handlers with the parameters listed below, for example:

~~~ini
; <?php /*

[blog/rssviewer]

label = "Blog: RSS Viewer"
icon = rss

url[label] = RSS Link
url[type] = text
url[not empty] = 1
url[regex] = "|^http://.+$|"
url[message] = Please enter a valid URL.

; */ ?>
~~~

Input parameter settings include:

* `callback` - A PHP function or method to call to retrieve a list of values for select fields.
* `initial` - The initial value to default to.
* `filter` - A PHP function or method call to filter the value entered before it is added to the embed code. Filters should take the value itself and a second `$reverse` parameter so that they can reverse the filter to return the original value. This way the original value can be edited again.
* `label` - The text to display to the user.
* `message` - The validation error message to display to the user.
* `require` - A PHP library file to include for a callback function or method.
* `type` - The input field type. Supported types currently include `file`, `select`, `text`, and `textarea`.
* `values` - A comma-separated list of values for select fields.

Additional settings are interpreted as [[:input validation]] rules.

### `helpers.php`

The helpers file lists any handlers that you wish to denote as helpers to be used by other developers in their own apps. These will be listed when a user runs the `./elefant list-helpers` command. For example:

~~~ini
; <?php /*

user/login = 1
user/sidebar = 1
user/util/userchooser = 1

; */ ?>
~~~

### `install_*.sql`

These contain the initial database schema for your app's models. Alternately, you can use the [Database Migrations](https://github.com/jbroadway/migrate) app to create and manage your schemas.

### `payments.php`

The payments file lists any handlers that adheres to Elefant's [payment processing interface](https://github.com/jbroadway/stripe#creating-a-member-payment-or-subscription-form), which allows your app to act as a payment processor for other apps. For example:

~~~ini
; <?php /*

stripe/payment = "Stripe Payments"

; */ ?>
~~~

Next: [[:Request-response cycle]]