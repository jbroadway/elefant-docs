# Templates

Templates are used for two things, views and layouts. A view is the output for a particular handler. A layout then provides the overall style for multiple handlers, the _design_ of your site. Views live in the `views` folder inside your apps. Layouts are stored in the global `layouts` folder.

Templates use a style of tagging inspired by Django's template engine as well as [Mustache](http://mustache.github.com/) and some others, and inline PHP tags are valid too if you prefer straight PHP-based templating. It then compiles templates to PHP code and caches the PHP files in the global `cache` folder. Any time the HTML template is modified, it will see the changed file modification time and re-generate the PHP automatically. This means templates benefit from opcode caching and other performance benefits of pure PHP, but we get to use a simplified tag syntax.

## Variables

Tags in templates take the form `{{tag}}` or `{{ tag }}` (spaces are optional). These are substituted with a variable of one the following forms:

Variables passed to `Template::render`:

    {{ body }} -> $data->body
    
    {{ contact->name }} -> $data->contact->name

Super-globals:

    {{ $_POST.value }} -> $_POST['value']

Constant or static method from a class:

    {{ User::is_valid() }} -> User::is_valid()

Functions:

    {{ date('Y') }}

Global objects:

    {{ i18n.charset }} -> $GLOBALS['i18n']->charset

As you can see, it accepts a wide range of values, making for a flexible template language while still maintaining simplicity.

## Includes and blocks

Elefant has a shorthand for including one templates from inside another:

    {% inc other_template %}

You can also include templates inside themes, so say you have a theme with the following structure:

    layouts/mytheme/
        footer.html
        header.html
        mytheme.html

The main theme can then include the others like this:

    {% inc mytheme/header %}
    
    <h1>{{ title }}</h1>
    
    {{ body|none }}
    
    {% inc mytheme/footer %}

In this way, complex themes can be kept well organized.

> Note that you should be careful to name your themes to avoid naming conflicts with apps, since this include syntax will first check for `apps/myapp/views/mytemplate.html` and then check for `layouts/mytheme/mytemplate.html`, since templates with paths usually mean to refer to views within apps.

### Dynamic includes

Elefant has a shorthand for including handlers into a template (also works in the body of a page or block!):

    {! app/handler?param=value !}

This calls `$controller->run ('app/handler', array ('param' => 'value'))` for you within a template, including the handler's output at that spot in your template. This is handy for things like user logins and other dynamic includes in your templates that could otherwise require lots of tags and make templates ugly.

Some of the built-in handlers you can use are:

* `admin/forward?to=http://external.com` - Forward the current request to another URL
* `admin/head` - Outputs the Elefant CMS admin bar if you're logged in as an admin
* `admin/menu` - Outputs a list of pages as a menu, which you can then style with CSS
* `block/block-id` - Creates a dynamic content block that you can edit through the CMS
* `blog/headlines` - Outputs a list of recent posts
* `blog/tags` - Outputs a tag cloud for your blog
* `filemanager/slideshow?path=folder` - Renders a slideshow of images from a subfolder of `files`
* `search/index` - Creates a search form for your site
* `social/facebook/commentcount` - Number of comments made on the current page
* `social/facebook/comments` - Display a comment thread using the Facebook API
* `social/facebook/like` - Add a Facebook like button to the current page
* `social/twitter/follow` - Add a Twitter follow button to the current page
* `social/twitter/tweet` - Add a Twitter tweet this button to the current page
* `user/sidebar` - Outputs a member sidebar with login and profile links

You can also hard-code an include to run once when the template is compiled and hard-code the results into the template for future requests like this:

    {# app/handler?param=value #}

The HTML output of that handler will be hard-coded into the cached template, rendering it only once on the initial request.

## Conditions

Conditional logic is possible in templates with the following tags:

    {% if value %}
        one
    {% elseif value2 %}
        two
    {% else %}
        none
    {% end %}

Values in conditions are exactly the same as in other tags, with one thing to note: To see if something is false, use `value == false` and not `!value`. The parser relies on the variable substitutions to be happening at the start of the string, so the `!` will confuse it about references to globals and other things.

## Loops

Templates also suppor looping using a syntax similar to conditions:

    {% foreach pages %}
      {{ loop_index }} - {{ loop_value }}
    {% end %}

This is equivalent to:

	<?php
	
	foreach ($data->pages as $data->loop_index => $data->loop_value) {
		echo $data->loop_index . ' - ' . $data->loop_value;
	}
	
	?>

The `{% foreach %}` block takes the same variable structure as the other tags, but the variable must be an array to loop through.

The `{{ loop_index }}` and `{{ loop_value }}` are variables created for you to refer to the current loop index and value in the loop, but you can also specify your own:

	{% foreach pages as key, page %}
		{{ key }} - {{ page }}
	{% end %}

## Translatable strings

Templates include a special wrapper tag you can use to denote translatable text for multilingual websites. This takes the following form:

    {""This text should be translated""}

You can also use single-quotes, and an extra space between the tags and the text is okay too:

    {' Translate this text '}

These strings will be replaced with calls to `i18n_get()` in the rendered template. For more info on translations, see the [[Internationalization]] page.

## Filters

By default, all variable output goes through `htmlspecialchars()` to prevent XSS attacks. There is flexible validation of input data, escaping of database input to prevent injection, but to be thorough we filter on the way out too.

### Disabling htmlspecialchars()

To output a value with no filtering, use:

    {{ value|none }}

That's the basic format for all filters, however `none` is a special filter that simply disables all output filtering for that value.

### Custom filters

You can specify any function, built-in or custom, as an output filter. For example:

    {{ title|strtoupper }} -> strtoupper ($data->body)

You can also pass parameters to a filter like this:

    {{ timestamp|date ('F j', %s) }} -> date ('F j', $data->timestamp)

A more complex (or convoluted?) example:

    {{ id|DB::shift ('select title from foo where id = ?', %s) }}
    -> DB::shift ('select title from foo where id = ?', $data->id)

This is obviously messy (and you wouldn't want to do this in practice!), so you can always create wrapper functions to keep SQL and other untidiness out of your templates.

### Filter chains

You can specify a series of filters to be applied to a value. Just add more filters after the first:

    {{ value|filter1|filter2 }} -> filter2 (filter1 ($data->value))

For example:

    {{ timestamp|date ('F j', %s)|strtoupper }} -> strtoupper (date ('F j', $data->value))

## Rendering templates in a handler

Handlers themselves are passed to views and on to layouts, unless you set `$page->template = false`. However, there are times when you want to call a specific view inside a handler and either echo or capture its output. To do this, simply:

	<?php
	
	// echo a view
	echo $tpl->render ('myapp/someview', array ('foo' => 'bar'));
	
	// capture a view's output
	$someview = $tpl->render ('myapp/someview', array ('foo' => 'bar'));
	
	?>

For more information about views and layouts, see [[Page routing and handler basics]].