# Validation in Models

Elefant models can include validation rules that work using `Validator::validate_list()`. Simply add them in one of two ways:

	<?php
	
	class MyTable extends Model {
		var $verify = array (
			'email' => array (
				'email' => 1,
				'contains' => '@domain.com'
			),
			'name' => array (
				'not empty' => 1
			)
		);
	}
	
	?>

Alternately, you can include them from an INI file like you can with forms:

	<?php
	
	class MyTable extends Model {
		var $verify = 'apps/myapp/forms/mytable.php';
	}
	
	?>

Now whenever you do a `put()` on your model, if validation fails then it will return false and set the `$error` property to `Validation failed for: fieldname` and the `$failed` property to a list of the fields that failed the validation.

For more info about validation rules, see [[Forms and input validation]].