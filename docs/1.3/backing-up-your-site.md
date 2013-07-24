# Backing up your site

Elefant includes a backup command in the command line utility. To back up your entire site, including the database, to a `backups` folder in your home folder, use the following commands:

~~~
$ cd /path/to/your/site
$ ./elefant backup ~/backups/
~~~

This will generate a timestamped backup file, for example `backup-2011-12-15-08-23-55.tar.gz`. The database backup can be found in the file `dump.sql` in the backup archive.

### Scheduled backups

Here's an example crontab configuration for nightly backups at 2am:

~~~
0 2 * * * cd /path/to/your/site; ./elefant backup ~/backups/
~~~
