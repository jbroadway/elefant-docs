# Comparison to Sitellite: Users

Back to [[Comparison to Sitellite CMS]].

***

In Sitellite, there's a global `$session` object, and convenience functions to access it such as:

	<?php
	
	if (! session_valid ()) {
		// not logged in
	}
	
	?>

In Elefant, there's a `User` class that extends the database `Model` class. You can use it like this:

	<?php
	
	if (! User::require_login ()) {
		$page->title = i18n_get ('Members');
		echo $this->run ('user/login');
		return;
	}
	
	global $user;
	// you can now use $user to access the current user's info
	
	?>

There's also a simpler way to do the above that will redirect them to the user login or admin login forms by simply doing this:

	<?php
	
	$this->require_login ();
	
	// you'll be logged in here, Elefant takes care of the redirects
	
	?>

And for admin-only access:

	<?php
	
	$this->require_admin ();
	
	// proceed as an admin
	
	?>

Encrypting a password:

	<?php
	
	$encrypted = User::encrypt_pass ($password);
	
	?>

There's also a built-in user app with handlers for all the basics (login, logout, signup, view profile, update profile, password recovery, and user management).

The `User` model contains the following fields:

* id (numeric id)
* email
* password (encrypted)
* session_id
* expires (datetime)
* name
* type (admin, member)
* signed_up (datetime)
* updated (datetime)
* userdata

User logins use the email for username.

## Additional fields

Elefant allows arbitrary fields to be associated with users via the `userdata` field, which is a JSON-encoded associative array. You can access it like this:

	<?php
	
	// fetch
	echo User::ext ('fieldname');
	
	// update
	User::ext ('fieldname', 'new value');
	
	// save changes
	User::$user->put ();
	
	?>

## Indexed additional fields

The only limitation is that since it's a single field, you will need to implement your own index if you need to index users by one of these fields. This is fairly easy to do with a reverse-lookup database table of the form:

	create table user_fieldname(
		id integer primary key,
		fieldname char(32) not null,
		user int not null,
		index (fieldname)
	);

Then you can easily retrieve all users with a single field value via:

	select * from user_fieldname where fieldname = ""value"";

Or if you want the values to be unique to the user, use:

	create table user_fieldname(
	   fieldname char(32) not null,
	   user int not null,
	   primary key (fieldname)
	);

This type of table can be handy for things like associating unique external identifiers with users in Elefant.