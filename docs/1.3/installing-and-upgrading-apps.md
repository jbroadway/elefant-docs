# Installing and upgrading apps

Elefant has a simple, built-in way for apps to be installed and upgraded, which can also be used for easy database migrations. Here's how it works:

1. There is an `apps` table that manages the installed version of an app.

2. In the `[Admin]` block of an app's `conf/config.php` file, you can specify an `install` and `upgrade` handlers, and a version number, like this:

~~~
[Admin]

name = App Name
handler = myapp/admin
install = myapp/install
upgrade = myapp/upgrade
version = 1.0-stable
~~~

3. The Admin > Tools menu uses the above info to notify admins when new apps are found in the apps folder, and when app versions have been changed by overwriting an app with a new version. It will highlight the new app and add either `(click to install)` or `(click to upgrade)` to its menu item.

4. The controller has two methods for developers to use in their install and upgrade handlers:

	<?php
	
	$version = $this->installed ('appname', $appconf['Admin']['version']);
	
	?>

`$version` will be true if it's already installed, false if it hasn't been, or will contain the currently installed version number if a previous version has been installed.

	<?php
	
	$this->mark_installed ('appname', $appconf['Admin']['version']);
	
	?>

This will save the current version to the `apps` table so Elefant knows the app is now installed and current.

## Sample app

Here's a link to a sample app that makes use of the above features:

[http://github.com/jbroadway/installtest](http://github.com/jbroadway/installtest)

Developers can use this as an example or a template for your own install and upgrade handlers.