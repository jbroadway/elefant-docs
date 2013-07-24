# Installing on DotCloud

This tutorial will walk you through installing Elefant on the
[DotCloud](http://www.dotcloud.com/) cloud hosting platform. DotCloud is a powerful platform for deploying web applications, and after the initial setup you will have a solid foundation for deploying Elefant-powered websites to the cloud.

> Note: This tutorial assumes some familiarity with the Unix command line.

## 1. Sign up

The first step is to register for a free DotCloud account and to install their [command line interface](http://docs.dotcloud.com/firststeps/install/).

## 2. DotCloud setup

Our DotCloud project is going to be structured like this:

	myproj/
		dotcloud.yml
		www/
			# elefant source
			bootstrap.php
			postinstall

> Note: You'll want to change references to `myproj` to be something unique.

First create the project's root folder, then create a `dotcloud.yml` file in it with the following contents:

	www:
	  type: php
	  approot: www
	db:
	  type: mysql

This tells DotCloud that we want two services, one for PHP and one for MySQL. Now download the latest Elefant release and unzip it into the project folder. Rename the Elefant folder to be named `www`.

On the command line you can use:

	wget https://github.com/downloads/jbroadway/elefant/elefant-1.2.0-stable.tar.gz
	tar -zxf elefant-1.2.0-stable.tar.gz
	rm elefant-1.2.0-stable.tar.gz
	mv elefant-1.2.0-stable www

From here, create a file named `postinstall` in the `www` folder with the following contents:

	#!/bin/sh
	
	if [ ! -e ~/current/cache ]
	then
		mkdir ~/current/cache
	fi
	
	umask 0000
	chmod    777 ~/current/apps
	chmod -R 777 ~/current/cache
	chmod -R 777 ~/current/conf
	chmod -R 777 ~/current/css
	chmod -R 777 ~/current/files
	chmod -R 777 ~/current/lang
	chmod -R 777 ~/current/layouts

Make sure this file is executable by running the following command:

	chmod +x www/postinstall

And lastly, we need to edit the `nginx.conf` file Elefant provides to work with DotCloud. It should look like this:

	location ^~ /conf/ {
		deny all;
		return 403;
	}
	location ~ ^/(cache|apps|tests)/.*.(php|sql)$ {
		deny all;
		return 403;
	}
	index index.php;
	try_files $uri $uri/ /index.php?$args;

We're now ready to configure the database and deploy the site.

## 3. Database setup

DotCloud provides you with the database connection info via way of a configuration file named `environment.json`. To pass this to Elefant, we will create a `bootstrap.php` file in our `www` folder like this:

	<?php
	
	$json = file_get_contents('/home/dotcloud/environment.json');
	$env = json_decode ($json, true);
	
	// Database connection info
	conf ('Database', 'master', array (
		'driver' => 'mysql',
		'host' => $env['DOTCLOUD_DB_MYSQL_HOST'] . ':' . $env['DOTCLOUD_DB_MYSQL_PORT'],
		'name' => 'myproj',
		'user' => $env['DOTCLOUD_DB_MYSQL_LOGIN'],
		'pass' => $env['DOTCLOUD_DB_MYSQL_PASSWORD']
	));
	
	?>

Elefant will read this file during its setup stage, parsing the `environment.json` file into an array and setting the database connection settings from there.

We also want to disable the web installer by adding a blank file named `installed` in the `www/conf` folder:

	touch www/conf/installed

We're now ready to create and push our DotCloud project, which will initialize MySQL. From there we'll create a MySQL database and import the Elefant schema.

To initialize the project, run:

	dotcloud create myproj
	dotcloud push myproj

The last line of the output of this command will be the URL you can view your project at on the web. If you visit it now, you'll see an error that the database doesn't exist yet.

Now run:

	dotcloud info myproj.db

This will print out the MySQL connection info. Use the root password from that output to connect to MySQL using the following line:

	dotcloud run myproj.db -- mysql -p -u root

Create the database with these lines:

	create database myproj;
	quit

Now from the database info that was output before, craft the following command to import the Elefant database schema:

	mysql -p -u root -h myproj-GMB6NTCD.dotcloud.com -P 20664 myproj < www/conf/install_mysql.sql

Now if you visit your project on the web you should see the default Elefant welcome page.

The last step is to visit the `/admin` URL on your new site and log in with the following info:

	email: you@example.com
	password: elefantrocks

Go to Tools > Users and edit your account to change your email and password. Save the changes and you're all done. To make changes to your site, simply edit your local files and do a `dotcloud push myproj` to push the changes to DotCloud.