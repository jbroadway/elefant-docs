# User-configurable app settings

In general, users should never have to modify the original files within an app. Elefant provides a means of overriding app settings without having to edit the app's original configuration file.

How it works is when an app's configuration is loaded by the [Appconf](http://api.elefantcms.com/visor/lib/Appconf) class, it also checks for the existence of a custom configuration file, named in the following pattern:

	conf/app.{$appname}.{ELEFANT_ENV}.php

`ELEFANT_ENV` defaults to `config` if it's not set to something else via an environment variable, so the custom configurations for the `blog` app would be stored in:

	conf/app.blog.config.php

## Building a settings form

> Note: This section assumes you've gone through the [[Developers / form handling]] pages.

Let's assume the following settings that we want to make editable in our app:

~~~ini
; <?php /*

[Myapp]

title = My App

notify = you@example.com

; */ ?>
~~~

Let's say that the `title` should be a text field and should be required, and `notify` should be an email address, but may be left blank. Here would be our validations, saved to `apps/myapp/forms/settings.php`:

~~~ini
; <?php /*

[title]

not empty = 1

[notify]

skip_if_empty = 1
email = 1

; */ ?>
~~~

And here is the outline of our handler, saved to `apps/myapp/handlers/settings.php`:

~~~php
<?php

// keep unauthorized users out
$this->require_acl ('admin', $this->app);

// set the layout and page title
$page->layout = 'admin';
$page->title = __ ('Myapp Settings');

// create the form
$form = new Form ('post', $this);

// set the form data from the app settings
$form->data = array (
	'title' => Appconf::myapp ('Myapp', 'title'),
	'notify' => Appconf::myapp ('Myapp', 'notify')
);

echo $form->handle (function ($form) {
	// merge the new values into the settings
	$merged = Appconf::merge ('myapp', array (
		'Myapp' => array (
			'title' => $_POST['title'],
			'notify' => (! empty ($_POST['notify'])) ? $_POST['notify'] : false
		)
	));

	// save the settings to disk
	if (! Ini::write ($merged, 'conf/app.myapp.' . ELEFANT_ENV . '.php')) {
		printf (
			'<p>%s</p>',
			__ ('Unable to save changes. Check your permissions and try again.')
		);
		return;
	}

	// redirect to the main admin page with a notification
	$form->controller->add_notification (__ ('Settings saved.'));
	$form->controller->redirect ('/myapp/admin');
});

?>
~~~

And finally, the form template, saved to `apps/myapp/views/settings.html`:

~~~html
<div class="form">
<form method="post" id="{{_form}}">

<p>
	{"Title"}:<br />
	<input type="text" name="title" value="{{ title|quotes }}" size="40" />
	<span class="notice" id="title-notice">{"Please enter a title."}</span>
</p>

<p>
	{"Email"}:<br />
	<input type="email" name="notify" value="{{ notify|quotes }}" size="40" />
	<span class="notice" id="notify-notice">{"Please enter a valid email."}</span>
</p>

<p>
	<button>{"Save Settings"}</button>
	<a href="/myapp/admin"
	   onclick="return confirm ('{'Are you sure you want to cancel?'}')">{"Cancel"}</a>
</p>

</form>
</div>
~~~

Now simply link to `/myapp/settings` where you want your settings link to appear. As you can see, minimal code is needed to provide an easy settings form for your admin users, and there's no need for them to ever see your configuration files directly.

Back: [[Developers / App configurations]]
