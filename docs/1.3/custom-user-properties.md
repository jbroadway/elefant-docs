# Custom user properties

Elefant's user object contains a limited set of properties that most sites will need for their users. These include:

* Unique identifier
* Email address
* Password
* Session ID and expiry time
* Name
* Type (built-in types are 'admin' and 'member')
* Date they signed up
* Date they were last updated

As you can see, these are far from exhaustive. However, there is one additional property User objects have that allows for arbitrary data to be associated with a user, called `$userdata`. It automatically encodes and decodes any data saved to it in a JSON array.

Here's how you use it:

### Storing custom data

	<?php
	
	// fetch a user
	$u = new User ($user_id);
	
	// get the existing userdata array
	$data = $u->userdata;
	
	// add some data to it
	$data['my_custom_field'] = 'some value';
	
	// save it back to the user object
	$u->userdata = $data;
	
	// save it to the database
	$u->put ();
	
	?>

### Removing custom data

Similarly, removing data is as easy as:


	<?php
	
	// fetch a user
	$u = new User ($user_id);
	
	// get the existing userdata array
	$data = $u->userdata;
	
	// remove the custom data field
	unset ($data['my_custom_field']);
	
	// save it back to the user object
	$u->userdata = $data;
	
	// save it to the database
	$u->put ();
	
	?>
