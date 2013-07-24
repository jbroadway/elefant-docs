# Installing on AppFog

## Notice

This page hasn't been updated since AppFog consolidated their PHP Fog service into their main AppFog platform, but the instructions below should be nearly the same.

***

<!--
> **Great News:** [PHP Fog](https://phpfog.com/?a_aid=18859164) now supports Elefant as an automatic install option (or *JumpStart* in PHP Fog lingo). Simply sign up for free and select Elefant from the list of supported frameworks. You'll have a new Elefant website in minutes!

***
-->

This tutorial will walk you through installing Elefant on [PHP Fog](https://phpfog.com/?a_aid=18859164)'s
cloud hosting platform. PHP Fog is both a cool new platform for custom PHP development,
and a good way to try out Elefant using their 1 free shared instance offer.

## 1. Sign up

Here are a few prerequisites you'll need before you can start deploying Elefant
to your PHP Fog instance:

1. [Install Git](http://help.phpfog.com/faqs/git/what-git-is-and-how-to-use-it)
2. Sign up at [PHP Fog](https://phpfog.com/?a_aid=18859164)
3. Under My Account > SSH Keys, add your [SSH public key](http://docs.phpfog.com/index.php/features/article/generating_a_ssh_key)

Now you're ready to create a new cloud instance and get started.

## 2. Create your cloud

Go to My Account > Clouds and click on New Cloud. Give it a name. For our purposes, I'll refer to
it here as `elefantcms` and I'll use the domain name `elefantcms.phpfogapp.com` to refer to it.

Open a command line terminal in another window, then select your cloud instance on the PHP Fog site
and click on the Source Code tab. Copy and paste the `git clone` line there into your terminal
and press Enter:

~~~
$ git clone git@git01.phpfog.com:elefantcms.phpfogapp.com
~~~

It may ask you if you are sure you want to continue connecting. Type 'yes'. Once it's done, type `ls`
and you should see a new folder named `elefantcms.phpfogapp.com`. Next, change into the new folder:

~~~
$ cd elefantcms.phpfogapp.com
~~~

Type `ls` again and you should see one file present here, `index.php`. This folder is the place you'll
put your files to deploy them to PHP Fog. You'll use the following command to upload your changes to
the server:

~~~
git push origin master
~~~

> Note: At this point, you can also view your site in your browser at http://elefantcms.phpfogapp.com/

## 3. Download and configure Elefant

Download the latest copy of Elefant at http://github.com/jbroadway/elefant/downloads and unzip it into
the parent folder of `elefantcms.phpfogapp.com`. Now on the command line, we'll move the files over:

~~~
$ cp ../elefant-0.9.8-beta/.htaccess .
$ cp -R ../elefant-0.9.8-beta/* .
~~~

Next, open the file `conf/config.php` and in your browser, click on the Database tab in PHP Fog. Take the
PHP Fog database settings and add them to the `[Database]` section of `conf/config.php` like this:

~~~
[Database]

driver = mysql
host = ""db01-share""
name = ""elefantcms-phpfogapp-com""
user = ""Custom App-12345""
pass = ""YOUR PASSWORD HERE""
~~~

Back in the PHP Fog website, click 'Access the Database through phpMyAdmin' and log into phpMyAdmin with
your database username and password. Select your database on the left and click the 'Import' tab. Import
the `conf/install_mysql.sql` file from your workstation.

### Creating an admin user

First, we need to generate an encrypted password for our admin user. We can do this with the following
command:

~~~
./conf/elefant encrypt-password ""your password""
~~~

Copy the output for the next step.

Back in phpMyAdmin, click on the `user` table and then the Insert tab. Enter the following
into the form:

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

## 4. Push to the cloud

Your local copy is almost ready to push to the server. However, since we didn't run the web or command
line installers, we need to disable the installer with the following command:

~~~
$ touch install/installed
~~~

Before committing our changes to Git, we should also adjust the folder permissions so Elefant can save cached templates on the server:

~~~
$ chmod -R 777 cache conf css files install layouts
~~~

Now we're ready to add everything to Git so we can send it to the server. Type the following into the command line:

~~~
$ git add .htaccess
$ git add *
$ git commit -m ""Initial import"" .htaccess *
~~~

To update the server with the Elefant files, simply run:

~~~
git push origin master
~~~

Once this has finished running, go to http://elefantcms.phpfogapp.com/ and you should
see a welcome page if all went well. To log in as your new administrator, go to
http://elefantcms.phpfogapp.com/admin and enter your email and password.

## Limitations

* While you can upload files through Elefant, they won't be tracked by Git and so you'll
want to make sure you have a backup copy of them somewhere. In a future version of Elefant,
you'll be able to automatically store uploaded files on Amazon S3, which is a more scalable
solution. You can also use a PHP [S3 library](http://net.tutsplus.com/tutorials/php/how-to-use-amazon-s3-php-to-dynamically-store-and-manage-files-with-ease/)
to store custom assets in the cloud in your own apps.
* Changes you make to the design and navigation on your live site will be overwritten the next
time you do a `git push origin master`. PHP Fog doesn't seem to recognize `.gitignore` files.
To avoid this, make your changes to the local copy, commit them with Git, and do a
`git push origin master` to deploy them to your live site.

PHP Fog is a platform for custom development in the cloud, and Elefant shines here more as a
framework for custom development, so relying on developer tools like Git for deployment is the
best way to work with Elefant in this context and avoid the pitfalls of using cloud platforms
like ordinary shared hosting.