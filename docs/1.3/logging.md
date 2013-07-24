# Logging

Elefant comes with [Analog](https://github.com/jbroadway/analog), a very concise and easily extensible logging library. You'll find it under `lib/vendor`.

To use the default logging (to a temp file named `analog.txt` in the folder specified by `sys_get_temp_dir()`), simply use it anywhere in your app like this:

    <?php
    
    // Log an error
    Analog::log ('Some message');
    
    ?>

You can also specify the error level:

    <?php
    
    // Debug something...
    Analog::log ('Debug output', Analog::DEBUG);
    
    ?>

## Custom logging configurations

You may want to implement a custom logging engine that's accessible across your whole Elefant instance. For example, say you want to log to a MongoDB database. For this, create a file named `bootstrap.php` in your site root (for more on this file, see [[Global configurations]]) with the following code:

	<?php
	
	Analog::handler (AnalogHandlerMongo::init (
		MongoManager::get_connection (), // connection object
		conf ('Mongo', 'name'), // database name
		'log' // collection name
	));
	
	?>

Now any time you call `Analog::log()` in your apps, the output will be saved to a MongoDB collection named `log` with the fields `machine`, `date`, `level`, and `message`.

> Note: Be sure to set your MongoDB connection info in `conf/config.php`.

Analog provides a dozen different logging handlers itself, and you can write your own as easy as this:

	<?php
	
	Analog::handler (function ($info) {
		// format the info and pass it to error_log()
		error_log (vsprintf (Analog::$format, $info));
	});
	
	?>

## Debugging AJAX/REST APIs with FirePHP

[[RESTful APIs]] that are accessed via JavaScript can be a challenge to debug on their own. Tools like [FirePHP](http://www.firephp.org/) exist to help with this by forwarding logging messages to the browser's debugging console via HTTP headers.

Elefant can be configured to work with FirePHP by adding the following to your `bootstrap.php` [configuration file](/wiki/Global-configurations):

	<?php
	
	Analog::handler (AnalogHandlerFirePHP::init ());
	
	?>

Now any call to `Analog::log('some text');` will be sent to FirePHP.

-----

For additional help on debugging and error handling, see [[Error handling, debugging, and reporting]].