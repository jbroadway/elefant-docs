# Version control basics

Elefant provides a built-in version control mechanism for any Model object. It also provides a way of accessing, comparing, and restoring previous versions through the Tools > Versions menu option.

To add version control to your own models, whenever you update your model object simply call `Versions::add()` like this:

	<?php
	
	$obj = new MyModel ($some_id);
	$obj->some_value = 'New value';
	$obj->put ();
	
	if (! $obj->error) {
		// Save a new version of the changes
		Versions::add ($obj);
	
		// Proceed with successful save handling
	}
	
	?>

That's the same code you would use for creating new objects and updating them.

## Programmatic access to versions

You can easily get the version history of any Model object, or the recent changes made by a given user, like this:

	<?php
	
	$obj = new MyModel ($some_id);
	
	// Get the history of $obj
	$history = Versions::history ($obj);
	
	// Get recent changes made by $user
	global $user;
	$recent = Versions::recent ($user);
	
	?>

The Versions class is itself a Model object, defined in `apps/admin/models/Versions.php`, and so it inherits all of the features of Model itself as well as its own `add()`, `restore()`, `history()`, `recent()`, and `diff()` methods.