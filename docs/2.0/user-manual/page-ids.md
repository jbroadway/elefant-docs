# Page IDs

The page ID is the unique identifier of a page within your site, and is used as the unique address of that page in the browser's address bar. For example, if your page ID is `about-us`, the address of the page in your site would be:

    http://www.example.com/about-us

When adding a new page, the page ID will be auto-filled based on the title of the page, but you are free to customize it to what you would like to appear in the address bar.

> Note: Each page must have its own unique ID, and IDs can't be the same as the names of any installed Elefant apps. By default this includes:

* admin
* api
* blocks
* blog
* cli
* designer
* filemanager
* navigation
* social
* translator
* user

If you visit one of these at your website (for example `/blog`), you will see the app being called. That's why `/admin` triggers the Elefant CMS admin interface, `/blog` shows your blog, and `/user` shows a user login page.

## Page IDs for multilingual sites

When setting up a multilingual site in Elefant, each language should have its own homepage with a page ID matching the language code for that language. For example, the English language homepage would have an ID set to `en`, and the French language homepage would have an ID set to `fr`.

For more info, see the [[administration / multilingual website setup]] page.

Next: [[:WYSIWYG Editor]]