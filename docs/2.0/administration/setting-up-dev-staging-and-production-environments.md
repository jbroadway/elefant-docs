# Setting up dev, staging, and production environments

Elefant lets you to specify alternate configurations for your development, staging, and production servers. This takes two steps to setup:

1. Duplicate the `conf/config.php` file and name it after your environment name, e.g. `conf/development.php` or `conf/staging.php`.

2. In your `.htaccess` or web server configuration, set the `ELEFANT_ENV` environment variable. For Apache you would add a line like this:

~~~apache
SetEnv ELEFANT_ENV development
~~~

Now you can edit your different configuration files to suit your needs in each separate environment, and Elefant will load the correct one in each context.

## Command line and cron jobs

To specify the environment on the command line, you can export the variable directly like this:

~~~bash
export ELEFANT_ENV=staging
./elefant version
~~~

You can also specify the environment via the `--env` option directly in the `./elefant` command:

~~~bash
./elefant --env=staging version
~~~

Note that calling a handler directly via `php index.php cli/version` does not listen for the `--env` option.
