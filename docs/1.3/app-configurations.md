# App configurations

Configuration data for an app is contained in its `conf` folder. This can include general settings and also schemas and other data.

The main configurations used in your handlers should go in the `conf/config.php` file in your app, which should be formatted in INI format, like this:

	; <?php /*
	
	[Appname]
	
	setting_name = ""value""
	
	; */ ?>

## Accessing your settings

In any handler within your app, you can access the data in your `conf/config.php` file via the `$appconf` array made available through the controller. For example, to access the above value you would say:

	<?php
	
	echo $appconf['Appname']['setting_name'];
	
	?>

## [Admin] section

The [Admin] section of the `config.php` file is used to tell Elefant how an app should be included in the toolbar for site admins. It has the following settings:

	; The name of the app for the Tools menu
	name = Events
	
	; The handler to call when the Tools > Events link is clicked
	handler = events/admin
	
	; The version number of the app
	version = 0.9-beta
	
	; The handler to call to run any install routines
	install = events/install
	
	; The handler to call to run any upgrade routines
	upgrade = events/upgrade

## Section names

The sections are used to organize your settings, and other than [Admin] they are completely up to you.