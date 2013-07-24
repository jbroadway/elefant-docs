# Locking items while editing

Adding locking to prevent editing conflicts is easy in Elefant. Here is the usage pattern:

	<?php
	
	// Let's look for a lock on the 'about-us' page
	$lock = new Lock ('Webpage', 'about-us');
	
	if ($lock->exists ()) {
		// Editing is locked by another user
		$page->title = i18n_get ('Editing Locked');
		echo $tpl->render ('admin/locked', $lock->info ());
		return;
	} else {
		// It's not locked, so let's lock it for ourselves
		$lock->add ();
	}
	
	// Proceed with our edits...
	
	// When we want to remove the lock after saving our changes, we simply add this:
	$lock->remove ();
	
	?>

The first part is to create a Lock object, giving it a type and identifier. In this
case, that's `Webpage` and `about-us`. The type corresponds to the name of a Model-based
class.

Next, if the `$lock->exists()`, which means that a lock held by *another* user exists,
then we show them the `admin/locked` view with the `$lock->info()`.

If not, we `add()` a lock for ourselves.

Once the edits have been made, we can `remove()` the lock so that others can edit
the item.