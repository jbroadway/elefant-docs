# CRUD Generator

Elefant provides a simple [CRUD](http://en.wikipedia.org/wiki/Create,_read,_update_and_delete) generator as a command line tool to help developers save time by avoiding repetitive boilerplate code.

To create a new Elefant app with auto-generated CRUD handlers, run the following command from the root of the site:

	./elefant crud-app contact id name email phone added

This will generate the following:

* A new app structure under `apps/contacts`
* A new `Contacts` entry under Elefant's Tools menu
* A sample table schema for each database type with the specified fields (id, name, email, phone, added) under `apps/contacts/conf/install_*.sql`
* A new model class `contactsContact` used to access the database table
* Working add, edit, and delete handlers with version history support
* Default form validations under `apps/contacts/forms`

## How to customize

Starting with the example command above, the following steps will help you customize a new CRUD app.

### 1. Edit the schema

Edit the appropriate table schema file under `apps/contacts/conf`, changing fields to different types, etc. For example, you may want to change `added` to be a `datetime` field.

When you're ready, import the table schema via the following command:

	./elefant import-db apps/contacts/conf/install_sqlite.sql

> Note: Be sure to specify the correct schema file for your database.

### 2. Edit the forms

Next, edit the form validation rules and add ones specific to your fields. These are found under `apps/contacts/forms`. By default, all fields are marked as required.

In our case, we can add `email = 1` to the `[email]` section, so that email addresses are validated correctly.

You should also edit the `add.html` and `edit.html` view templates under `apps/contacts/views` and adjust the validation notices, and change any input types (by default they're all single-line text inputs).

In the above example, we'll want to remove the `added` field from the views altogether, and also make two changes to the handlers:

1. Edit `apps/contacts/handlers/add.php` and change this line:

	'added' => $_POST['added']

To this:

	'added' => gmdate ('Y-m-d H:i:s')

2. Edit `apps/contacts/handlers/edit.php` and remove the following line:

	$contact->added = $_POST['added'];

This will ensure the current date/time is set when a new contact is added, and the edit form will not affect this value on subsequent edits.

### 3. Customize the admin view

Edit the file `apps/contacts/views/admin.html` and customize the columns that are displayed. For example, let's add the `added` field to the list of fields shown, and make the email field a `mailto:` link:

	{! admin/util/dates !}
	
	<p><a href=""/contacts/add"">{""Add Contact""}</a></p>
	
	<p>
	<table width=""100%"">
		<tr>
			<th width=""21%"">{"" Name ""}</th>
			<th width=""21%"">{"" Email ""}</th>
			<th width=""21%"">{"" Phone ""}</th>
			<th width=""21%"">{"" Added ""}</th>
			<th width=""16%"">&nbsp;</th>
		</tr>
	{% foreach items %}
		<tr>
			<td>{{ loop_value->name }}</td>
			<td><a href=""mailto:{{ loop_value->email }}"">{{ loop_value->email }}</a></td>
			<td>{{ loop_value->phone }}</td>
			<td>{{ loop_value->added|I18n::date_time }}</td>
			<td>
				<a	href=""/contacts/edit?id={{ loop_value->id }}"">{""Edit""}</a> |
				<a	href=""/contacts/delete?id={{ loop_value->id }}""
					onclick=""return confirm ('{""Are you sure you want to delete this contact?""}')"">{""Delete""}</a>
			</td>
		</tr>
	{% end %}
	</table>
	</p>
	
	{! navigation/pager?style=text&url=[url]&total=[total]&count=[count]&limit=[limit] !}

What we've changed here are the following:

* Added the `{! admin/util/dates !}` line to include the localized date support.
* Added the `added` field to the table headers and adjusted the header widths.
* Made each `email` field a `mailto:` link.
* Added the `added` field to the loop, filtering it with `I18n::date_time` to format it and localize it to the current user's timezone.

### 4. Next steps

From here, you can edit your `apps/contacts/handlers/index.php` handler to provide a public-facing component to your app, or use the `contactsContact` model to integrate your contacts into other areas of your web application.

As you can see, Elefant's CRUD generation capabilities are a simple but powerful time saver for developers of all skill levels.