# Upgrading Elefant

**Important: Before upgrading, make sure to [backup your site](/docs/2.2/administration/backing-up-your-site) first.**

To upgrade your site, use the Elefant CLI tool like this:

~~~bash
./elefant update
~~~

The update command pulls patches from the [elefant-updates](https://github.com/jbroadway/elefant-updates)
Github repository, then does a dry run to test whether the patches can be applied without
conflicts. If so, it will apply the patches from oldest to newest. If not, it will store
a log of the conflicts in the `conf/updates/error.log` file so you can manually merge
the patches with your Elefant customizations.

> Security note: SHA keys for each patch file are stored in the [elefant-checksums](https://github.com/elefantcms/checksums)
repository under a separate Github account. These are used to verify the authenticity
of each patch before applying them.

## Upgrading apps

### Using the Elefant CLI tool

> Note: This feature is still under development.

Using the Elefant CLI tool, enter the following command to update all of your apps at once:

~~~bash
./elefant update all
~~~

### Using Composer

Using Composer, you can run the following command to update all installed packages, including
apps, themes and PHP libraries:

~~~bash
composer update
~~~

### One last step

Log into Elefant and if there's an update routine that also needs to be run, it will
appear highlighted in the Tools menu as `App Name (click to upgrade)`.

Next: [[:Multilingual setup]]