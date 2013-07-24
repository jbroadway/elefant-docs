# Code example: Hello world

## Step 1. Create your app

On the command line, run the following commands:

	$ cd /path/to/your/site
	$ ./elefant build-app hello

This will create the directory structure for your new app. You can also simply create the folders manually if you prefer, or aren't comfortable on the command line. The folder structure is as follows:

	apps/
		hello/
			handlers/
				index.php
			views/
				index.html

## Step 2. Edit your handler

Open the file `apps/hello/handlers/index.php` and add this code:

	<?php
	
	// get the name parameter from the URL
	list ($name) = count ($this->params) ? $this->params : 'World';
	
	// send the request on to the view template
	echo $tpl->render ('hello/index', array ('name' => $name));
	
	?>

> Where did `$this` and `$tpl` come from? Think of them like `$_GET` and `$_POST`. They're created for you by the front controller (the main `index.php`) so your script has access to them without the need to create them yourself. `$this` is a Controller object, and `$tpl` is a Template object.

## Step 3. Edit the view

Open the file `apps/hello/views/index.html` and add this code:

	<p>Hello {{ name }}</p>

You can now go to the URL `/hello/John` on your site and you should see the output `<p>Hello John</p>`.