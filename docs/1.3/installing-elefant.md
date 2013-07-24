# Installing Elefant

This page will guide you through the steps to install Elefant on your workstation or web server. There are many different possible configurations, but the install process is straight-forward in most cases.

## Prerequisites

You will need an [Apache](http://httpd.apache.org/) or [Nginx](http://nginx.org/) web server, [PHP 5.3+](http://www.php.net/), and one of the supported databases. [SQLite](http://sqlite.org/) is bundled with PHP, and Elefant also supports [MySQL](http://mysql.com/) and [PostgreSQL](http://www.postgresql.org/).

For Windows users, we recommend using [WAMP](http://www.wampserver.com/en/) to install and configure Apache, PHP, and MySQL for you. Make sure to also enable mod_rewrite in the Apache configuration.

Mac OS X users simply need to install MySQL, since Mac OS X ships with Apache and PHP already. For Linux, we recommend using your distribution's package management system to install these.

For local development, we also recommend [[Setting up a Virtualhost for your site]], which makes it easier to develop multiple projects on your machine at the same time and keep them organized.

## Getting started

**Step 1.** [Download the latest release](/download) and unzip it. Move the files into your website folder.

**Step 2.** If you're using the Apache web server, make sure you copy the `.htaccess` file from the download as well. If you don't see it in the folder, you can [download a copy from here](https://raw.github.com/jbroadway/elefant/master/.htaccess) (if you're unsure, copy it anyway to be safe).

If you're using Nginx, see the included `nginx.conf` for an example configuration.

**Step 3.** Change the permissions on the `cache`, `conf`, `css`, `files`, `install`, `lang`, and `layouts` folders and the files in them to be writeable by PHP. First, try setting them to 0755 and see if that works, then try 0775, then finally 0777 (for more info about file permissions, see [[File permissions]]). Set the `apps` folder (this time not recursively) to the same setting as well.

The permission levels can be different on different hosts, so it's best to try the lesser permissions first and increase them only if needed.

> If you're using the command-line, use the following commands:

	$ cd /path/to/your/site
	$ chmod -R 755 cache conf css files install lang layouts
	$ chmod 755 apps

> Or if you're using FTP, right-click each folder to set its permissions. Make sure to click the option that says something to the effect of ""Also change permissions on files inside this folder.""

> For example in [Transmit](http://panic.com/transmit/) on the Mac, right-click the folders and choose ""Get Info"", then under ""Permissions"" check off all the boxes, then click ""Apply to enclosed items.""

> Using [FlashFXP](http://flashfxp.com/) on Windows, you would right-click the folders and choose ""Attributes (CHMOD)"", check off all the boxes, then click ""Apply changes recursively to sub-folders and files"".

### Sub-folder installations

To run Elefant in a sub-folder instead of the root folder of a website, you need two additional files not included in the default install. You can [download these here.](http://gist.github.com/1558300)

The `.htaccess` replaces the default one, and the `subfolder.php` should sit next to the `index.php` in Elefant's root folder.

Once you've added these, skip to the alternate command-line installer steps below. For more info about sub-folder installations, see [this forum thread.](http://www.elefantcms.com/forum/discussion/26/subfolder-installation-support/p1)

> Elefant assumes it is running in the root of a web site, but the subfolder proxy provides a small wrapper around Elefant's front controller that enables it to run transparently in sub-folders too. This is an extra step during the install, but provides two benefits: 1) No URL prefixes to add to your templates, and 2) this helps optimize Elefant for greater speed for sites that need it.

## Web installer

**Step 4.** Go to `/install/` on your site to run the web-based installer. This will guide you through the rest of the process.

## Alternate command-line installer

**Step 4.** Edit `conf/config.php` and add your database connection info and default site info.

**Step 5.** Run the command `./elefant install` to create the default database tables for the built-in apps. This will generate a username and password for you to log into the admin area.

> For Windows users installing in a sub-folder instead of a vhost, instead of running the `./elefant install` command, open the file `conf/install_mysql.sql` in a text editor and do a search & replace for `#prefix#`, replacing it with the database prefix setting in your `conf/config.php` file (default is `elefant_`). Now paste the edited schema into phpMyAdmin from your WAMP install.

>The default admin username will be the email address in the `from_email` setting in `conf/config.php` and the default admin password will be `elefantrocks`. Be sure to change this under Tools > Users once you log into your new site.

You should now have a working Elefant-powered website!

Next: [[User Manual]]