# Comparison to Sitellite: Internationalization

Back to [[Comparison to Sitellite CMS]].

***

Elefant borrows its main ideas here from Sitellite as well, but renames them. In Sitellite, to translate a string, you would use:

	<?php
	
	echo __ ('My string');
	
	?>

In Elefant, you would say:

	<?php
	
	echo __ ('My string');
	
	?>

`intl_getf()` also becomes `__ ()`, just include the additional parameters:

	<?php
	
	echo __ ('Not found: %s', $thing_thats_not_found);
	
	?>

## Template strings

In Sitellite templates, you would translate text like this:

	{intl My string}

In Elefant, this becomes:

	{""My string""}

## Translation files

Elefant supports the same translation file formats as Sitellite, in a `lang` folder instead of `inc/lang`, as well as the same ability to set default languages, fallbacks, and negotiation methods. For more info, see [[Internationalization]].