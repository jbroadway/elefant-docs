# Forms and input validation

> **Note:** Be sure to check out the page [[Code example: Ridiculously easy forms]] for a quick intro to using Elefant's `Form` class.

We provide a straight-forward way of handling form and other input validation through the `lib/Form.php` class. This includes a flexible validation rule set, an INI-based rule declaration format, and a jQuery plugin for applying the same validation rules client-side as occur server-side.

It also automatically verifies the request method, referrer, and transparently prevents cross-site request forgery (CSRF) attacks.

## Handler structure

Let's create a simple form:

	<?php
	
	// require POST and specify the myapp/formname validation rules
	$form = new Form ('post', 'myapp/formname');
	
	// run the form validations
	if ($form->submit ()) {
		// we can handle the form, $_POST has passed validation
		info ($_POST);
	} else {
		// create an object for our form view with the merged $_POST values
		$obj = new StdClass;
		$obj = $form->merge_values ($obj);
	
		// add the failed fields to it, if any
		$obj->failed = $form->failed;
	
		// output the form view
		echo $tpl->render ('myapp/formname', $obj);
	}
	
	?>

A couple things to note:

* Form validations go in the `forms` folder of your app.
* It is a good idea to name the handler, view, and validations the same filename.
* In real-world scenarios, `$obj` may be an object with default values. That's where `Form::merge_values` becomes more useful.

## Validation file

Now let's create some basic validations. Save this to `apps/myapp/forms/formname.php`:

	; <?php /*
	
	[name]
	not empty = 1
	
	[age]
	type = numeric
	
	[gender]
	regex = ""/^[mf]$/""
	
	; */ ?>

>If you're not familiar with PHP's INI files, the first and last line of the file wrap everything in a PHP comment block. That's why we name the file with a `.php` extension, so if anyone tries to request our INI files from a browser, the data is hidden.

The above rules tell the form the following:

* The name field must not be empty
* The age field must be an integer
* The gender must be either 'm' or 'f'

At the bottom of this page there is a full list of possible validation rules.

## Form view

First let's start with a basic form and save it to `apps/myapp/views/formname.html`:

	<form method=""post"">
	<p>Name:<br />
	<input type=""text"" name=""name"" value=""{{ name }}"" /></p>
	
	<p>Age:<br />
	<input type=""text"" name=""age"" value=""{{ age }}"" /></p>
	
	<p>Gender:<br />
	<input type=""radio"" name=""gender"" value=""m"" {% if gender == 'm' %}checked{% end %} /> Male<br />
	<input type=""radio"" name=""gender"" value=""f"" {% if gender == 'f' %}checked{% end %} /> Female</p>
	
	<p><input type=""submit"" value=""Go"" /></p>
	</form>

### Validation output

Here we've already pre-filled values so if a validation rule fails, the user doesn't have to re-enter everything. But we haven't displayed any errors for our validation rules yet, so let's add those next. First, let's add a line to our CSS to style the error notices and to hide them by default:

	.notice {
		color: #69c;
		display: none;
	}

Now we can go back to our view and add notices that we can show/hide when validation fails or gets corrected. Here's how it will look for the name field:

	<p>Name:<br />
	<input type=""text"" name=""name"" value=""{{ name }}"" />
	<span class=""notice"" id=""name-notice"">You must enter a name</span>
	</p>

The id attribute should be a combination of the field name and `-notice` for this exercise. This will be hidden by default, but we just need to add a couple lines to our view to make the appropriate notices appear:

	<script src=""http://code.jquery.com/jquery-1.5.2.min.js""></script>
	<script>
	$(function () {
		{% foreach failed %}
		$('#{{ loop_value }}-notice').show ();
		{% end %}
	});
	</script>

>We're using jQuery here because we're going to build on it for our client-side validation.

This should now show us which fields failed their validation rules each time we click submit.

### Client-side validation

