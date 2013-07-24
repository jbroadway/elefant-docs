# Internationalization

Elefant supports multilingual websites through the `I18n` class, which has the following capabilities:

* Negotiate the language preference with the client using a variety of methods.
* Manage a list of languages with associated locale, character set, and fallbacks.
* Language fallbacks, e.g., `fr-ca -> fr -> en`, in browser negotiation.
* Language inheritance from fallback list in translations.
* Automatically translate strings in PHP code and in templates/views.

## Translators

To translate the Elefant UI into a new language, copy the file `lang/new_lang.php` to `lang/fr.php` where `fr` is the language code for the language you'll be translating into. From there, you can edit the new file and add translations for each string of text.

## Negotiation methods

### url (default)

This reads the language from the first part of the request path. For example:

    /es/my/request -> es
    /fr-ca/my/request -> fr-ca

The request passed to the controller is then becomes `/my/request`. If no matching language is present, the full request path is sent to the controller and the default language is used.

### cookie

This reads the language preference from a cookie named `lang`. The cookie name can be changed in the global settings via:

    negotiation_method = cookie
    cookie_name = lang_pref

The cookie name would now be `lang_pref`. If the cookie is not set, then the default language is used.

### subdomain

This reads the language preference from the subdomain of the site. For example:

    en.example.com -> en
    fr-ca.example.com -> fr-ca

If the subdomain doesn't match one of the configured languages, the default language is used.

### http

This uses the HTTP Accept-Language string that contains their browser's language preferences. It loops through their list of preferred languages and finds the best match. The nice thing about this technique is that it automatically chooses their language if available. The downside is that not everyone sets their browser correctly, and shared computers won't necessarily have it set, or worse, set incorrectly.

## Language files

The files associated with translations and internationalization are in the `lang` folder.

### Language list

The language list is in the file `lang/languages.php`. It is INI-formatted and each language is a block that has the following fields:

	[en-us]
	name = English
	code = en
	charset = UTF-8
	locale = us
	fallback = Off
	default = On

The locale is optional. If present, it will call `setlocale` as follows:

    setlocale(LC_TIME,'en_US.UTF-8','en_US','en');

If missing, it simply sets it as:

    setlocale(LC_TIME,'en');

The fallback should be set to Off if no fallback is needed, or to the block name of the fallback language. Here is an example using a fallback:

	[en]
	name = English
	code = en
	charset = UTF-8
	fallback = Off
	default = On
	
	[fr]
	name = ""Français""
	code = fr
	charset = UTF-8
	fallback = Off
	default Off
	
	[fr-ca]
	name = ""Français (Canadienne)""
	code = fr
	charset = UTF-8
	locale = ca
	fallback = fr
	default = Off

Here `fr-ca` will fallback to `fr` before defaulting to `en`.

### Translation files

Each translation is a PHP file with the following structure:

	<?php // lang/en.php
	
	$this->lang_hash['en'] = array (
		'string one' => 'translation one',
		'string two' => 'translation two'
	);
	
	?>

Any key in this list will be translated to its value by the `I18n` class. Language files are loaded when that language matches the current user's preference, or is a fallback for them. If a string is present in the fallback language but not in the preferred language, it will be used instead. If no translation can be matched, the original string to be translated is returned instead.

To generate a language file for your language, use the following command on the command line:

	$ ./conf/elefant build-translation fr

Replace `fr` with the language code for your language. You can then open the resulting translation file to translate the strings it found from all the templates and handlers.

## Translations in PHP

The I18n library also defines a function `__()` (that's two underscores) to perform translations:

	<?php
	
	// perform an ordinary translation
	echo __ ('Translate me');
	
	// translate but pass dynamic values to be inserted via vsprintf()
	echo __ ('Hello %s', $name);
	
	?>

The second form is handy for strings that need dynamic placeholders in them. You would then use the key `'Hello %s'` in your translation file.

## Translations in views/layouts

Elefant's templates provide a simple way of marking strings for translation:

    {""Translate me""}

These values will automatically be replaced with calls to `i18n_get('Translate me')` in the rendered template.