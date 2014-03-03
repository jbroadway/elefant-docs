# Logging

Elefant uses the [Analog](https://github.com/jbroadway/analog) logging library as
its bundled logger. Analog supports over a dozen backends via a minimal API. The
default is to log to a temp file named `analogtxt` in the folder specified by
the `sys_get_temp_dir()` function.

To log an error in your app, simply write:

~~~php
<?php

// Log an error
Analog::error ('Some message');

?>
~~~

You can also specify the log level:

~~~php
<?php

// Debug something
Analog::debug ('Debug output');

?>
~~~

Available log levels include:

* `Analog::debug ($message)`
* `Analog::info ($message)`
* `Analog::notice ($message)`
* `Analog::warning ($message)`
* `Analog::error ($message)`
* `Analog::alert ($message)`
* `Analog::urgent ($message)`

## Setting your backend

To set your logging backend, create or edit the `bootstrap.php` file in the root
of your site and set it like this:

~~~php
<?php

Analog::handler (Analog\Handler\Amon::init (
	'http://127.0.0.1',
	2464
));

?>
~~~

See the [Analog](https://github.com/jbroadway/analog) documentation for more examples.

## Debugging REST APIs

REST APIs that are accessed via JavaScript can be a challenge to debug on their own.
Tools like [FirePHP](http://www.firephp.org/) exist to help with this by forwarding
logging messages to the browser's debugging console via HTTP headers.

To initialize Analog to use FirePHP, add this to your `bootstrap.php`:

~~~php
<?php

Analog::handler (Analog\Handler\FirePHP::init ());

?>
~~~

Now any call to `Analog::debug ('some text')` will be sent to FirePHP. 

Next: [[:Configurations]]
