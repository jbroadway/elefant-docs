# Setting up a hostname alias for your site

If you are developing on a workstation and referring to your website as `localhost` then please follow these steps to create a hostname alias for your site. This allows you to refer to your site with a name like `www.mywebsite.dev`.

Hostname aliases also have the benefit of making it possible to develop any number of websites on your local machine, instead of just the one, since you can refer to each by its own name.

On Linux and Mac OS X, edit the file `/etc/hosts`. On Windows, edit the file `C:\WINDOWS\system32\drivers\etc\hosts`. Add the following line:

	127.0.0.1 www.mywebsite.dev

You can now save and close the file. To add more sites, simply add new entries to this file, for example:

	127.0.0.1 www.mywebsite.dev
	127.0.0.1 www.anotherwebsite.dev
	127.0.0.1 www.petproject.dev

From here, you can create virtualhosts in your Apache or Nginx configuration that point to each of your virtual hostnames. For example:

	NameVirtualHost www.mywebsite.dev
	
	<VirtualHost www.mywebsite.dev>
		DocumentRoot "C:/wamp/www/mywebsite"
		ServerName www.mywebsite.dev
	</VirtualHost>

Remember to restart your web server in order to see changes you've made to it. You should now be able to access your website at `http://www.mywebsite.dev` instead of `http://localhost`.

Next: [[:Installation]]