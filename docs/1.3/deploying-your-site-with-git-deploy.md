# Deploying your site with git deploy

This tutorial will walk you through all the steps to configuring your Elefant-powered website for automated deployments using [git-deploy](https://github.com/mislav/git-deploy), a git-based deployment tool.

Please note that this tutorial assumes you're on a Unix-based desktop such as Mac OS X or Linux, and that you're deploying to a Unix-based server as well.

## 1. Setting up SSH keys

On your workstation, enter the following command to generate a public/private key pair.

	$ ssh-keygen -t dsa

> Note: Leave the passphrase empty if you'd like to deploy without re-entering a passphrase each time.

Now enter the following command to transfer your new public key to the server. You'll need to change the user and server name.

	$ scp ~/.ssh/id_rsa.pub user@example.com:.ssh/authorized_keys2

The final step is to SSH into the server and notify SSH about your new public key. Use the following commands for this:

	$ ssh user@example.com
	$ ssh-agent sh -c 'ssh-add < /dev/null && bash'

To test that it worked, exit from the SSH server connection and then SSH into it again. This time, the SSH command should connect you without asking for your password (unless you set a passphrase when you generated your SSH keys).

	$ exit
	$ ssh user@example.com

## 2. Setting up your project folder

Because we're deploying with git, we want to make sure our `.git` folder is outside of our website document root. So we're going to set up a project structure that looks like this:

	project_name
		.git
		.gitignore
		www		<-- website files go here

You can quickly set this up with the following commands:

	$ mkdir project_name
	$ cd project_name
	$ wget https://github.com/downloads/jbroadway/elefant/elefant-1.1.4-beta.tar.gz
	$ tar -zxf elefant-1.1.4-beta.tar.gz
	$ rm elefant-1.1.4-beta.tar.gz
	$ mv elefant-1.1.4-beta www

> Note: The latest download link is always available at [http://www.elefantcms.com/download](http://www.elefantcms.com/download).

Now we just have to create our initial import of the project into git: 

	$ git init
	$ git add .
	$ git commit -m ""Initial import"" .

## 3. Setting up multiple configurations

Your database connection information will likely be different on your workstation and your live server. Elefant checks for an `ELEFANT_ENV` environment variable and loads the configuration file specified in it, defaulting to `config.php`.

First, duplicate your `www/conf/config.php` and name it `www/conf/production.php`. Now edit `www/conf/production.php` and enter your live server's database information.

Next, you'll need to edit your live server's Apache configuration and add this line:

	SetEnv ELEFANT_ENV production

Restart Apache and Elefant will now load the correct configuration for each machine. You can repeat this for staging and test servers as well to load different configurations like enabling/disabling debugging, etc.

## 4. Setting up git-deploy

To install git-deploy, enter the following:

	$ gem install git-deploy

> Note that you'll need [gem](http://rubygems.org/) installed locally, and [git](http://git-scm.com/) and [ruby](http://www.ruby-lang.org/en/) installed both locally and on your live server for this step.

Now we're going to add our live server as a remote git repository that we'll be pushing updates to. I'm calling the server `production` but you can call it anything you want.

	$ git remote add production user@example.com:/path/to/your/site

The target directory in the above command should correspond to the directory your web server is looking for. For example, if your site is going to be in `/home/user/sitename/www` then the above path would be `/home/user/sitename`.

Next, run the setup task to initialize the remote git repository in the target directory that you specified in the above command.

	$ git deploy setup -r production

Now we're going to initialize the repository itself which will create default deploy callback scripts in a new `deploy` directory that we'll add to our project.

	$ git deploy init
	$ git add deploy
	$ git commit -m ""Added git-deploy default scripts"" deploy

And finally, we can now push updates to our live server with a single command:

	$ git push production master

Note that you may need to perform additional configuration on the server, such as configuring a virtual host in the web server settings.

## Additional Elefant setup tips

### Permissions

As you know, Elefant relies on certain directories being writeable by PHP. The only one you really need on the production server is the `cache` folder, which is used for caching rendered templates, since you'll be making all of your updates on your development copy and pushing them to the live server.

> Note: This does mean certain features of Elefant won't be used on your live server, including the Designer and Files apps. Instead, add your files and design changes to your local copy, commit them with git, and push them to the live site.

### Clearing the cache

If you're using the default caching and not Memcache, then it's a good idea to also clear the `www/cache` folder on new deployments.

### A word on the default deploy scripts

git-deploy's default scripts are written for Ruby-based websites, specifically the `deploy/before_restart` script. Below is an alternate `deploy/before_restart` that is better suited to an Elefant-powered website. It addresses the clearing of the cache and ensuring the correct permissions as per the two points above.

	#!/usr/bin/env ruby
	oldrev, newrev = ARGV
	
	def run(cmd)
	  exit($?.exitstatus) unless system ""umask 000 && #{cmd}""
	end
	
	run ""git clean -x -f -- www/cache""
	run ""chmod -R 777 www/cache""

> Note the change to the umask so that the chmod to `www/cache` will work properly. Even if you just add these lines to your own custom deploy scripts, make sure to change this as well.

### Need help?

If you're stuck on a step, [head over to the forum](/forum/) for help.
