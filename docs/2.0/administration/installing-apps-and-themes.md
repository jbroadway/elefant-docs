# Installing apps and themes

Apps are simply folders with a collection of scripts and files in them that live
in the `apps` folder. Similarly, themes are simply folders with templates, stylesheets,
and images that live in the `layouts` folder.

## From the web

To install an app or theme from your web browser, log in and go to Tools > Designer >
Install App/Theme. From here you can paste the link to a Github repository or zip file,
or upload a zip file directly, to have that app or theme installed for you.

## Using the Elefant CLI tool

To install an app or theme using Elefant's CLI tool, enter its Github repository link
or a link to a zip file of the app. Github shorthand names of the form `user/repository`
are also supported, for example:

	./elefant install jbroadway/dbman

## Using Composer

To install an app or theme using [Composer](http://getcomposer.org/), use the following commands:

	composer require elefant/app-form

Composer will know where to install the package based on its type (app or theme). You can
also install 3rd party PHP libraries in the same way, which will be installed in the `lib/vendor`
folder.

> Note: Composer may ask you for a version constraint for some packages that are still in
> beta. Enter `dev-master` to install these packages.

[Click here](https://packagist.org/packages/elefant/) for a list of available apps and themes
on Packagist, Composer's package directory.

## Manual installation

You can also install an app or theme simply by placing the app or theme's folder into
the appropriate folder in your Elefant installation. There may be additional steps
outlined in the provided `README` file, so be sure to check for that.

## One last step

Log into Elefant and if there's an install routine that also needs to be run, it will
appear highlighted in the Tools menu as `App Name (click to install)`.

Next: [[:Backing up your site]]
