# Input validation

Input validation can be performed in both the form and model layers, or directly using the [Validator](http://api.elefantcms.com/visor/lib/Validator) class directly. Form validations are automatically mirrored client-side as well, so there are no needless page refreshes for simple form validations.

At its most basic, validation takes the following form:

~~~php
if (! Validator::validate ($email, 'email')) {
	// $email is not a valid email address
} else {
	// $email is a valid email address
}
~~~

If you have a list of fields to validate, you can run them all at once like this:

~~~php
$failed = Validator::validate_list (
	$_POST,
	array (
		'email' => array (
			'email' => true,
			'unique' => '#prefix#user.email'
		),
		'password' => array (
			'length' => '6+'
		)
	)
);

if (count ($failed) > 0) {
	// failed
}
~~~

## Validation files

...

## Validating forms

...

## Validating models

...

## Validation rules

...

Next: [[:Creating RESTful APIs]]