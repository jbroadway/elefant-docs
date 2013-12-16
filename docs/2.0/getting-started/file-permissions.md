# File permissions

File permissions tell the operating system which users and groups can read and write to files. Elefant needs extended permissions in order to write to certain folders in your site. Here's an overview of what Elefant needs permission to write to and why:

### apps

Contains all of the Elefant apps that you have installed. Elefant needs to be able to write to this folder to install new apps.

### conf

Configurations live here, as well as the SQLite database file (`conf/site.db`). Changes to navigation or updating the default layout setting will be written to this folder.

### cache

This folder stores compiled templates and other cacheable or temporary data used to render your site.

### css

The CSS files for your site's design, which can be edited via the Tools > Designer app.

### files

The place Elefant stores uploaded files through the Tools > Files app.

### lang

The translations and settings for multilingual sites.

### layouts

The HTML files for your site's design, which can be edited via the Tools > Designer app.

## An overview of permissions

File permissions on Unix operating systems (e.g., Linux, Mac OS X) are calculated using the following numbered scheme:

* **R**ead = 4
* **W**rite = 2
* e**X**ecute = 1

> Execute means the file can be run like a program.

For each file, there are three permission levels:

* User
* Group
* World

Adding the permissions up gives you the level of access that each level has. Here are some examples:

Mode | Permissions | Explanation
-- | -- | --
0000 | `----------` | No permissions
0400 | `-r--------` | Owner can read, group and world have no access
0444 | `-r--r--r--` | All have read only
0644 | `-rw-r--r--` | Owner can read/write, group and world can read
0666 | `-rw-rw-rw-` | All can read/write
0755 | `-rwxrw-rw-` | Owner can read/write/execute, group and world can read/write
0770 | `-rwxrwx---` | Owner and group can read/write/execute, world has no access
0777 | `-rwxrwxrwx` | All can read/write/execute

> Note: The initial 0 denote that the permissions are an octal number, not decimal.

## Elefant's permissions

As listed above, some features of Elefant need to be able to write to your website. This usually means increasing the permissions for those folders and the files inside them.

Why this is the case is that the web server software runs as a different user on the system (usually named `nobody` or `apache` or something similar) in order to restrict what it can access. So your files are owned by you, but need to be accessed - and sometimes written to - by another user.

This is common to any server-side software that needs to write to the server, for example to save a file that has been upload through the admin area.

Some servers are setup so that the web server user belongs to the same group, so you don't have to give full permissions, but often that's not the case.

Because we don't know ahead of time, we simply request that you set your permissions to a level we know will work for everybody, but encourage you to check with your host first to find the right permission level for your site.

For more info on server permissions, see:

* [http://onlamp.com/pub/a/php/2003/02/06/php_foundations.html](http://onlamp.com/pub/a/php/2003/02/06/php_foundations.html)
* [http://www.simplemachines.org/community/index.php?topic=2987.0](http://www.simplemachines.org/community/index.php?topic=2987.0)
* [http://www.htmlite.com/php042.php](http://www.htmlite.com/php042.php)


Next: [[Getting started / Troubleshooting]]