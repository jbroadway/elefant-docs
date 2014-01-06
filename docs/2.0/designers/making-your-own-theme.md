# Making your own design themes

A design theme is a collection of all of the files necessary to produce a complete design for a site. This includes the design templates, CSS, images, and any custom scripts to be included as well.

Elefant's design themes have the following folder structure:

	layouts/
		my-theme/
			elefant.json
			my-theme.html
			sub-template.html
			css/
				style.css
			js/
				script.js
			pix/
				bg.png
				logo.png

Each theme should have its own sub-folder inside the `layouts` folder, with an HTML file inside with a matching name. So if your theme is named `my-theme`, then the default template file in your theme would be named `my-theme.html`.

While everything else is technically optional, we encourage you to use a structure like the above to keep your theme files organized.

## A complete template

Here is an example of a functionally complete design template with all of the required elements:

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

This template includes all of the necessary tags for Elefant's admin features, displays the page title and body, and prefixes the window title with the name of the name as taken from the site configuration.

## Referring to file paths

When you make reference to images, stylesheets and other files in your templates and CSS, we recommend providing the full path to the file, for example:

	<img src="/layouts/my-theme/pix/logo.png" />

This way the path will work correctly no matter the URL you're accessing it from.

## The `elefant.json` file

`elefant.json` is a JSON-formatted file that describes your theme (name, version, author, etc.) for sharing with others. It describes your theme so that Elefant's theme installer can verify and install your theme onto someone else's website (see [[:Sharing your themes]]).

Next: [[:Available template tags]]