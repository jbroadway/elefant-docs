# Input validation

Input validation can be performed in both the form and model layers, or directly using the [Validator](https://www.elefantcms.com/visor/lib/Validator) class directly. Form validations are automatically mirrored client-side as well, so there are no needless page refreshes for simple form validations.

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

Validation rules can be stored in INI format, which makes them more readable, and helps keep your code free from lengthy lists comparisons. The standard practice is to put these files into the `forms` folder in your app.

A validation file looks like this, with section blocks for each field:

~~~ini
; <?php /*

[email]

email = 1
unique = "#prefix#user.email"

[password]

length = "6+"

; */ ?>
~~~

The `= 1` is used in validation rules that don't require additional info to process. The value here isn't important, so `email = ""` or `email = On` are both perfectly valid too, but since `= 1` is shorter it has found more popular use.

## Validating forms

Elefant makes validating forms very natural with a little autoloading magic. When you call [`$form->handle()`](https://www.elefantcms.com/visor/lib/Form#method-handle) without specifying any validations, it will look for a validation file with the same name as the handler in the `forms` folder and use those to validate your form.

For example, if your form is saved to `apps/myapp/handlers/myform.php`, your validations will be automatically loaded from the file `apps/myapp/forms/myform.php`. Elefant will also automatically create corresponding client-side validations for you as well.

> Similarly, your view template will automatically be linked as `apps/myapp/views/myform.html`.

To connect your validations to the form in your view template, the template needs two things:

1\. Add an id attribute to the `<form>` tag like this:

~~~html
<form method="post" id="{{_form}}">
~~~

2\. Add notices for any fields that could fail like this:

~~~html
<span class="notice" id="email-notice">{"Please enter a valid email."}</span>
~~~

These notices will automatically be shown or hidden as needed. Note that the id attribute of the notice must take the form `{$fieldname}-notice` for everything to link up correctly.

## Validating models

To validate the data being saved in your models, simply define your validations in the `$verify` property of the model, or specify a file that contains the validation rules. For example:

~~~php
class MyTable extends Model {
	public $verify = array (
		'name' => array (
			'not empty' => true
		)
	);
}
~~~

Or with a file:

~~~php
class MyTable extends Model {
	public $verify = 'apps/myapp/forms/mytable.php';
}
~~~

Now whenever you do a `put()` on your model, it will first run your validation rules on the data being saved. If anything fails, `put()` will return false, set the `$error` property to `Validation failed for: fieldname`, and set the `$failed` property to a list of the fields that failed the validation.

## Validation rules

Here's a list of validation rules and what they do.

#### `skip_if_empty = 1`

Use this to skip validation if the field has been left blank, but validate otherwise.

> Note: You must put this before the other rules, since they are evaluated in the order they are listed.

#### `file = 1`

Verifies that the field is a valid uploaded file.

#### `filetype = "jpg, png, gif"`

Verifies that an uploaded file has one of the list of valid file extensions.

#### `regex = "/foo/"`

Must match the specified regular expression.

#### `type = numeric`

Must match the type. Calls the `is_*()` functions. Server-side only.

#### `callback = function_name`

Calls a custom callback function that accepts the value as a single parameter and must return true or false. Server-side only.

#### `email = 1`

Must be a valid email address.

#### `url = 1`

Must be a valid url.

#### `range = 123-456`

Must be a number within the specified range, inclusive.

#### `length = "5+"`

Must be a string of the specified length. Length can be in the forms `5`, `5+`, `12-`, or `5-12`.

#### `gt = 10`

Must be greater than the value.

#### `gte = 10`

Must be greater than or equal to the value.

#### `lt = 20`

Must be less than the value.

#### `lte = 20`

Must be less than or equal to the value

#### `empty = 1`

Value must be empty.

#### `contains = "string"`

Value must contain the specified string.

#### `equals = "string"`

Value must equal the specified string.

#### `date = 1`

Value must be a date of the format YYYY-MM-DD

#### `time = 1`

Value must be a time of the format HH:MM:SS

#### `datetime = 1`

Value must be a datetime of the format YYYY-MM-DD HH:MM:SS

#### `header = 1`

Value must not contain newline characters. This helps prevent spammers from injecting headers in mail() calls.

#### `unique = "table.column"`

Value must not exist in the column of the specified table. Server-side only.

#### `exists = "folder"`<br>`exists = "folder/%s.html"`

Value must be a file that exists in the specified folder, or using the specified pattern. Server-side only.

#### `matches = "$_POST['name']"`

Value must match the value of a global or superglobal variable. Useful for ""retype password"" fields. Only `$_GET`, `$_POST`, and `$_REQUEST` values are supported on the client-side, by being translated into checks against other fields in the form.

### Negation

You can specify 'not ' in front of any rule to check for its opposite. For example:

#### `not empty = 1`<br>`not exists = "files/%s"`

### Lists

For array elements (e.g., `<input name="name[]" />`), you can also specify 'each' in front of any rule and the rule will be applied to each element of the array instead of the array itself. Note that the 'each' must come before 'not', for example "each email" would make sure each is a valid email address, and "each not empty" would make sure each is not empty.

#### `each type = numeric`<br>`each not empty = 1`

Next: [[:Modelling your data]]
