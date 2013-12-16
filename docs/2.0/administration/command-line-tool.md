# Command line tool

Elefant comes with a command line tool to help automate certain administrative and
development tasks, such as:

* Installation and upgrades
* Backups and importing/exporting data
* Password helpers
* Clearing the cache
* Generating scaffolding for new projects

The tool can be run from any directory, but the examples in this documentation assume
you're in the document root of your website when running the command. For example, if
your document root is `/var/www` then these two examples will both print the help info
and command list when executed:

	cd /var/www
	./elefant

And without the `cd` first:

	/var/www/elefant

Next: [[:Installing apps and themes]]