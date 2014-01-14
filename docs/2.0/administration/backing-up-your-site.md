# Backing up your site

Backing up an Elefant site is as simple as running the following command:

~~~bash
./elefant backup ~/backups/
~~~

This will generate a timestamped backup file, named in the form `backup-2014-01-23-08-23-55.tar.gz`.
The database backup can be found in the file `dump.sql` in the backup file.
The backup file will be saved to the folder specified in the command, in this case `~/backups/`.

## Scheduled backups

Here's an example crontab configuration for nightly backups at 2am:

~~~bash
0 2 * * * /var/www/elefant backup ~/backups/
~~~

> Note: Make sure to change the path to match your website document root.

## Exporting the database

You can also export just the database with the following command:

~~~bash
./elefant export-db ~/exported.sql
~~~

This will create an `exported.sql` file in your home folder containing your complete
database schema and content.

Next: [[:Upgrading Elefant]]