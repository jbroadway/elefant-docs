# Global configurations

## The conf() function

Elefant's own configurations are available through the `conf()` function. For example:

	<?php
	
	echo conf ('General', 'site_name');
	
	?>

For more info, see the [API references here](http://jbroadway.github.com/elefant/api/Functions.html#section-3).

## Dependency Injection Container

Sometimes you may want to include additional configurations that can be shared across all your Elefant apps, such as service object initializations. For this, the Elefant front controller (`index.php`) will look for a `bootstrap.php` file in the root of your site.

This file is optional (and not present by default), and is intended for including any additional configurations, such as dependency injection containers (see [Pimple](http://pimple.sensiolabs.org/) in `lib/vendors`).

For example, say you create the following `bootstrap.php` file:

    <?php
    
    $controller->settings = new Pimple ();
    
    $controller->settings['my_setting'] = 'Value';
    
    $controller->settings['my_class'] = $controller->settings->share (function ($settings) {
        return new MyClass ($settings['my_setting']);
    });
    
    ?>

Now in any handler across your site, you can say:

    <?php
    
    $my_obj = $this->settings['my_class'];
    
    ?>

You now have a new `MyClass` object for use anywhere in any of your Elefant apps.

Note that you have autoloading available here, so any class in `lib` and `lib/vendor` can be accessed directly or via PSR-0 namespaces (depending on the package), or in apps via `appnameClassName` syntax.