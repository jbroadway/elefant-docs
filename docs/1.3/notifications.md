# Notifications

The Elefant admin interface checks a cookie named `elefant_notification` for messages and displays them using [jGrowl](http://stanlemon.net/projects/jgrowl.html). The standard practice when developing apps in Elefant is to add a notification and redirect the user to the next screen in your workflow instead of creating a separate page that simply says ""Your item has been saved. Click here to continue."" This helps save clicks, and makes users happy :)

To set a notification in PHP, do this:

	<?php
	
	$this->add_notification ('Your notification here.');
	
	?>

You can combine this with a redirect like this:

	<?php
	
	if (/* object was saved */) {
		$this->add_notification ('Object saved.');
		$this->redirect ('/myapp/admin');
	}
	
	?>

And you can also add notifications in JavaScript like this:

	$.add_notification ('Your notification here.');

This function is always available when a site admin is logged into Elefant.