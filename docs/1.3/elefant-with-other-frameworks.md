# Elefant with other frameworks

Since Elefant tries to stay a very minimalist web framework, there are times you'll need to integrate with other libraries and frameworks. Here are some steps to working with some other popular general frameworks within Elefant.

## Composer and PSR-0

To install packages through [Composer](http://getcomposer.org/), simply add them to your `composer.json` file, and set the `vendor-dir` to `lib/vendor` like this:

	{
		""require"": {
			""merk/Dough"": ""*"",
			""elefant/app-assetic"": ""*"",
			""elefant/app-form"": ""*"",
			""elefant/theme-montreal"": ""*""
		},
		""config"": {
			""vendor-dir"": ""lib/vendor""
		}
	}

Notice that two of the packages listed are Elefant apps, and one is an Elefant theme. Elefant fully supports Composer for installing apps and themes in addition to third party libraries.

For more information, see [[Using Composer packages]].

For libraries and frameworks that are compatible with [PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md), simply drop them into `lib/vendor/` and you can autoload any class by its namespace.

## Zend Framework

Install the [Zend Framework](http://framework.zend.com/) anywhere in your PHP `include_path` (dropping the `Zend` folder into your site root will even do the trick).

You can now use Zend Framework components as you normally would, for example:

	<?php
	
	require_once 'Zend/Acl.php';
	
	$acl = new Zend_Acl ();
	
	$acl->addRole (new Zend_Acl_Role ('member'))
		->addRole (new Zend_Acl_Role ('admin'));
	
	$acl->add (new Zend_Acl_Resource ('myapp'));
	$acl->deny ('member', 'myapp');
	$acl->allow ('admin', 'myapp');
	
	echo $acl->isAllowed ('member', 'myapp') ? 'allowed' : 'denied';
	
	?>

## PEAR

Install your [PEAR](http://pear.php.net/) packages as you normally would, for example:

	pear install Log-1.12.6

Now you can use the PEAR Log package like this:

	<?php
	
	require_once 'Log.php';
	
	$logger = Log::singleton ('error_log', PEAR_LOG_TYPE_SYSTEM, 'myapp');
	$logger->log ('testing');
	
	?>

To see the output of the above, check your Apache or nginx error log for the output `myapp: testing`.

## eZ Components

Install the [eZ Components](http://ezcomponents.org/) package according to their instructions, for example:

	pear channel-discover components.ez.no
	pear install -a ezc/eZComponents

Now you can initialize the eZ Components autoloader and use its libraries like this:

	<?php
	
	require_once 'ezc/Base/base.php';
	spl_autoload_register (array ('ezcBase', 'autoload'));
	
	$mail = new ezcMailComposer ();
	$mail->from = new ezcMailAddress ('joe@example.com', 'Joe Smith');
	// etc.
	
	?>

## Symfony Components

To use one of the [Symfony Components](http://components.symfony-project.org/) in your Elefant app, simply download that component to your app's `lib` folder, e.g., `apps/myapp/lib/` and then use it like any ordinary PHP class. Elefant's autoloader will take care of everything else for you.

> Note: Symfony2 users can also put class hierarchies into `lib/vendor` and Elefant will use PSR-0 autoloading to find them.

For example, using the Yaml component:

	<?php
	
	$yaml_data = ""foo:
 bar: asdf"";
	
	$yaml = new sfYamlParser ();
	info ($yaml->parse ($yaml_data));
	
	?>

If you run the above example, you should see the following output:

	Array
	(
		[foo] => Array
			(
				[bar] => asdf
			)
	
	)

## Regular PHP classes

You can simply drop any regular PHP class into your app's `lib` folder and go. For example, say you need to connect to an ActiveResource service using [PHP ActiveResource](https://github.com/lux/phpactiveresource). Simply drop the `ActiveResource.php` file into `apps/myapp/lib` and use it like this:

	<?php
	
	class Song extends ActiveResource {
		var $site = 'http://localhost:3000/';
	}
	
	$song = new Song ();
	// etc.
	
	?>

Elefant's autoloader will automatically load the library upon first use.