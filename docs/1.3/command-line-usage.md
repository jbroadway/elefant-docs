# Command line usage

To call a script from the command line, use the following syntax:

	php index.php appname/handler

If your handler must run only under the command line and not be accessible to web browsers, you can do the following check in PHP:

	<?php
	
	if (! $this->cli) die ('Must be run from cli');
	
	?>

It's also a good idea to set `$page->layout = false` so that the output of your command line script isn't passed through to a layout template.

## Command line utilities

Elefant provides a `./elefant` utility script you can run from the command line that provides several useful functions for working with Elefant, including an installer, database exporter, backups, and app scaffolding.

For more info on this, see [[Command line utility]].