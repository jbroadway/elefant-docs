# Requirements

Browser requirements:

* Google Chrome
* Safari 4+
* Firefox 3.5+
* IE 8+

Server requirements:

* [PHP 5.3+](http://www.php.net/) or [HHVM](http://hhvm.com/)
* [Apache](http://httpd.apache.org/) with mod_rewrite or [Nginx](http://nginx.org/) web server
* [SQLite](http://sqlite.org/), *[MySQL](http://mysql.com/), or [PostgreSQL](http://www.postgresql.org/) database
* PHP [CURL extension](http://www.php.net/manual/en/book.curl.php) required for some features

> *MySQL replacements such as [MariaDB](https://mariadb.org/) and [Percona](http://www.percona.com/software/percona-server) are also supported.

--- Platform: Linux ---

Linux users should use your distribution's package management system to install
the required server software.

--- Platform: Mac ---

Mac OS X users simply need to install [MySQL](http://mysql.com/), since Mac OS X ships with
Apache and PHP already.

--- Platform: Windows ---

For Windows users, we recommend using [WAMP](http://www.wampserver.com/en/) to install
and configure Apache, PHP, and MySQL for you. Make sure to also enable `mod_rewrite` in
the Apache configuration.

--- /Platform ---

### Development

For development workstations, we recommend using virtualization tools to isolate your
development servers from your operating system. [Here is a set of tools](https://github.com/jbroadway/elefant-vagrant)
you can use to setup virtual environments for Elefant development.

Next: [[:Installation]]