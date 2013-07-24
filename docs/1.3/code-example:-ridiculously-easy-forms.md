# Code example: Ridiculously easy forms

This example shows how to use the `Form::handle()` method to eliminate almost all of the usual boilerplate code needed to get a form up and running.

## 1. Describe your form

First, we create a rules file for our form, describing rules for each field and also providing default values. Let's call this `apps/myapp/forms/myform.php` and enter the following:

	; <?php /*
	
	[name]
	not empty = 1
	
	[age]
	default = 18
	gte = 18 ; must be over 18
	
	[comments]
	default = ""Enter your comments here.""
	
	; */ ?>

This tells us several things about our form:

* We want the name to not be empty, but have no default value.
* The age defaults to 18, and they must be 18 or over.
* The comments have a default value, but no rules.

For a full list of validation rules, [see here.](/wiki/Forms-and-input-validation#validation-rules)

## 2. Create the handler

Since we called the form rules `myform.php`, we're going to make sure both the handler and the view match this as well. This keeps things simple for us, since the `Form` object will assume they match by default.

So for our handler, create the file `apps/myapp/handlers/myform.php` and enter:

	<?php
	
	// create the form and give it the controller
	$form = new Form ('post', $this);
	
	// create a basic handler that dumps the input
	echo $form->handle (function ($form) {
		// form handling goes here
		info ($_POST);
	});
	
	?>

That's it for our handler. The anonymous function we passed to the `handle()` method will be called for us and its output returned. That is, unless it explicitly returns false, in which case there will be no output and your handler can act accordingly.

> **Tip:** You can access the Controller object of the handler via `$form->controller` from inside the anonymous function.

## 3. Displaying the form

Now it's time to add our view template so we can see the form. Views are ordinary Elefant templates so that you have complete control over your form display.

Also notice that client-side validation via `/js/jquery.verify_values.js` is included for you automatically (or you can use `$form->js_validation = false` to disable that and use your own custom client-side validation configuration).

In the file `apps/myapp/views/myform.html` enter the following:

	<form method=""POST"" id=""{{ _form }}"">
	
	<p>{""Name""}:<br /><input type=""text"" name=""name"" value=""{{ name|quotes }}"" />
	<span class=""notice"" id=""name-notice"">{""Please enter your name.""}</span></p>
	
	<p>{""Age""}:<br /><input type=""text"" name=""age"" value=""{{ age|quotes }}"" />
	<span class=""notice"" id=""age-notice"">{""Please enter your age.""}</span></p>
	
	<p>{""Comments""}:<br /><textarea name=""comments"" cols=""50"">{{ comments|quotes }}</textarea></p>
	
	<p><input type=""submit"" value=""{""Submit""}"" /></p>
	
	</form>

If you name your validation notice tags with a `.notice` class and ID attributes matching the format `fieldname-notice`, you can use the style and script components from the above verbatim in most forms, leaving just the `<form>` itself for you to worry about.

Now you should be able to go to `/myapp/myform` at your website in a web browser and see your working form in action.

## Dynamic default values

To pass default values to the form dynamically, such as from an existing database record, you can set the `$form->data` property to any object or associative array like this:

	$form->data = array (
		'field1' => 'default value',
		'field2' => 'default value'
	);

If the form is submitted and re-rendered, these values will automatically be overridden by the user-submitted data in the view.

## Alternate views

You can change the view template used to render the form by setting the `$form->view` property like this:

	$form->view = 'myapp/alternate-view';

This will cause it to render with the template `apps/myapp/views/alternate-view.html`.

## Conclusion

As you can see, Elefant's `Form` class gives you a lot of flexibility with very little boilerplate, especially in your handlers, allowing you to keep your application logic clear and organized.

For more info, see [[Forms and input validation]].