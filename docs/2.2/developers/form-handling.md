# Form handling

Form handling in Elefant is done through the [Form](https://www.elefantcms.com/visor/lib/Form)
class. The Form class provides an elegant API for handling forms, while performing
multiple levels of validation for you automatically, including:

* Referrer and request method validation
* Cross-site request forgery (CSRF) prevention
* Server-side input validation via the [Validator](https://www.elefantcms.com/visor/lib/Validator) class
* Client-side input validation via the `jQuery.verify_values` plugin

## Basic usage

The simplest usage of the Form class would be as follows:

~~~php
<?php

// create a POST form and inject the Controller
$form = new Form ('post', $this);

// pass a function to handle the submitted form
echo $form->handle (function ($form) {
	// form handling goes here
	info ($_POST);
});

?>
~~~

And the corresponding view template:

~~~html
<form method="post" id="{{_form}}">

<p>
	{"Your name"}:<br />
	<input type="text" name="name" value="{{name|quotes}}" />
	<span class="notice" id="name-notice">{"Please enter your name."}</span>
</p>

<button>{"Submit"}</button>

</form>
~~~

A couple things to note in the template:

1. The `id="{{_form}}"` sets a dynamic ID value that is used internally for referring to the form
2. Adding a `.notice` class and an ID attribute of the form `${fieldname}-notice` to a tag turns it into a validation notice. These will be shown or hidden automatically.

And finally, the corresponding validation rules:

~~~ini
; <?php /*

[name]
not empty = 1

; */ ?>
~~~

This simply says that the `name` field should not be empty. For more about validation
rules, [see here](/docs/2.2/developers/input-validation).

To run this example, save these three files with the following names:

* `apps/myapp/handlers/myform.php`
* `apps/myapp/views/myform.html`
* `apps/myapp/forms/myform.php`

Now you should be able to see a working form at the URL `/myapp/myform` on your site.
You should see a form with a single input, and when you submit the form the output
should look like this:

~~~php
Array
(
    [name] => Joe
)
~~~

Notice that if you submit the form without filling it in, you will receive a client-side
validation notice.

## Dynamic default values

To pass default values to the form dynamically, such as data from an existing database
record, you can set the `$form->data` property to any object or associative array like this:

~~~php
$form->data = array (
	'name' => 'Andy'
);
~~~

If you refresh the form, the name field should now appear with a default value of `Andy`.

## Alternate views

You'll notice the names of the files correspond with each other. By default, the Form
object uses the name of the handler to automatically connect a view template and a
validation file. This helps cut down on the necessary boilerplate for building a form.

To change the view template used to render a form, set the `$form->view` property like this:

~~~php
$form->view = 'myapp/alternate_view';
~~~

This will cause it to render the form with the template `apps/myapp/views/alternate_view.html`.

Next: [[Developers / Input validation]]
