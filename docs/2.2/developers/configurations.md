# Configurations

Elefant has both global and app-level configuration files. The global configuration
file is determined by the `ELEFANT_ENV` environment variable, which defaults to `config`.
With the default setting, Elefant will load its global configurations from the file
`conf/config.php`.

Similarly, if `ELEFANT_ENV` is set to `staging`, Elefant will look in the file
`conf/staging.php` instead. For more info see
[[Administration / setting up dev, staging, and production environments]].

## Global configurations

The global configuration settings are accessed through the `conf()` function.
For example, the following will output the site name, from the `site_name` setting
in the `[General]` section of your global configuration:

~~~php
<?php

echo conf ('General', 'site_name');

?>
~~~

Any value from your global configuration can be accessed the same way. You can also
include these in your templates like this:

~~~
{{ conf ('General', 'site_name') }}
~~~

To modify a setting for the current request, you can specify the new value in the third
parameter. For example, to temporarily enable debugging:

~~~php
<?php

// Enable debugging
conf ('General', 'debug', true);

// ...

// Disable debugging again
conf ('General', 'debug', false);

?>
~~~

## App-level configurations

App-level configurations are documented on the [[Developers / App configurations]] and
[[Developers / Sharing your apps / User-configurable app settings]] pages.

## Dependency Injection Container

Sometimes you may want to include additional configurations or complex object
initializations that can be shared across your apps, such as service objects.
Elefant bundles the [Pimple](http://pimple.sensiolabs.org/) dependency injection
container for this purpose.

To use it, create a `bootstrap.php` file in the root of your site and use it as
follows:

~~~php
<?php

$controller->settings = new Pimple ();

$controller->settings['initial_value'] = 'Some value';

$controller->settings['myobj'] = function ($settings) {
	return new myapp\MyClass ($settings['initial_value']);
};

?>
~~~

Now in any handler, to retrieve your initialized `myapp\MyClass` object instance,
you would say:

~~~php
<?php

$my_obj = $this->settings['myobj'];

?>
~~~

Next: [[:Browser detection]]
