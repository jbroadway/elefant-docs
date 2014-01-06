# Available template tags

When a layout template is run, it is passed the [Page](http://api.elefantcms.com/visor/lib/Page) object, which makes the following tags available to the template. Note the way each is used, as some have filters or conditions that will help ensure they render consistently.

Below the tag list is a complete example template with all of the required elements.

### id

The page identifier, refers to the unique ID of the page used in the URL, e.g. in the page `http://www.example.com/page_id` the ID value would be `page_id`. If you need to include this in the template itself, use:

    {{ id }}

### title

The title of the page. This may be empty, so you can use a condition to only output the title if it's available:

    {% if title %}<h1>{{ title|none }}</h1>{% end %}

### menu_title

The `menu_title` is an optional alternate title for the page that's intended for use in site navigation. If there's no separate `menu_title` value, then it will have the same value as `title`. Usage:

    {{ menu_title|none }}

### window_title

Like `menu_title`, the `window_title` is an optional alternate title for the page that's intended for use in the `<title></title>` tags. If there's no separate `window_title` value, then it will have the same value as `title`. Usage:

    <title>{{ window_title|none }}</title>

You can also grab the site name from the global configurations and include it in the window title like this:

    <title>{{ conf('General', 'site_name') }} - {{ window_title|none }}</title>

### head

`head` is a special variable that holds any extra tags that handlers may want added to the `<head>` of the html output. To include it, you need to disable the default output filtering however, since otherwise it will convert HTML symbols like `<` into `&lt;` which in this case you don't want.

To use this, place it somewhere in your `<head></head>` tags, usually just before the closing tag.

    {{ head|none }}

> Note: The `|none` disables the default filter.

### tail

Similar to `head`, `tail` holds any extra tags that handlers may want to add just before the `</body>` closing tag, such as scripts that need to load asynchronously to not block your page rendering. To use this, place it just before your `</body>` tag like this:

    {{ tail|none }}

Note that `tail` is not a footer, it is appended after all your footer HTML has been rendered, so we named it to make that distinction clear.

### body

The `body` property contains the main body output for the page. To use it, you also need to disable the default output filter, like this:

    {{ body|none }}

Note that wherever the page body is in the template, at the top of it is where the Elefant page editing buttons will appear in the template.

## Including the admin toolbar

There is one special tag you need to include between your `<head></head>` tags that allows the Elefant CMS toolbar to appear:

    {! admin/head !}

This also includes jQuery into your `<head></head>`, which is used by several built-in handlers. This tag is the same as including the following PHP code:

	<?php echo $this->controller->run ('admin/head'); ?>

## A complete template

Here is an example of a functionally complete Elefant layout template:

	<!DOCTYPE html>
	<html>
	<head>
		<title>{{ conf('General', 'site_name') }} - {{ window_title|none }}</title>
		{! admin/head !}
		{{ head|none }}
	</head>
	<body>
	{% if title %}<h1>{{ title|none }}</h1>{% end %}
	{{ body|none }}

	{{ tail|none }}
	</body>
	</html>

This template includes all of the necessary tags for Elefant's admin toolbar and inline editing features, along with the page title and body and a custom window title comprised of the site name and the current page title.

Next: [[:Content blocks]]