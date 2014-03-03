# Writing command line scripts

You can call an Elefant handler from the command line as follows:

~~~bash
php index.php myapp/myhandler
~~~

This can be handy for testing, but for commands that you want to only be accessible
via the command line, and not be accessible to web browsers, you can add the
following check at the top of your handler:

~~~php
<?php

if (! $this->cli) die ('Must be run from the cli');

?>
~~~

It's also a good idea to set `$page->layout = false` in your command line handlers,
so that the output of your script doesn't get wrapped in a bunch of HTML tags.

## Formatted output

You can use the [Cli](api.elefantcms.com/visor/lib/Cli) class to help format your
command line output, including color codes for success, info, and error notices.
For example:

~~~php
<?php

// Default output
Cli::out ('Some info here...');

// Print an error message
Cli::out ('Error: Something bad happened.', 'error');

// Print a success message
Cli::out ('All is well, captain.', 'success');

// Print a block of text, with partial color
Cli::block ("Options: <info>one, two, three</info>\n");

?>
~~~

Using `Cli::block()`, you can specify the following tags to color your command line
output:

* `<success></success>`
* `<error></error>`
* `<info></info>`

## Extending the `./elefant` commands

You can extend the available commands for the `./elefant` command line utility
by adding them to the `conf/cli.php` file in your app. For example:

~~~ini
; <?php /*

commands[myapp/mycommand] = Does something cool

; */ ?>
~~~

This will then list your command under the extended commands list and allow you
to run it like this:

~~~bash
./elefant myapp/mycommand
~~~

See [[developers / making your own apps]] for more info.

Next: [[:Client-side helpers]]
