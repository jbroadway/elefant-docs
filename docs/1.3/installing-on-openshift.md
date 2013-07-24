# Installing on OpenShift

This tutorial will guide you through installing Elefant on RedHat's [OpenShift](https://openshift.redhat.com/) cloud platform.

Prerequisites:

* [Git](http://git-scm.com/) version control system
* Comfortable with the command line

### First steps

First, sign up for OpenShift at [https://openshift.redhat.com/](https://openshift.redhat.com/) and create a new PHP 5.3 application in their management console. Choose any name and namespace you wish. The examples here will use `example` for the application name and `elefant` as the namespace.

Next, install the `rhc` command line client. On Mac OS X, run these commands in a Terminal window:

	sudo gem install json_pure
	sudo gem install rhc

For other platforms, see [https://openshift.redhat.com/app/getting_started](https://openshift.redhat.com/app/getting_started)

### SSH Keys

To generate an SSH key pair, run this command:

	ssh-keygen

Copy the contents of `~/.ssh/id_rsa.pub` and paste them into the
public key setting in the OpenShift management console.

### Repository setup

Clone your new application's Git repository to your local machine by pasting the command from their management console into your command line:

	git clone ssh://a1b2c3d4e5f6@example-elefant.rhcloud.com/~/git/example.git/

Now we're going to fetch the Elefant sources and add them to
the `php` folder like this:

	cd example
	git clone git://github.com/jbroadway/elefant.git
	mv elefant/.htaccess php
	mv elefant/* php/
	rm -rf elefant

### Database setup

To add a MySQL database to your application, run this command:

	rhc app cartridge add -a example -c mysql-5.1

We're also going to add phpMyAdmin, which we'll use to create our database schema:

	rhc app cartridge add -a example -c phpmyadmin-3.4

With the MySQL connection info OpenShift provides you, log into phpMyAdmin and upload the file `php/conf/install_mysql.sql` under the Import tab.

Now create a new PHP file named `bootstrap.php` in the `php` folder with the following:

	<?php
	
	conf ('Database', 'master', array (
		'driver' => 'mysql',
		'host' => $_ENV['OPENSHIFT_DB_HOST'] . ':' . $_ENV['OPENSHIFT_DB_PORT'],
		'name' => $_ENV['OPENSHIFT_APP_NAME'],
		'user' => $_ENV['OPENSHIFT_DB_USERNAME'],
		'pass' => $_ENV['OPENSHIFT_DB_PASSWORD']
	));
	
	?>

This will dynamically load MySQL's connection settings into Elefant without hard-coding them in its configuration file. And finally, we're going to disable the Elefant web installer with the following command:

	touch php/conf/installed

This tells Elefant the installer has already been run.

### Committing and pushing

To update our OpenShift website, we'll need to add all of our changes
to Git and commit them, then push them to the server. We can do that
like this:

	git add .
	git commit -m ""Added Elefant sources"" .
	git push

Now if you load your application in a new browser window, you should
see the Elefant default homepage. Visit `/admin` to log in and edit your new site.

Your default admin username and password are:

* you@example.com
* elefantrocks

Once you log in, you can change these under the Tools > Users screen. You're now completely up and running with a new Elefant-powered site on the OpenShift cloud. Enjoy!