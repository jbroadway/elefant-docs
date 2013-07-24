# Backing up the database

Elefant includes a database export command in the command line utility. To back up your database to a file called `exported.sql` in your home folder, use the following commands:

~~~
$ cd /path/to/your/site
$ ./elefant export-db ~/exported.sql
~~~

This will call the underlying database's export command, which needs to be in your command path.