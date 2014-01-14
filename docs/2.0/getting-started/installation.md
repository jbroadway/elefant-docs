# Installation

--- Platform: Linux ---

## Prerequisites

See the [[:Requirements]] page for a list of server requirements.

We recommend using [Composer](http://getcomposer.org/), the PHP dependency
manager, as the best way to install Elefant. If you don't have Composer, you can
install it by running the following commands:

~~~bash
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
~~~

You will also need the following information to complete the installation process:

* The address of your website. For the examples below, we will refer to `www.example.com`. If you are using `localhost`, please see [[:setting up a hostname alias]].
* The root folder of your website, called the document root. For the examples below, we will refer to the folder `/var/www`.
* The name of the web server software you're using, usually Apache or Nginx.
* The connection info to your MySQL or PostgreSQL database (SQLite users don't need this).

## Getting started

**Step 1.** Brab the latest copy of Elefant using the following command:

~~~bash
composer create-project elefant/cms --stability=dev /var/www
~~~

> Note: The `--stability=dev` option is required until Elefant 2 is out of beta.

Be sure to adjust the path (`/var/www`) to point to the correct folder. This should
be your website's document root.

> Note: If you don't want to use Composer, you can always [download the latest release here](https://github.com/jbroadway/elefant/releases).

**Step 2.** Configure your web server according to the examples provided.

For Apache users, make sure the `mod_rewrite` extension and `htaccess` are enabled, and
make sure the `.htaccess` file is included in your document root folder.

For Nginx users, see the included `nginx.conf` for an example configuration.

**Step 3.** Set the file permissions using the following command:

~~~bash
./elefant permissions
~~~

> If you're using FTP and not SSH to connect to your site, right-click each folder listed
> above to set its permissions. Make sure to click the option that says something to the
> effect of "Also change permissions on files inside this folder."
> 
> For example in [Transmit](http://panic.com/transmit/) for Mac, right-click and choose
> "Get Info" then under "Permissions" check all of the boxes then click "Apply to enclosed items."
> 
> Using [FlashFXP](http://flashfxp.com/) on Windows, you would right-click the folders
> and choose "Attributes (CHMOD)", check off all the boxes, then click "Apply changes
> recursively to sub-folders and files".

### Sub-folder installations

To run Elefant in a sub-folder instead of the root folder of a website, you need two additional
files not included in the default install. [You can download these here](http://gist.github.com/1558300).

The `.htaccess` file replaces the default one, and the `subfolder.php` should be placed in
your document root folder. Once these files are in place, skip to the alternate command line
installer steps below.

> Elefant always assumes its running in the document root of a website, which provides two
> benefits: 1) No URL prefixes to add to templates, and 2) helps Elefant optimize for greater
> speed. The sub-folder script is a small proxy that enables Elefant to run transparently
> in sub-folders too, but requires this extra step during the installation process.

### Web installer

**Step 4.** Go to `http://www.example.com/install` on your website to run the web-based
installer.

This will guide you through the rest of the setup process.

### Alternate command-line installer

**Step 4.** Edit `conf/config.php` and add your database connection information.

**Step 5.** Run the following command to complete the installation:

~~~bash
./elefant install
~~~

This will generate a username and password for you to log into the admin area.

You should now have a working Elefant-powered website!

--- Platform: Mac ---

## Prerequisites

See the [[:Requirements]] page for a list of server requirements.

We recommend using [Composer](http://getcomposer.org/), the PHP dependency
manager, as the best way to install Elefant. If you don't have Composer, you can
install it by running the following commands:

~~~bash
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
~~~

You will also need the following information to complete the installation process:

* The address of your website. For the examples below, we will refer to `www.example.com`. If you are using `localhost`, please see [[:setting up a hostname alias]].
* The root folder of your website, called the document root. For the examples below, we will refer to the folder `/var/www`.
* The name of the web server software you're using, usually Apache or Nginx.
* The connection info to your MySQL or PostgreSQL database (SQLite users don't need this).

## Getting started

**Step 1.** Brab the latest copy of Elefant using the following command:

~~~bash
composer create-project elefant/cms --stability=dev /var/www
~~~

> Note: The `--stability=dev` option is required until Elefant 2 is out of beta.

Be sure to adjust the path (`/var/www`) to point to the correct folder. This should
be your website's document root.

> Note: If you don't want to use Composer, you can always [download the latest release here](https://github.com/jbroadway/elefant/releases).

**Step 2.** Configure your web server according to the examples provided.

For Apache users, make sure the `mod_rewrite` extension and `htaccess` are enabled, and
make sure the `.htaccess` file is included in your document root folder.

For Nginx users, see the included `nginx.conf` for an example configuration.

**Step 3.** Set the file permissions using the following command:

~~~bash
./elefant permissions
~~~

### Sub-folder installations

To run Elefant in a sub-folder instead of the root folder of a website, you need two additional
files not included in the default install. [You can download these here](http://gist.github.com/1558300).

The `.htaccess` file replaces the default one, and the `subfolder.php` should be placed in
your document root folder. Once these files are in place, skip to the alternate command line
installer steps below.

> Elefant always assumes its running in the document root of a website, which provides two
> benefits: 1) No URL prefixes to add to templates, and 2) helps Elefant optimize for greater
> speed. The sub-folder script is a small proxy that enables Elefant to run transparently
> in sub-folders too, but requires this extra step during the installation process.

### Web installer

**Step 4.** Go to `http://www.example.com/install` on your website to run the web-based
installer.

This will guide you through the rest of the setup process.

### Alternate command-line installer

**Step 4.** Edit `conf/config.php` and add your database connection information.

**Step 5.** Run the following command to complete the installation:

~~~bash
./elefant install
~~~

This will generate a username and password for you to log into the admin area.

You should now have a working Elefant-powered website!

--- Platform: Windows ---

## Prerequisites

See the [[:Requirements]] page for a list of server requirements.

We recommend using [Composer](http://getcomposer.org/), the PHP dependency
manager, as the best way to install Elefant. If you don't have Composer, [here
are the steps](http://getcomposer.org/doc/00-intro.md#installation-windows)
to install Composer on Windows.

You will also need the following information to complete the installation process:

* The address of your website. For the examples below, we will refer to `www.example.com`. If you are using `localhost`, please see [[:setting up a hostname alias]].
* The root folder of your website, called the document root. For the examples below, we will refer to the folder `C:\wamp\www`.
* The name of the web server software you're using, usually Apache or Nginx.
* The connection info to your MySQL or PostgreSQL database (SQLite users don't need this).

## Getting started

**Step 1.** Brab the latest copy of Elefant using the following command:

~~~bash
composer create-project elefant/cms --stability=dev C:\wamp\www
~~~

> Note: The `--stability=dev` option is required until Elefant 2 is out of beta.

Be sure to adjust the path (`C:\wamp\www`) to point to the correct folder. This should
be your website's document root.

> Note: If you don't want to use Composer, you can always [download the latest release here](https://github.com/jbroadway/elefant/releases).

**Step 2.** Configure your web server according to the examples provided.

For Apache users, make sure the `mod_rewrite` extension and `htaccess` are enabled, and
make sure the `.htaccess` file is included in your document root folder.

For Nginx users, see the included `nginx.conf` for an example configuration.

### Sub-folder installations

To run Elefant in a sub-folder instead of the root folder of a website, you need two additional
files not included in the default install. [You can download these here](http://gist.github.com/1558300).

The `.htaccess` file replaces the default one, and the `subfolder.php` should be placed in
your document root folder. Once these files are in place, skip to the alternate command line
installer steps below.

> Elefant always assumes its running in the document root of a website, which provides two
> benefits: 1) No URL prefixes to add to templates, and 2) helps Elefant optimize for greater
> speed. The sub-folder script is a small proxy that enables Elefant to run transparently
> in sub-folders too, but requires this extra step during the installation process.

### Web installer

**Step 3.** Go to `http://www.example.com/install` on your website to run the web-based
installer.

This will guide you through the rest of the setup process.

### Alternate command-line installer

**Step 3.** For Windows users installing in a sub-folder instead of a vhost, instead of running
the `./elefant install` command, follow these steps:

1. Open the file `conf/install_mysql.sql` in a text editor.
2. Search & replace `#prefix#` with `elefant_` which is the default database prefix.
3. Paste the edited database schema into phpMyAdmin from your WAMP install.

The default admin username will be the email address from the `from_email` setting in
`conf/config.php` and the default admin password will be `elefantrocks`. Be sure to
change this under Tools > Users once you log into your new site.

You should now have a working Elefant-powered website!

--- /Platform ---

Next: [[:File permissions]]