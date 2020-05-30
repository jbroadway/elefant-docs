# Hooks, Elefant's event system

Elefant implements a system of triggering one or more handlers when a particular
event or action has occurred, which we call hooks. Similar to the idea of WebHooks,
this provides a means of triggering handlers without hard-coding the specific
handlers to trigger, so that you can modify them independently of the original code.

Hooks are particularly useful when one or more actions depend on another, such as
keeping a search index up-to-date when a page has been modified.

There are three components to hooks in Elefant:

1. The `[Hooks]` section of the global config
2. The handler that triggers the hooks
3. The handlers that respond to the hook event

## Configuration

Hooks can be named anything you want, but it is good practice to name them after the
handler that triggers them so you can easily look them up, although it is possible to
trigger the same hook from multiple handlers. Here's how a hook looks in the config:

	admin/add[] = search/add

This says that the `search/add` handler should respond when the `admin/add` hook is
triggered. You can also specify multiple handlers to the same hook like this:

	admin/add[] = search/add
	admin/add[] = anotherapp/add

### Triggering a hook on an event

Triggering a hook takes only one line of code:

~~~php
<?php

$this->hook ('admin/delete', array ('page' => $id));

?>
~~~

The first parameter is the hook name, and the second is an associative array of data
that will be passed to the responding handlers.

### Responding to an event

There are several things to consider in hook response handlers:

1. Do we need to limit access to this handler?
2. Verifying data values
3. Accessing the hook event data

If we need to restrict access and make sure that only another request inside Elefant
is accessing the response handler, we can check the `$this->internal` value:

~~~php
<?php

if (! $this->internal) die ('Must be called by another handler');

?>
~~~

As for verifying data values, we can use the [[Developers / input validation]] features
for that.

Finally, you can access data passed to your handler through the `$this->data` array,
e.g., `$this->data['page']` for the data from the example above.

Note that most hooks expect no output in response. `page/render` is one exception,
where any output tells it that your hook is acting as a filter on the input
provided.

For example, to add a "&trade;" next to any mention of "Acme Co.",
you could write:

~~~php
<?php

if (! $this->internal) die ('Must be called by another handler');

echo str_replace (
	'Acme Co.',
	'Acme Co.&trade;',
	$this->data['html']
);

?>
~~~

### Built-in hooks

Here is a list of hooks that are available by default:

* `admin/add`
* `admin/edit`
* `admin/delete`
* `blocks/add`
* `blocks/edit`
* `blocks/delete`
* `blog/add`
* `blog/edit`
* `blog/delete`
* `page/render`
* `user/add`
* `user/edit`
* `user/delete`

## WebHooks

Being a WebHooks consumer in Elefant is easy: Simply create a handler for it and give
that handler's URL to the third party site. The third party should begin sending
notifications to your handler, which you would handle just like any other request
or RESTful request.

In creating a WebHook for consumption by other services, it's a good idea to wrap it in
an ordinary Elefant hook so you can abstract it from the original code just like
ordinary hooks. Then it's simply a matter of issuing a POST request to the third party
service, either via `http_post_fields()`, cURL, or `file_put_contents()` with an HTTP
POST stream. For example:

~~~php
<?php

if (! $this->internal) die ('Must be called by another handler');

$res = http_post_fields (
	'http://some.service.com/webhooks/consumer',
	$this->data
);

?>
~~~

Next: [[:Writing command line scripts]]
