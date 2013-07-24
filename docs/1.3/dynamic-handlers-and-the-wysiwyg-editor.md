# Dynamic handlers and the wysiwyg editor

In Elefant, you can configure handlers to be able to be dynamically embedded into pages and blocks by users through the wysiwyg editor, through a custom Dynamic Objects dialog. This generates an include tag for the user that, when the page is rendered, will become the selected dynamic object (aka handler).

Here are a few screenshots of how it looks to the user:

![wysiwyg dynamic objects - step 1](/files/docs/dynamic1.png)

![wysiwyg dynamic objects - step 2](/files/docs/dynamic2.png)

![wysiwyg dynamic objects - step 3](/files/docs/dynamic3.png)

![wysiwyg dynamic objects - step 4](/files/docs/dynamic4.png)

## Configuring your handlers

Elefant uses an INI file named `conf/embed.php` inside each app to list embeddable handlers. The most basic example of such a file would be:

	; <?php /*
	
	[appname/myhandler]
	
	label = My Label
	
	; */ ?>

This will tell the wysiwyg editor that `appname/myhandler` is dynamically embeddable, and to call it ""My Label"" when shown to users.

Additionally, if you have an embed object with many options:

	; <?php /*
	
	[appname/myhandler]
	
	label = My Label
	columns = 2
	
	; */ ?>

Adding the `columns = 2` will automatically format the form to be two columns instead of the default one. Only one or two column layouts are currently available.

Each handler has its own section in the `conf/embed.php` file of your app. All embed files are read at once and the handlers are listed alphabetically by label in the wysiwyg editor. To keep your handlers organized, you can optionally prefix their names like this:

	label = ""App: Label""

### Custom parameters

Some handlers require custom parameters in order to be useful. Elefant handles this by allowing an arbitrary number of additional elements in each INI block, using the following format:

	; <?php /*
	
	[appname/myhandler]
	
	label = My Label
	
	param_1[label] = Enter some text
	param_1[type] = text
	param_1[initial] = Default value
	
	param_2[label] = A select box
	param_2[type] = select
	param_2[require] = ""apps/appname/lib/Functions.php""
	param_2[callback] = ""appname_param2_get_values""
	param_2[filter] = ""appname_my_filter""
	
	; */ ?>

There's a lot going on here, so let's break it down line by line:

	param_1[label] = Enter some text

This tells Elefant that there's a parameter `param_1` that serves as input to your handler. It also gives it a label for displaying to the user.

	param_1[type] = text

This simply tells Elefant that this should be a text field. Currently, the possible field types are `text`, `textarea`, `select`, and `file`.

	param_1[initial] = Default value

This sets a default value for the input field.

	param_2[require] = ""apps/appname/lib/Functions.php""

This tells Elefant that this field should include the specified file to define a callback that will send it a list of possible values.

	param_2[callback] = ""appname_param2_get_values""

This is the name of a PHP function that provides a list of possible values to the select box.

	param_2[filter] = ""appname_my_filter""

This is the name of a PHP function that takes the entered value, filters it, and returns the result. It is used, for example, in the ""Embed HTML Code"" handler (`admin/html`) to save the HTML and return an ID value in its place. The `admin/html` handler uses the ID to fetch the original HTML when the page is rendered, and the ID is shorter for embedding into the page body.

Functions that act as filters take the following format, which provides for filtering and reversal of the filter (for when a user edits a dynamic object in the WYSIWYG editor):

	<?php
	
	function appname_my_filter ($data, $reverse = false) {
		if ($reverse) {
			// return the original data
			return base64_decode ($data);
		}
		// return the filtered data
		return base64_encode ($data);
	}
	
	?>

## Input validation

You can also specify input validation rules for fields in the embed form like this:

	; <?php /*
	
	[appname/myhandler]
	
	label = My Label
	
	param_1[label] = Enter some text
	param_1[type] = text
	param_1[initial] = Default value
	param_1[not empty] = 1
	param_1[regex] = ""/^[a-z0-9]+$/i""
	param_1[message] = ""Please enter an alphanumeric value.""
	
	; */ ?>

The `message` value will display as your error message if any of the validation rules fail. Each validation rule is specified as a separate line using the same rules that are available to all forms in Elefant (see [[Forms-and-input-validation]]).