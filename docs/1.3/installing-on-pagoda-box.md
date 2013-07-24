# Installing on Pagoda Box

[Pagoda Box](http://www.pagodabox.com/) is a PHP cloud hosting platform. It's easy to get started with Elefant on Pagoda Box with the [Elefant Quickstart](http://github.com/jbroadway/elefant-quickstart).

## Quickstart

First, register for a free account at Pagoda Box. Once you've verified your account, click `New Application` from the Pagoda Box dashboard. Give your app a name, then select click `Launch` next to `Elefant` in the Quickstart list below. In a minute or so, you'll have a fresh Elefant installation up and running.

## Logging in

The next step is to log into the admin area of your new Elefant installation and change the admin password. The default email and password on install are `you@example.com` and `ChangeMe`. Log in and change these under Tools > Users.

## Building your site

Now you're ready to grab a clone of your site using Git and start making updates to it. [Here is the developer workflow Pagoda Box recommends for building/updating your site](http://help.pagodabox.com/customer/portal/articles/175481-recommended-workflow).

A good first change to make once you're ready to edit your site is to open the `bootstrap.php` file and remove the database installation code, since it's not needed any more. But make sure to leave the database configuration changes in place, since that tells Elefant the info it needs to connect to the database on Pagoda Box's system.