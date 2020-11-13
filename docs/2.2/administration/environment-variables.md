# Environment variables

Elefant can read its settings from environment variables, which can be useful for
containerizing your Elefant app deployments. These settings by default include:

* `ELEFANT_ENV` - The base configuration file to load for the current environment
* `ELEFANT_SITE_NAME` - The name of your website
* `ELEFANT_EMAIL_FROM` - The address to use when sending transactional emails
* `ELEFANT_DEFAULT_PASS` - The default password for automated installs
* `ELEFANT_DOMAIN` - The domain name the website is using
* `ELEFANT_TIMEZONE` - The timezone of the site
* `ELEFANT_UPDATES` - Whether to check for Elefant updates in the Elefant admin toolbar
* `ELEFANT_SITE_KEY` - A unique private key for CSRF token verification
* `ELEFANT_DB_DRIVER` - The database driver to use (e.g., sqlite, mysql)
* `ELEFANT_DB_FILE` - The database file to read from (for SQLite)
* `ELEFANT_DB_HOST` - The database host to connect to
* `ELEFANT_DB_NAME` - The database name to connect to
* `ELEFANT_DB_USER` - The database user to connect as
* `ELEFANT_DB_PASS` - The password of the user to connect to the database as
* `ELEFANT_SESSION_NAME` - What to name session cookies
* `ELEFANT_SESSION_HANDLER` - Set the backend session storage handler
* `ELEFANT_SESSION_DOMAIN` - The domain to limit session cookies to
* `ELEFANT_SESSION_DURATION` - The lifetime of a session cookie
* `JOBQUEUE_BACKEND` - The job queue backend to use (currently only "beanstalkd" is supported)
* `JOBQUEUE_HOST` - The job queue host to connect to
* `JOBQUEUE_PORT` - The job queue port to connect to

If your environment variables are named differently, you can modify the `conf/envmap.php`
file to specify alternate environment variable names to look for. For example,
to read your database host name from `MYSQL_HOST`, you would edit the following line:

```
ELEFANT_DB_HOST = MYSQL_HOST
```
