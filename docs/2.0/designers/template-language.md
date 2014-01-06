# Template language

Elefant's template language is a shorthand format based on the popular [Mustache](http://mustache.github.com/) syntax which compiles to pure PHP code, making them extremely fast and lightweight. PHP tags can be used directly in templates as well.

The compiled templates are stored in the `cache` folder, and are easy to read should you need to read them directly to debug a problem. Any time a template file is changed, Elefant will regenerate the compiled version for you automatically.

## `{{ variables }} `

Variable tags take the form `{{ expression }}` (note: spaces are optional). These are substituted with the value of the expression in the tag, which is usually just the name of a value from the data sent to the template.

For example, the tag `{{ title }}` will be replaced with the following PHP code:

	<?php echo Template:sanitize ($data->title); ?>

Expressions offer a few shorthand forms for referring to different data sources:

Ordinary variables:

	{{ body }}              -> $data->body

Properties of objects:

	{{ contact->name }}     -> $data->contact->name

Superglobals:

	{{ $_POST.value }}      -> $_POST['value']

Constant or static method from a class:

	{{ User::is_valid() }}  -> User::is_valid()

Functions:

	{{ date('Y') }}         -> date('Y')

Global objects:

	{{ i18n.charset }}      -> $GLOBALS['i18n']->charset

As you can see, variables accept a wide range of values, making for a flexible template language while still maintaining simplicity and conciseness.

### Filters

By default, variables are filtered through the `Template::sanitize()` method. This uses `htmlspecialchars()` to convert symbols like `<` to their equivalent HTML entity, e.g., `&lt;`, so that any embedded HTML will be displayed instead of rendered. This is good for security, since it helps prevent cross-site scripting (XSS) attacks.

But sometimes you need to output the raw HTML. In this case, you would add the `|none` filter, for example:

	{{ title|none }}

This is a special filter that bypasses filtering, so the compiled PHP code would be:

	<?php echo $data->title; ?>

Sometimes you don't want to filter all HTML entities, but you need to filter quotes for use in an attribute value. For this, you can use the `|quotes` filter like this:

	value="{{ some_value|quotes }}"

This will convert any double quotes into `&quot;` entities.

Aside from the above helpers, a filter can be any PHP function or method call. For example, to use the [URLify](https://github.com/jbroadway/urlify) library to create a slug from a page title, you would say:

	{{ title|URLify::filter }}

This translates to the following PHP code in the compiled template:

	<?php echo URLify::filter ($data->title); ?>

#### Filter chains and complex filters

You can specify a series of filters to be applied to a value by appending them to the tag like this:

	{{ some_value|filter1|filter2 }}

This will produce the following PHP:

	<?php echo filter2 (filter1 ($data->some_value)); ?>

You can also specify additional parameters, or pass the expression value explicitly as a secondary parameter like this:

	{{ timestamp|date ('F j', %s) }}

This will produce the following PHP:

	<?php echo date ('F j', $data->timestamp); ?>

## `{% if conditions %}`

You can use conditional logic with the following tags:

	{% if some_value %}
		One
	{% elseif some_other_value %}
		Two
	{% else %}
		None
	{% end %}

Expressions in conditions are the same as in variable tags, with one thing to note: To see if something is false, use `value == false` and not `!value`. The parser relies on the variable substitutions happening at the start of the expression, so the `!` will get it confused.

## `{% for loops %}`

Templates also support looping using a syntax similar to conditions:

	{% foreach pages %}
		{{ loop_index }}: {{ loop_value }}<br />
	{% end %}

This is equivalent to the following PHP code:

	<?php
	
	foreach ($data->pages as $data->loop_index => $data->loop_value) {
		echo $data->loop_index . ': ' . $data->loop_value . '<br />';
	}
	
	?>

The `{% foreach %}` tag takes the same values as variables and conditions, but the expression must result in an array to be looped over.

You can also specify your own names for the `loop_index` and `loop_value` like this:

	{% foreach pages as _key, _page %}
		{{ _key }}: {{ _page }}<br />
	{% end %}

> Note that the underscore prefixes are optional, but are a helpful naming convention
> for loop values in templates since regular names have the potential of overwriting
> existing values sent to the template.

## `{" translatable text "}`

If you include hard-coded text in your template that you want to be translatable, simply wrap it in tags like this:

	{" Welcome to our website! "}

These strings will be converted to the following PHP:

	<?php echo __ ("Welcome to our website!"); ?>

Text that is marked as translatable will automatically be indexed and available for translation through the Tools > Languages app.

Note: Single-quotes are allowed too, e.g., `{' Welcome to our website! '}`.

## `{% inc sub_template %}`

To include one template in another, specify the template name minus the `.html` file extension like this:

	{% inc sub_template %}

You can also refer to templates inside a theme folder:

	{% inc mytheme/header %}

This will produce the following PHP:

	<?php echo $this->render ('mytheme/header', $data); ?>

Which would match the file `layouts/mytheme/header.html`.

> Note that you must take care to avoid naming conflicts between apps and themes,
> since this include syntax will first check for `apps/mytheme/views/header.html`
> and then check for `layouts/mytheme/header.html`, since templates with paths
> usually refer to view templates within apps.

## `{! include/handlers !}`

Dynamic includes let you include handlers from any app directly into your templates, for example:

	{! navigation/top !}

This will produce the following PHP:

	<?php echo $this->controller->run ('navigation/top'); ?>

You can also pass parameters to a handler by adding them like parameters on a URL request:

	{! navigation/section?section=services !}

This will result in `['section' => 'services']` being passed to the `navigation/section` handler.

## `{# hardcoded/includes #}`

Hard-coded includes work just like dynamic includes, except that instead of producing a PHP tag, the handler is called on the spot and its output is hard-coded directly into the compiled template.

This difference means that there is no PHP overhead for hard-coded includes after the template is compiled, making them extremely fast, but the output of the include will not change again until the template is recompiled again or the cache is cleared.

Next: [[:Available template tags]]