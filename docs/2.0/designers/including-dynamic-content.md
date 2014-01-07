# Including dynamic content

Dynamic includes can be used to embedded almost any handler into your template, although apps often provide specific handlers that are intended for reuse outside of the app itself, called helpers. To see a list of handlers that apps have marked as helpers, you can run the following [command](/docs/2.0/administration/command-line-tool):

~~~
./elefant list-helpers
~~~

This will output a raw list of handlers. To see what a given handler does and how to use it, you can usually find instructions in a PHP comment at the top of the handler script.

For example, the `blog/tags` helper says:

~~~
/**
 * Renders a tag cloud, with more frequently used tags appearing larger.
 */
~~~

This helper uses no parameters, so including it in your template is as simple as this:

~~~
{! blog/tags !}
~~~

The `blog/rssviewer` helper lists one parameter:

~~~
/**
 * Renders the specified RSS feed `url` as a list of links.
 * Caches the feed for 30 minutes between updates.
 *
 * Parameters:
 *
 * - `url`: The URL of the RSS feed to be displayed.
 */
~~~

So we know that to use this helper, we need to include the URL like this:

~~~
{! blog/rssviewer?url=http://www.example.com/blog/rss !}
~~~

## Common helpers for designers

Here are a few common helpers often used in designing themes:

* `blog/headlines` - Embed the latest headlines from your blog
* `blog/postsfeed` - Embed your blog into the current page
* `blog/tags` - Embed a tag cloud for your blog
* `filemanager/slideshow` - Embed a photo slideshow
* `filemanager/video` - Embed a video into the current page
* `navigation/breadcrumb` - Embed a breadcrumb menu
* `navigation/contextual` - Embed a contextual menu
* `navigation/dropmenu` - Embed a drop down menu
* `navigation/languages` - Embed a language selector
* `navigation/map` - Embed a site map
* `navigation/section` - Embed a section menu
* `navigation/top` - Embed a top-level menu
* `social/video/youtube` - Embed a YouTube video into the current page
* `user/sidebar` - Embed a user login/profile summary

Next: [[:Sharing your themes]]