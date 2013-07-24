# Installing on PHPCloud

This tutorial will walk you through installing Elefant on Zend's new [PHPCloud.com](http://www.phpcloud.com/) cloud hosting service.

> Note that PHPCloud.com is still a technology preview, so things may change and cause this to need updating. If you see anything that needs updating here, please post a message to the [Elefant forum](http://www.elefantcms.com/forum/).

## 1. Sign up

Here are a few prerequisites you'll need before you can start deploying Elefant to PHPCloud.com:

1. [Install Git](http://git-scm.com/)
2. Sign up at [PHPCloud.com](http://www.phpcloud.com/) (currently in invite-only beta, but I got an invite fairly quickly and may have spare invites to give out too if you message me)
3. On PHPCloud.com, import or generate an access key under `My Account > Access Keys`

Now you're ready to get started.

## 2. Create a container

In the PHPCloud.com admin area, click on `My Containers` then `Create Container`. Enter a name and choose a password for your container, then click `Create Container`. The website will then take a few moments to create a new site container for you at the URL `http://mycontainername.my.phpcloud.com/`.

In the container, you'll see a `Default Application` under the list of `Deployed Applications`. It should have a `git access` button that lets you copy a link to your new site's Git repository. You'll need this link in the next step.

## 3. Setting up the repository

### Git setup

Create a folder and initialize a new Git repository in it as follows:

~~~
$ mkdir myelefanttest
$ cd myelefanttest
$ git init
$ git remote add phpcloud https://myelefanttest@myelefanttest.my.phpcloud.com/git/container-root.git
$ git pull phpcloud master
~~~

> Note that the URL of the remote repository is the one from step 2. Adjust your command as necessary.

It will prompt you to enter your password, then download a `public` folder into your new repository with a single `default-container-index.html` file in it.

### Including the Elefant sources

Next, download the latest copy of Elefant from http://github.com/jbroadway/elefant/downloads and unzip it to your `myelefanttest` folder. You should now have a `public` and an `elefant-0.9.14-rc` folder inside your repository.

Now on the command line again, enter the following:

~~~
$ cp -R elefant-0.9.14-rc/* public/
$ git rm public/default-container-index.html
$ git add public/*
$ git commit -m ""Initial import of Elefant codebase"" public
~~~

Now we are ready to configure our database and site settings so we can deploy our new website.

## 4. Create the database

### Install the schema

Under `Management > Database Management`, you'll see a link to `Manage your database using phpMyAdmin`. Click the link to open phpMyAdmin, then select your database from the left column.

Now go to the `Import` tab and import the MySQL database schema from Elefant's `conf/install_mysql.sql` file. phpMyAdmin's default import settings should work fine.

### Create an admin account

First, we need to generate an encrypted password for our admin user. We can do this with the following command in Elefant:

~~~
$ cd public
$ ./conf/elefant encrypt-password ""your password""
$ cd ..
~~~

Copy the output for the next step.

Click on the `user` table in the left column then the `Insert` tab. Enter the following into the form:

~~~
id		-> Value = leave blank
email		-> Value = your email address
password	-> Value = the encrypted password
expires		-> Function = CURDATE
name		-> Value = your name
type		-> Value = ""admin""
signed_up	-> Function = CURDATE
updated		-> Function = CURDATE
userdata	-> Value = ""[]""
~~~

Click 'Go' to create your admin user.

## 5. Configure the site

### Database settings

Now it's time to connect the pieces. Instead of adding our database connection info to `public/conf/config.php` like an ordinary site, we're going to add a few lines to `public/index.php` to retrieve them using `get_cfg_var()`. At line 50 of the file, add the following code:

~~~
$conf['Database']['driver'] = 'mysql';
$conf['Database']['host'] = get_cfg_var ('zend_developer_cloud.db.host');
$conf['Database']['name'] = get_cfg_var ('zend_developer_cloud.db.name');
$conf['Database']['user'] = get_cfg_var ('zend_developer_cloud.db.username');
$conf['Database']['pass'] = get_cfg_var ('zend_developer_cloud.db.password');
~~~

This is the recommended way of accessing your database connection settings on PHPCloud.

> Note for Elefant 1.1+ users, the `$conf['Database']['driver']` references all becomes `$conf['Database']['master']['driver']`.

### Rewrite rules

In step 3, I didn't mention but we didn't copy the default Elefant `.htaccess` file into our `public` folder. Instead, we're going to use the one provided by Zend in the [PHPCloud documentation](https://my.phpcloud.com/help/adding-rewrite-rules-to-your-application). Create a `public/.htaccess` file with the following contents:

~~~
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} -s [OR]
RewriteCond %{REQUEST_FILENAME} -l [OR]
RewriteCond %{REQUEST_FILENAME} -d
RewriteBase /
RewriteRule ^.*$ - [NC,L]
RewriteRule ^.*$ index.php [NC,L]
php_flag zend_codetracing.trace_enable on
php_flag zend_codetracing.always_dump on
~~~

### Disabling Elefant's web installer

One last step for good measures is to tell Elefant that the installer has been run (even if technically it hasn't). To do this, simply create a blank file named `installed` in the `public/install` folder:

~~~
$ touch public/install/installed
~~~

## 6. Deploy!

### Committing our changes

Lets commit the changes we've made so we can deploy our site:

~~~
$ git add public/.htaccess public/install/installed
$ git commit -m ""Added phpcloud configurations"" public
~~~

### Deployment

In order to deploy through Git, I had to edit my `.git/config` file and add the following to increase its buffer size:

~~~
[http]
	postBuffer = 524288000
~~~

After that change, deploying our site is now just a single command from inside our repository:

~~~
$ git push phpcloud master
~~~

Enter your password and when Git has finished updating the remote repository, you should see your new site running at http://myelefanttest.my.phpcloud.com/

To make changes to your site such as customizing your layout and CSS, simply commit them using Git then run the above command to deploy them to your live site.

You can now log in at http://myelefanttest.my.phpcloud.com/admin with your email and password from step 4 to begin editing your site.