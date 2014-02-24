# Client-side helpers

The following is a list of client-side helpers for app developers that are included in
the Elefant CMS. Most of these are written as jQuery plugins and are loaded by including
a handler in your view template (e.g., `{! admin/util/modal !}`).

## $.add_notification (msg);

Adds a notification for the current admin user (jGrowl). This is the
client-side equivalent of calling `$this->add_notification()` in any
handler.

### Usage:

~~~html
<script>
$(function () {
	$.add_notification ('The sky is falling!');
});
</script>
~~~

### Availability:

Available on any admin screen. Source is found in `apps/admin/js/top-bar.js`.

-----

## $.confirm_and_post (el, msg);

Adds a confirmation to a link and turns its data-* properties
into a POST request.

### Usage:

~~~html
<a href="/myapp/delete"
   data-id="{{id}}"
   donclick="return $.confirm_and_post (this, '{'Are you sure?'}')"
>{"Delete"}</a>
~~~

### Availability:

Available on any admin screen. Source is found in `apps/admin/js/top-bar.js`.

-----

## $.expanded_section (options);

Turns a section of a form into an expandable/collapsible section.

### Usage:

~~~html
<h4 id="extras-header">{"Extra options"}</h4>
<div id="extras-section">
	<!-- Extra content here -->
</div>

<script>
$(function () {
	$.expanded_section ({
		handle: '#extras-header',
		section: '#extras-section',
		visible: false
	});
});
</script>
~~~

### Availability:

Available on any admin screen. Source is found in `apps/admin/js/top-bar.js`.

-----

## $.i18n (text);

Translates the specified text into the current user's language,
if available. This is the JavaScript equivalent of calling
`__(text)` in any handler, and is useful when you need to include
translatable text in a .js file.

### Usage:

~~~html
<script>
$(function () {
	// This will make the text available to $.i18n()
	$.i18n_append ({
		'Some text': '{"Some text"}',
		'Another string': '{"Another string"}'
	});

	// Now fetch a translated string
	console.log ($.i18n ('Some text'));
});
</script>
~~~

### Availability:

Available on any admin screen. Source is found in `apps/admin/js/top-bar.js`.

-----

## $.open_dialog (title, html, options);

Opens a modal dialog (jQuery SimpleModal) with the specified title, html,
and SimpleModal options.

### Usage:

~~~html
{! admin/util/modal !}

<script>
$(function () {
	$.open_dialog ('Title', 'HTML goes here');
});
</script>
~~~
	
### Availability:

Available by including the `admin/util/modal` handler.

-----

## $.close_dialog ();

Closes the modal dialog opened by `$.open_dialog ()`.

### Usage:

~~~html
{! admin/util/modal !}

<script>
$(function () {
	$.close_dialog ();
});
</script>
~~~
	
### Availability:

Available by including the `admin/util/modal` handler.

-----

## {{ date_value|I18n::date }}

Converts date values to show in the current user's timezone.
Uses the jQuery localize plugin. Filters include:

* `I18n::date`
* `I18n::date_time`
* `I18n::short_date`
* `I18n::short_date_time`
* `I18n::time`

### Usage:

	{! admin/util/dates !}
	
	{{ date_value|I18n::date_time }}

### Availability:

Available by including the `admin/util/dates` handler.

-----

## $.filebrowser (options);

Provides a modal dialog to browse for files. Options include:

* `allowed`: An array of allowed file extensions.
* `callback`: A function that will be called with the chosen file link.
* `multiple`: Whether to allow multiple files to be selected.
* `path`: The path within `/files/` to default the dialog window to.
* `set_value`: The selector of an input field to update with the chosen file link.
* `thumbs`: Whether to show thumbnails instead of file names. Note: Also automatically sets allowed list to jpeg, png, and gif formats so you don't have to set allowed explicitly.
* `title`: A custom title for the dialog window.

### Usage:

~~~html
{! filemanager/util/browser !}

<input type="text" id="file" size="30" />
<input type="submit" id="browse" value="{"Browse"}" />

<script>
$(function () {
	$('#browse').click (function () {
		$.filebrowser ({
			title: '{"Choose an image"}',
			set_value: '#file',
			thumbs: true
		});
	});
});
</script>
~~~

### Availability:

Available by including the `filemanager/util/browser` handler.

-----

## $.multi_file (options);

Provides a multi-file selector based on the file browser from `filemanager/util/browser`.
Options include:

* `field`:   The selector of an input field to update with the list.
* `preview`: The selector of an element to use to contain the list preview.

### Usage:

~~~html
{! filemanager/util/multi-file !}

<p>
	{"Attach files"}:
	<div id="preview"></div>
	<input type="hidden" name="files" id="files" />
</p>

