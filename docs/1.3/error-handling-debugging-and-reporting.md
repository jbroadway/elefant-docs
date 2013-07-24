# "Error handling

-debugging,-and-reporting","Elefant has a default error handler setting that points to `admin/error`, but that you can alternately point to your own custom error handler. The handler must accept 3 data values: code, title, and message. Here's how to trigger an error in your other handlers:

	<?php
	
	// some logic
	if (! $do->something ()) {
		// trigger an error
		echo $this->error (404, 'Page not found', 'How embarrassing, we could not find the page you wanted.');
		return;
	}
	
	?>

Make sure to echo the output and return after, or the error message body will not be displayed. The above will display a 404 error message to the end user.

## Debugging

By default, we set the `error_reporting` level to `E_ALL & ~E_NOTICE` and turn `display_errors` off. This is ideal for production servers, but less so for development. You can enable debugging in the `conf/config.php` file and Elefant will display a detailed trace of errors including highlights of the relevant source code.

To enable debugging, change this line in `conf/config.php`:

	; For development, turn debugging on and Elefant will output
	; helpful information on errors.
	
	debug = On

Now, any time there's an error or exception, Elefant will show helpful trace output of where the error occurred, including highlighting the relevant lines of code, and a trace of all data in the system at that time.

Similarly, you can change the `display_errors` setting in `conf/config.php` to enable PHP's `display_errors` setting:

	; For development, turn display_errors on and Elefant will
	; output fatal error messages in addition to the debugger.
	
	display_errors = On

To trigger an error and see what your code is doing at any point, use `trigger_error()` like this:

	<?php
	
	$obj = new stdClass;
	$obj->value = 'Some value';
	
	if ($obj->value != 'Expected value') {
		trigger_error ('Uh oh, something went wrong');
	}
	
	?>

This will print the following trace:

![Debugger output in Elefant](http://jbroadway.github.com/elefant/screenshots/debugging.png)

At the bottom of the context output, you'll find `$obj` described like this:

	<?php
	
	$obj = stdClass (
		$value = ""Some value"";
	);
	
	?>

## Error reporting

What I often do for debugging is leave the settings alone and instead have a command terminal open listening to the Apache error log for updates, like this:

	$ tail -F /var/log/apache2/error_log

The `-F` switch will cause it to update the terminal window with any new errors as they're logged, so you can see them as they happen.

To log a custom error to the error log for debugging, use:

	error_log ('Error message');

For much more customizable error reporting, including logging to [FirePHP](http://www.firephp.org/) and other sources, see the [[Logging]] page."