Just under the jQuery include, we're going to include the `jquery.verify_values` plugin that comes with Elefant. Then we're going to use it to create a custom validation handler.

	<script src=""http://code.jquery.com/jquery-1.5.2.min.js""></script>
	<script src=""/js/jquery.verify_values.js""></script>
	<script>
	$(function () {
		$('form').verify_values ({
			handler: 'myapp/formname',
			callback: function (failed) {
				// highlight the failed elements
				for (var i = 0; i < failed.length; i++) {
					$('#' + failed[i] + '-notice').show ();
				}
			},
			reset: function (fields) {
				for (var i = 0; i < fields.length; i++) {
					$('#' + fields[i] + '-notice').hide ();
				}
			}
		});
		{% foreach failed %}
		$('#{{ loop_value }}-notice').show ();
		{% end %}
	});
	</script>

You can see we pass three parameters to `$.verify_values()`: handler, callback, and reset.

The handler refers to the validation rules handler. Pass it the same value you sent as the second parameter to the `Form()` constructor in the handler. This will fetch the validation rules for you from the server and return them as a JSON object so the plugin can evaluate them client-side.

The callback is a function you provide that gets called when fields have failed the validation. The form's submit action is also stopped when validation fails on the client-side. Here we simply loop through the failed field names and show the notices for them.

The reset is called at the start of each validation run. It's a callback function you provide that should reset anything done in your callback function. Here we simply loop through all the field names and hide their notices.

Putting it all together, we have three files, an INI file specifying our validation rules, a handler that checks whether we should render the form or handle its submission, and a view that renders our form and provides matching client-side validation from the same INI file as we use on the server-side.

## Validation rules

Here's a list of validation rules and what they do.

### `skip_if_empty = 1`

Use this to skip validation if the field has been left blank, but validate otherwise.

> Note: You must put this before the other rules, since they are evaluated in order the order they are listed.

### `file = 1`

Verifies that the field is a valid uploaded file.

### `filetype = ""jpg, png, gif""`

Verifies that an uploaded file has one of the list of valid file extensions.

### `regex = ""/foo/""`

Must match the specified regular expression.

### `type = numeric`

Must match the type. Calls the `is_*()` functions. Server-side only.

### `callback = function_name`

Calls a custom callback function that accepts the value as a single parameter and must return true or false. Server-side only.

### `email = 1`

Must be a valid email address.

### `url = 1`

Must be a valid url.

### `range = 123-456`

Must be a number within the specified range, inclusive.

### `length = ""5+""`

Must be a string of the specified length. Length can be in the forms `5`, `5+`, `12-`, or `5-12`.

### `gt = 10`

Must be greater than the value.

### `gte = 10`

Must be greater than or equal to the value.

### `lt = 20`

Must be less than the value.

### `lte = 20`

Must be less than or equal to the value

### `empty = 1`

Value must be empty.

### `contains = ""string""`

Value must contain the specified string.

### `equals = ""string""`

Value must equal the specified string.

### `date = 1`

Value must be a date of the format YYYY-MM-DD

### `time = 1`

Value must be a time of the format HH:MM:SS

### `datetime = 1`

Value must be a datetime of the format YYYY-MM-DD HH:MM:SS

### `header = 1`

Value must not contain newline characters. This helps prevent spammers from injecting headers in mail() calls.

### `unique = ""table.column""`

Value must not exist in the column of the specified table. Server-side only.

### `exists = ""folder""`
### `exists = ""folder/%s.html""`

Value must be a file that exists in the specified folder, or using the specified pattern. Server-side only.

### `matches = ""$_POST['name']""`

Value must match the value of a global or superglobal variable. Useful for ""retype password"" fields. Only `$_GET`, `$_POST`, and `$_REQUEST` values are supported on the client-side, by being translated into checks against other fields in the form.

## Negation

You can specify 'not ' in front of any rule to check for its opposite. For example:

### `not empty = 1`

### `not exists = ""files/%s""`
