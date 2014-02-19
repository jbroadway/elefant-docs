# Code example: Authorizing users

The simplest way to authenticate users in Elefant is to use the Controller's helper
methods and rely on its automatic redirection, like this:

	<?php
	
	// this will redirect to /user/login if they aren't authorized yet
	$this->require_login ();
	
	// now we can continue with our authenticated work
	
	?>

Similarly, there's a `require_admin()` method that works the same way:

	<?php
	
	// this will redirect to /admin if they aren't an admin user
	$this->require_admin ();
	
	// now we can continue with our authorized admin work
	
	?>

In more detail, this is making use of the User class behind the scenes.
Here is a simple bit of code you can use to authorize users via the User
class:

	<?php
	
	if (! User::require_login ()) {
		$page->title = __ ('Members');
		echo $this->run ('user/login');
		return;
	}
	
	// members-only stuff goes here
	
	?>

To do the same for admin pages, you would use:

	<?php
	
	// use the admin layout (optional)
	$page->layout = 'admin';
	
	if (! User::require_admin ()) {
		$this->redirect ('/admin');
	}
	
	// admin-only stuff goes here
	
	?>
