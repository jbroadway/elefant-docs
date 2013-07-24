# Multisite setup

Elefant 2 can be made to run as a multisite setup, where each site has its own database, configurations, upload folder, etc, but share a common document root folder.

Note that no data or users are shared between the sites except the Elefant source itself, and any layouts and apps that you have installed.

This is possible through dynamically setting the [ELEFANT_ENV](http://www.elefantcms.com/wiki/Setting-up-dev,-staging,-production-environments) environment variable. In your Apache VirtualHost block, add a `SetEnvIf` line as follows:

	NameVirtualHost www.mainsite.com
	
	<VirtualHost www.mainsite.com>
	    DocumentRoot /var/www
	    ServerName www.mainsite.com
	    ServerAlias www.site2.com www.site3.com
	    SetEnvIf Host ^www.(.*).com$ ELEFANT_ENV=$1
	</VirtualHost>

This tells Elefant to load an alternate config file for each site (e.g., `conf/mainsite.php`, `conf/site2.php`, `conf/site3.php`) to override the main `conf/config.php` settings.

The next step is to duplicate `conf/config.php` to create the alternate config files.

When editing a site's custom config file, here are the settings you'll want to customize:

	site_name = ""Site2 Inc.""
	email_from = ""joe@site2.com""
	default_layout = ""site2""
	navigation_json = ""conf/navigation.site2.json""
	filemanager_path = ""files/site2""
	access_control_list = ""conf/acl.site2.php""
	master[file] = ""conf/site2.db""

Note that you will need to create the alternate files and folders that you point the settings to.

You will also want to restrict individual site admins from accessing certain features, such as installing new apps or modifying themes, since those files are still shared between the sites. Here is a sample admin role that will work for this:

	; <?php /*
	
	[admin]
	
	default = On
	designer = Off
	translator = Off
	
	; */ ?>

You should now have a working multisite setup using a single Elefant installation.