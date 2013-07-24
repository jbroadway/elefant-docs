# CRUD Tutorial

> Note: Elefant also features a complete [[CRUD Generator]] that can save you typing all of the boilerplate code below. This is meant as a tutorial for learning how to build admin interfaces in Elefant.

This tutorial is going to walk you through creating the basic [CRUD](http://en.wikipedia.org/wiki/Create,_read,_update_and_delete) components for an admin interface of a custom Elefant app. The app we'll be building will be a basic contact manager, which we'll call *Contacts*.

The full source code for this tutorial is available [here on GitHub](http://github.com/jbroadway/contacts).

## 1. Create a new app

We can create a new Elefant app outline with the following commands:

	cd /path/to/your/website
	./elefant build-app contacts

This creates the basic folder structure and some default files for us under `apps/contacts`. Once you've run the commands, take a look at the folders and files that it created for you.

## 2. Database schema

We're only going to use one table for our database schema, and to keep this tutorial short, we'll only create a few fields in it. You can save this file to `apps/contacts/conf/install_sqlite.sql`:

	create table contacts (
		id integer primary key,
		name char(48) not null,
		email char(48) not null,
		phone char(32) not null
	);

For MySQL, use:

	create table contacts (
		id int not null auto_increment primary key,
		name char(48) not null,
		email char(48) not null,
		phone char(32) not null
	);

An easy way to install your schema is to use the [DB Manager](http://github.com/jbroadway/dbman) app's SQL Shell. If you're packaging an app for others to use however, you'll want to take a look at [creating an installer](/wiki/Installing-and-upgrading-apps).

## 3. Create the model

The model for our app is very simple:

	<?php
	
	namespace contacts;
	
	class Contact extends Model {
		public $table = 'contacts';
	}
	
	?>

This simply defines a new model class called `Contact` and points it to our `contacts` table.

## 4. Validation rules

While we're defining things, let's go ahead and create some validation rules for our add and edit handlers. Save this to both `apps/contacts/forms/add.php` and `apps/contacts/forms/edit.php`:

	; <?php /*
	
	[name]
	not empty = 1
	
	[email]
	not empty = 1
	email = 1
	
	[phone]
	not empty = 1
	
	; */ ?>

These files will be referenced automatically when we create our add and edit forms. They're just telling the forms that all fields must not be empty, and that the email address should be validated as such.

## 5. Admin handler

The admin handler has already been setup for us, but we're going to make some changes to it. If you'd like to see what it defaults to, you can already find it under Tools > Contacts in the Elefant admin toolbar.

We're going to change it to this:

	<?php
	
	$this->require_admin ();
	
	$page->layout = 'admin';
	$page->title = __ ('Contacts');
	
	// Calculate the offset
	$limit = 20;
	$num = isset ($this->params[0]) ? $this->params[0] : 1;
	$offset = ($num - 1) * $limit;
	
	// Fetch the items and total items
	$items = contactsContact::query ()->fetch ($limit, $offset);
	$total = contactsContact::query ()->count ();
	
	// Pass the data to the view template
	echo $tpl->render (
		'contacts/admin',
		array (
			'limit' => $limit,
			'total' => $total,
			'items' => $items,
			'count' => count ($items),
			'url' => '/contacts/admin/%d'
		)
	);
	
	?>

A few things to note here:

* For paging results, our URLs will take the form `/contacts/admin/n` where `n` is the page number.
* We calculate the offset value from the page number and limit.
* The `limit`, `total`, `count`, and `url` values are needed by the `navigation/pager` handler that we'll be embedding into our view to generate the paging links.
* The `url` value will tell `navigation/pager` the format of the URLs and where to find the page number in them.

Aside from a bit of extra work for paging, this handler is pretty short. Now let's create the corresponding view template, which we'll name `apps/contacts/views/admin.html`:

	<p><a href=""/contacts/add"">{""Add Contact""}</a></p>
	
	<p>
	<table width=""100%"">
		<tr>
			<th width=""35%"">{""Name""}</th>
			<th width=""25%"">{""Email""}</th>
			<th width=""25%"">{""Phone""}</th>
			<th width=""15%"">&nbsp;</th>
		</tr>
	{% foreach items %}
		<tr>
			<td>{{ loop_value->name }}</td>
			<td><a href=""mailto:{{ loop_value->email }}"">{{ loop_value->email }}</a></td>
			<td>{{ loop_value->phone }}</td>
			<td>
				<a	href=""/contacts/edit?id={{ loop_value->id }}"">{""Edit""}</a> |
				<a	href=""/contacts/delete"" data-id=""{{ loop_value->id }}""
					onclick=""return $.confirm_and_post (this, '{""Are you sure you want to delete this contact?""}')""
				>{""Delete""}</a>
			</td>
		</tr>
	{% end %}
	</table>
	</p>
	
	{! navigation/pager?style=text&url=[url]&total=[total]&count=[count]&limit=[limit] !}

Here we've created a simple table of output with an add link at the top and edit and delete links beside each row. The pager has been included at the bottom of the table.

Note the use of `$.confirm_and_post()` in the delete link. This is a special [client-side helper](/wiki/JavaScript-and-Client-Side-Helpers) that makes it easier to send POST requests for things like delete links.

## 6. Add form

Next we'll create a file named `apps/contacts/handlers/add.php` with the following code:

	<?php
	
	$this->require_admin ();
	
	$page->layout = 'admin';
	$page->title = __ ('Add Contact');
	
	$form = new Form ('post', $this);
	
	echo $form->handle (function ($form) {
		// Create and save a new contact
		$contact = new contactsContact (array (
			'name' => $_POST['name'],
			'email' => $_POST['email'],
			'phone' => $_POST['phone']
		));
		$contact->put ();
	
		if ($contact->error) {
			// Failed to save
			$form->controller->add_notification (__ ('Unable to save contact.'));
			return false;
		}
	
		// Save a version of the contact
		Versions::add ($contact);
	
		// Notify the user and redirect on success
		$form->controller->add_notification (__ ('Contact added.'));
		$form->controller->redirect ('/contacts/admin');
	});
	
	?>

Forms are handled via a callback function, with the validation and rendering being handled for you automatically. In the handler function that we pass to `$form->handle()` we create and save the contact, handle the error if there should be one, save a version to Elefant's version history, and respond to the user.

For admin forms in Elefant, the standard is to set a notification and redirect back to the main screen of the app.

Now we need to create the corresponding view template (`apps/contacts/views/add.html`):

	<form method=""post"" id=""{{ _form }}"">
	
	<p>
		{""Name""}:<br />
		<input type=""text"" name=""name"" value=""{{ name|quotes }}"" />
		<span class=""notice"" id=""name-notice"">{""Please enter a name.""}</span>
	</p>
	
	<p>
		{""Email""}:<br />
		<input type=""text"" name=""email"" value=""{{ email|quotes }}"" />
		<span class=""notice"" id=""email-notice"">{""Please enter a valid email address.""}</span>
	</p>
	
	<p>
		{""Phone""}:<br />
		<input type=""text"" name=""phone"" value=""{{ phone|quotes }}"" />
		<span class=""notice"" id=""phone-notice"">{""Please enter a phone number.""}</span>
	</p>
	
	<p><input type=""submit"" value=""{""Add Contact""}"" /></p>
	
	</form>

You can see we've added notices for the validation rules. These will automatically be toggled on/off if validation rules fail when the user submits the form.

Try adding some contacts to the app, since the add form is done. Since we named our validation file, handler, and view template the same, Elefant's Form class automatically connects them together for us.

Two other benefits Elefant's Form class offers are automatic CSRF protection, and matching client- and server-side validation. That way there's no round-trip to the server and page re-rendering when input fails to validate.

## 7. Edit form

Our edit form will be very similar to our add form with only a few very minor differences:

	<?php
	
	$this->require_admin ();
	
	$page->layout = 'admin';
	$page->title = __ ('Edit Contact');
	
	$form = new Form ('post', $this);
	
	$form->data = new contactsContact ($_GET['id']);
	
	echo $form->handle (function ($form) {
		// Update the contact
		$contact = $form->data;
		$contact->name = $_POST['name'];
		$contact->email = $_POST['email'];
		$contact->phone = $_POST['phone'];
		$contact->put ();
	
		if ($contact->error) {
			// Failed to save
			$form->controller->add_notification (__ ('Unable to save contact.'));
			return false;
		}
	
		// Save a version of the contact
		Versions::add ($contact);
	
		// Notify the user and redirect on success
		$form->controller->add_notification (__ ('Contact saved.'));
		$form->controller->redirect ('/contacts/admin');
	});
	
	?>

The first difference is the line that sets `$form->data`, which fetches the contact we want to edit so that it can populate the form fields with it.

The next difference is that we're updating the existing contact's values instead of creating a new one. As you can see, we use `$contact = $form->data` instead of fetching the contact over again, avoiding fetching it from the database twice.

The edit view (`apps/contacts/views/edit.html`) is also very similar, with the only difference being the label of the submit button:

	<form method=""post"" id=""{{ _form }}"">
	
	<p>
		{""Name""}:<br />
		<input type=""text"" name=""name"" value=""{{ name|quotes }}"" />
		<span class=""notice"" id=""name-notice"">{""Please enter a name.""}</span>
	</p>
	
	<p>
		{""Email""}:<br />
		<input type=""text"" name=""email"" value=""{{ email|quotes }}"" />
		<span class=""notice"" id=""email-notice"">{""Please enter a valid email address.""}</span>
	</p>
	
	<p>
		{""Phone""}:<br />
		<input type=""text"" name=""phone"" value=""{{ phone|quotes }}"" />
		<span class=""notice"" id=""phone-notice"">{""Please enter a phone number.""}</span>
	</p>
	
	<p><input type=""submit"" value=""{""Save Contact""}"" /></p>
	
	</form>

## 8. Delete handler

The last step in our CRUD application is the delete handler. Using notifications, we can skip the view template entirely for our delete handler, so it just becomes a matter of a few lines of code:

	<?php
	
	$this->require_admin ();
	
	$contact = new contactsContact;
	$contact->remove ($_POST['id']);
	
	if ($contact->error) {
		$this->add_notification (__ ('Unable to delete contact.'));
		$this->redirect ('/contacts/admin');
	}
	
	$this->add_notification (__ ('Contact deleted.'));
	$this->redirect ('/contacts/admin');
	
	?>

As always, we keep unwanted requests out with a `$this->require_admin()` call. Then we create a blank Contact object and call `$contact->remove()` with the ID we passed to the handler.

[Click here](http://github.com/jbroadway/contacts) for the full source code of this tutorial. As you can see, creating CRUD components in Elefant is easy using the Model and Form classes. From here, try adding more fields to your contacts or building a public-facing directory of contacts. If you run into trouble, [visit the forum for help!](/forum/)