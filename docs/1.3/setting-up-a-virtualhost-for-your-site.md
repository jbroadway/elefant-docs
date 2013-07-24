# Setting up a Virtualhost for your site

To set up a Virtualhost for Elefant development on your desktop, you can use the following steps:

## Mac OS X

1. Create a folder for the site in your `Sites` folder. Let's call it `mytestsite`.

2. Edit the file `/etc/hosts` and add this line:

~~~
127.0.0.1 www.mytestsite.lo
~~~

> **Note:** `.lo` represents a local site in this example. It's a simple convention that helps you quickly see that you're on your local development machine.

3. Edit your Apache configuration (`/etc/apache2/users/me.conf` where `me` is your username) and add:

~~~
NameVirtualHost www.mytestsite.lo

<VirtualHost www.mytestsite.lo>
    DocumentRoot /Users/me/Sites/mytestsite
    ServerName www.mytestsite.lo
</VirtualHost>
~~~

4. Restart Apache

~~~
sudo apachectl restart
~~~

You should now be able to go to `http://www.mytestsite.lo/` and see an empty Apache site directory if all went well.

## Windows

This assumes you've installed Apache, PHP, and MySQL via the [WAMP](http://www.wampserver.com/en/) server platform.

1. Create a folder for the site in your `C:wampwww` folder. Let's call it `mytestsite`.

2. Edit the file `C:WINDOWSsystem32driversetchosts` and add this line:

	127.0.0.1 www.mytestsite.lo

> **Note:** `.lo` represents a local site in this example. It's a simple convention that helps you quickly see that you're on your local development machine.

3. Edit your Apache configuration and uncomment this line (remove the `#` to uncomment):

	#Include conf/extra/httpd-vhosts.conf

Now open the file `C:wampinpacheApache2.2.21confextrahttpd-vhosts.conf` and add:

~~~
NameVirtualHost www.mytestsite.lo

<VirtualHost www.mytestsite.lo>
    DocumentRoot ""C:/wamp/www/mytestsite""""
    ServerName www.mytestsite.lo
</VirtualHost>
~~~

4. Restart Apache via the WAMP menu.

You should now be able to go to `http://www.mytestsite.lo/` and see an empty Apache site directory if all went well.
