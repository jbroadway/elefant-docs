# Form handling

Form handling in Elefant is done through the [Form](http://api.elefantcms.com/visor/lib/Form)
class. The Form class provides an elegant API for creating your forms, while performing
multiple levels of validation for you automatically, including:

* Referrer and request method validation
* Cross-site request forgery (CSRF) prevention
* Input validation via the [Validator](http://api.elefantcms.com/visor/lib/Validator) class
* Automatic client-side validation via a `jQuery.verify_values` plugin

## Simple usage

The simplest usage of the Form class would be as follows:

~~~php
<?php

$form = new Form ('post', $this);

echo $form->handle (function ($form) {
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

And finally, the corresponding validation rules:

~~~ini
; <?php /*

[name]
not empty = 1

; */ ?>
~~~

To run this example, save these three files with the following names:

* `apps/myapp/handlers/myform.php`
* `apps/myapp/views/myform.html`
* `apps/myapp/forms/myform.php`

Now you should be able to see a working form at the URL `/myapp/myform` on your site.

Next: [[Developers / Input validation]]