<script>
$(function () {
	$.multi_file ({
		field: '#files',
		preview: '#preview'
	});
});
</script>
~~~

This helper stores the list of files as a string delimited by `|` characters, for example:

	/files/file1.txt|/files/file2.doc|/files/file3.txt

### Availability:

Available by including the `filemanager/util/multi-file` handler.

-----

## $.multi_image (options);

Provides a multi-image selector based on the file browser from `filemanager/util/browser`.
Options include:

* `field`:   The selector of an input field to update with the list.
* `preview`: The selector of an element to use to contain the list preview.

### Usage:

~~~html
{! filemanager/util/multi-image !}

<p>
	{"Attach images"}:
	<div id="preview"></div>
	<input type="hidden" name="images" id="images" />
</p>

<script>
$(function () {
	$.multi_image ({
		field: '#images',
		preview: '#preview'
	});
});
</script>
~~~

This helper stores the list of images as a string delimited by `|` characters, for example:

	/files/file1.jpg|/files/file2.jpg|/files/file3.png

### Availability:

Available by including the `filemanager/util/multi-image` handler.

-----

## $.userchooser (options);

Provides a modal dialog to browse for users. Options include:

* `callback`: A function that will be called with the chosen user id, name, and email.
* `chosen`: A list of users that shouldn't be selectable.
* `chosen_visible`: Whether to display the disabled chosen users or hide them.
* `set_id_value`: The selector of an input or element to update with the user id.
* `set_name_value`: The selector of an input or element to update with the user name.
* `set_email_value`: The selector of an input or element to update with the user email.
* `set_mailto`: The selector of a link to set the mailto: value for.

### Usage:

~~~html
{! user/util/userchooser !}

<input type="text" id="user-id" size="30" /><br />
<a href="#" id="user-link">email</a><br />
<input type="submit" id="browse" value="{"Browse"}" />

<script>
$(function () {
	$('#browse').click (function () {
		$.userchooser ({
			set_id_value: '#user-id',
			set_name_value: '#user-link',
			set_mailto: ' #user-link',
			callback: function (id, name, email) {
				console.log (id);
				console.log (name);
				console.log (email);
			}
		});
	});
});
</script>
~~~

### Availability:

Available by including the `user/util/userchooser` handler.

-----

## Font Awesome

Elefant provides a helper for including the
[Font Awesome](http://fortawesome.github.com/Font-Awesome/) icon set.

### Usage:

~~~html
{! admin/util/fontawesome !}

<p><i class="fa fa-cogs"></i> {"Settings"}</p>
~~~

### Availability:

Available by including the `admin/util/fontawesome` handler.

-----

## Redactor

Elefant provides a helper for including the [Redactor](http://imperavi.com/redactor/) wysiwyg editor.

### Usage:

~~~html
{! admin/util/redactor !}

<textarea id="edit-me"></textarea>
<script>
$(function () {
	$('#edit-me').redactor ({
		// redactor options
	});
});
</script>
~~~

### Availability:

Available by including the `admin/util/redactor` handler.

-----

## Redactor + Integrations

In addition to the Redactor helper, Elefant includes a second helper to include the [Redactor](http://imperavi.com/redactor/) wysiwyg editor with all of the Elefant integration options enabled.

These include file and thumbnail browsers, internal link selection, autosave support, and the Dynamic Objects embed menu.

### Usage:

This helper will automatically initialize itself on the specified element. If no `field_id` is provided, it will assume `webpage-body`.

~~~html
{! admin/util/wysiwyg?field_id=webpage-body !}

<textarea id="webpage-body"></textarea>
~~~

Or you can include it and initialize it manually by setting the `field_id` to 0:

~~~html
{! admin/util/wysiwyg?field_id=0 !}

<textarea id="edit-me"></textarea>

<script>
$(function () {
	$('#edit-me').wysiwyg ();
});
</script>
~~~

### Availability:

Available by including the `admin/util/wysiwyg` handler.

-----

## Custom Fields

Elefant provides a very straight-forward way of including custom
fields in forms that act on ExtendedModel-based classes.

### Usage:

1. Add this to your form view template:

    {! admin/util/extended?extends=myappModelName !}

For update forms, pass the extended field values as well:

    {! admin/util/extended?extends=myappModelName&values=[extra|none] !}

2. For update forms, call this in the form handler function, before
calling `$model->put ()`:

~~~php
$model->update_extended ();
~~~

3. Create a link to edit the custom fields for a given class somewhere
in your app:

~~~html
<a href="/admin/extended?extends=myappModelName&name=My+Model">{"Custom Fields"}</a>
~~~

### Availability:

Available by including the `admin/util/extended` handler. See
usage section for more details.

Next: [[:Server-side helpers]]
