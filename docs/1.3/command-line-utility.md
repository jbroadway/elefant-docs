# Command line utility

Elefant comes with a command line utility for helping automate certain tasks. This includes:

* Creating scaffolding or CRUD for new apps
* Building translation indexes for multilingual sites
* The command line installer
* Backup/export utilities
* Password helpers

To use it, run the following commands:

~~~
$ cd /path/to/your/site
$ ./elefant
~~~

This will output the help info with a list of commands and their usage:

~~~
== Elefant framework command line utility ==

Usage:

  $ cd /path/to/my/site
  $ elefant COMMAND

Commands:

  install                          Run the command line installer
  backup <path>                    Save a backup of the site and db
  export-db <file>                 Export the db to a file or STDOUT
  build-app <appname>              Build the scaffolding for an app
  build-translation <lang>         Build a translation index
  generate-password <length(8)>    Generate a random password
  encrypt-password <password>      Encrypt a password for the db
~~~

You can also install the command globally using PEAR like this:

~~~
$ cd /path/to/your/site
$ pear install conf/package.xml
~~~

Now the `elefant` utility is available in your path and you can use it via:

~~~
$ cd /path/to/your/site
$ elefant build-app myapp
~~~
