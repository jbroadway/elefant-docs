# Server-side helpers

Beyond reusing PHP classes, Elefant allows a developer to specify handlers in their
apps as being "helpers" which can be reused in other apps.

To see a list of available helpers, run the following command:

~~~bash
$ ./elefant list-helpers
~~~

This will output a raw list of handler names. To see what a given handler does and how to
use it, you can usually find instructions in a PHP comment at the top of the handler
script.

For example, the `blog/tags` helper says:

~~~php
/**
 * Renders a tag cloud, with more frequently used tags appearing larger.
 */
~~~

This helper uses no parameters, so calling it is as simple as:

~~~php
<?php

echo $this->run ('blog/tags');

?>
~~~

And including it in your template is as simple as this:

~~~html
{! blog/tags !}
~~~

The `blog/rssviewer` helper lists one parameter:

~~~php
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

~~~php
<?php

echo $this->run (
	'blog/rssviewer',
	array (
		'url' => 'http://www.example.com/blog/rss'
	)
);

?>
~~~

And the same thing called from a template:

~~~html
{! blog/rssviewer?url=http://www.example.com/blog/rss !}
~~~

Next: [[:Writing dynamic custom fields]]
