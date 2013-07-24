# Comparison to Sitellite: Handlers

Back to [[Comparison to Sitellite CMS]].

***

In both frameworks, apps live in their own folders. In Sitellite, this is in `inc/app/appname` but in Elefant it's just `apps/appname`.

Sitellite calls its handlers ""boxes"" and they live in the `boxes` folder of an app. Elefant just calls them handlers, and they live in the `handlers` folder of an app.

Sitellite boxes are each separate folders named for the box name, and include an `index.php` file, an optional `settings.php` for box chooser settings, and `access.php` for setting access restrictions for the box. Relying on folder names is cumbersome in many text editors, especially tabbed editors where you end up with a handful of tabs all named `index.php`.

Elefant is much simpler, just having files named after the handler name in a `handlers` folder. For example `apps/myapp/handlers/myhandler.php`. Access control and other settings are set directly in PHP on an as-needed basis.

## Reusing handlers

In Sitellite, you can call one box from another via:

	<?php
	
	echo loader_box ('app/box', $params);
	
	?>

In Elefant, the equivalent is:

	<?php
	
	echo $this->run ('app/handler', $params);
	
	?>

## Parameters

In Sitellite, there is always a `$parameters` array of request values. In Elefant, there are simply the `$_GET` and `$_POST` superglobals. However, if parameters came from another handler, they will be in a `$data` array, and if they came from the URL (e.g., `/myapp/myhandler/param1/param2`) then they will be in a numeric array of parameters called `$this->params`. In the URL `/myapp/myhandler/param1/param2`, `$this->params[0]` would contain ""param1"" because the earlier parts of the URL already matched the handler itself.

You can check if a request came from another handler via:

	<?php
	
	if ($this->internal) {
		// came from another handler
	} else {
		// direct request to this handler
	}
	
	?>
