# User-configurable app settings

In general, users should never have to modify the original files within an app. Elefant provides a means of overriding app settings without having to edit the app's original configuration file.

How it works is when an app's configuration is loaded by the [Appconf](http://api.elefantcms.com/visor/lib/Appconf) class, it also checks for the existence of a custom configuration file, named in the following pattern:

	conf/app.{$appname}.{ELEFANT_ENV}.php

`ELEFANT_ENV` defaults to `config` if it's not set to something else via an environment variable, so the custom configurations for the `blog` app would be stored in:

	conf/app.blog.config.php

## Building a settings form

...

Back: [[Developers / App configurations]]