# Environment variables

Elefant can read its settings from environment variables, which can be useful for
containerizing your Elefant app deployments. These settings by default include:

* `ELEFANT_ENV` - The base configuration file to load for the current environment
* `ELEFANT_DB_DRIVER` - The database driver to use (e.g., sqlite, mysql)
* `ELEFANT_DB_FILE` - The database file to read from (for SQLite)
* `ELEFANT_DB_HOST` - The database host to connect to
* `ELEFANT_DB_NAME` - The database name to connect to
* `ELEFANT_DB_USER` - The database user to connect as
* `ELEFANT_DB_PASS` - The password of the user to connect to the database as
* `ELEFANT_TIMEZONE` - The timezone of the site
* `ELEFANT_UDATES` - Whether to check for Elefant updates in the Elefant admin toolbar
* `ELEFANT_SITE_KEY` - A unique private key for CSRF token verification
* `ELEFANT_SESSION_NAME` - What to name session cookies
* `ELEFANT_SESSION_HANDLER` - Set the backend session storage handler
* `ELEFANT_SESSION_DOMAIN` - The domain to limit session cookies to
* `ELEFANT_SESSION_DURATION` - The lifetime of a session cookie

If your environment variables are named differently, you can modify the `conf/envmap.php`
file to specify alternate environment variable names to look for. For example,
to read your database host name from `MYSQL_HOST`, you would edit the following line:

```ini
ELEFANT_DB_HOST = MYSQL_HOST
```
