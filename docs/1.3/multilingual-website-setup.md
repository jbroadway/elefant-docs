# Multilingual website setup

This tutorial will walk you through the steps to creating a multilingual website in Elefant.

## Step 1. Add the languages

Log into Elefant and go to Tools > Languages for this step. Here you'll need to make sure that each language you want your website to appear in is present in this list. You may also want to remove languages that your website does not support, so that only the languages that you will be publishing in will be matched against a visitor's browser settings.

To add a language, click the `Add language` link. Each language has a number of options that you can customize, but the main ones are the name of the language and its code. The link next to the language code text box provides a list of codes for each language.

Here's an example of a language being added:

![Add language form](http://www.elefantcms.com/files/docs/add-language.png)

## Step 2. Multiple homepages

Once you've adding the languages, the next step is to create a homepage for each language, using the language code for that language as the page ID, for example `en` for English and `es` Español.

Here's an example of how it should look:

![Language homepage](http://www.elefantcms.com/files/docs/language-homepage.png)

We're also going to add a homepage redirection script to tell Elefant to automatically forward visitors to the correct homepage based on their browser language settings.

To do this, log into Elefant and edit the main index page. In the WYSIWYG editor, click on the [[Dynamic Objects]] icon, and select ""Multilingual Homepage Redirect"" from the list, then save the page.

> **Tip:** To view and test your website in each language, edit your browser's language preferences and change the default language, then come back to your website and refresh the screen.

## Step 3. Create additional pages for each language

Here you'll create an additional page or two for each language. For now, just enter some sample content since we'll be using these pages to see that our multilingual navigation is working. For example:

![Language sub-page](http://www.elefantcms.com/files/docs/language-subpage.png)

Once you've created a couple sub-pages for each language, go to Tools > Navigation and create a site tree that looks like this:

![Multilingual site tree](http://www.elefantcms.com/files/docs/multilingual-site-tree.png)

Each language's homepage should be a top-level page, with additional pages for that language appearing under it in the site tree.

## Step 4. Adjust your site settings

Edit your main `conf/config.php` file and change the `multilingual` setting to `On`, which will adjust how the dynamic navigation works to be multilingual-aware.

You can also adjust the `negotiation_method` setting to choose how your website determines a visitor's preferred language. By default, Elefant will read your browser's language preferences and find the best match. Other options include using a session cookie to switch languages, using a separate subdomain for each language (e.g., `en.example.com`, `fr.example.com`), or a URL prefix (e.g., `example.com/en/about`).

## Step 5. Translating strings of text

At this point, you have a completely functional multilingual website, but there may be strings of text that appear in your site outside of the page title and body contents.

To translate these, go back to Tools > Languages and edit the languages. You can search for specific strings of text instead of having to translate everything, since this form includes all of the Elefant user interface text as well.

For example, you can search for the text `Members` and translate it like this:

![Translating text](http://www.elefantcms.com/files/docs/translating-text.png)

Now if you visit your website, you'll see that text automatically translated into the correct language for you:

![Translated text](http://www.elefantcms.com/files/docs/translated-text.png)

## Step 6. Sidebar blocks

You may also want to create sidebars specific to each language. To do this, go to Tools > Designer and edit the design layout file. Look for the following:

	{! blocks/members !}

We're going to change it to use this tag instead:

	{! blocks/index?id=[i18n.language] !}

This tells Elefant to look for a block with the ID matching the current language (e.g., `es`) instead of hard-coding a single ID value, allowing it to dynamically chose the right block content based on the current language.

Now you'll see a little `+` icon and a blank space where the old sidebar block used to be. Click that to add a block for the current language.

You can also add additional blocks under Tools > Blocks, so you don't have to change your browser's language setting to add blocks for the other languages. Just make sure the block ID contains the correct language code.

## Language chooser

Elefant's [[Dynamic Objects]] list includes a language chooser you can use to help users select their language. Look for ""Navigation: Languages"" in the list, or include it in any layout template with the following tag:

	{! navigation/languages !}

## Conclusion

As you can see, Elefant provides a solid base for easily creating and managing multilingual websites. With just a few steps, you can build the outline of a multilingual site, and Elefant makes it easy to keep it up-to-date and build on it.