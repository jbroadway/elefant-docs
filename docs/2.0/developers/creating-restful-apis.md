# Creating RESTful APIs

To create RESTful APIs, Elefant provides the [Restful](https://www.elefantcms.com/visor/lib/Restful) class.
Here's how it works:

## 1. Extend Restful to create your API

~~~php
<?php

namespace myapp;

use blog\Post;

class API extends \Restful {
	/**
	 * Fetch a blog post by its ID.
	 */
	public function get_blogpost ($id) {
		$post = new Post ($id);
		if ($post->error) {
			return $this->error ('Not found');
		}
		return $post->orig ();
	}
}

?>
~~~

Save this to the file `apps/myapp/lib/API.php`. This example exposes one method which
fetches a blog post and returns it as a JSON-encoded object.

## 2. Expose your API endpoint

To expose your API, you simply need to initialize it in a handler, like this:

~~~php
<?php

$this->restful (new myapp\API);

?>
~~~

Save this to `apps/myapp/handlers/api.php` and your RESTful API will be available at
`/myapp/api`. To test it out, try visiting the URL `/myapp/api/blogpost/1` on your site.

## Method naming

Method names are based on the request method (GET, POST, PUT, and DELETE), and the first
extra parameter in the request URI. For example, if your API is exposed at the address
`/myapp/api`, making a GET request to `/myapp/api/blogpost/123` would call
`get_blogpost(123)`.

### Default methods

If no method matches the requested URI, Elefant will look for a default method for the
request method named in the form `${request_method}__default()` (note the double
underscore), for example:

~~~php
<?php

namespace myapp;

class API extends \Restful {
	public function get__default () {
	}
}

?>
~~~

Also note that the request method must be lowercase in the method name as well.

Failing to find a default method, an error of "Invalid action name" will be returned to
the client.

### Custom routes

Sometimes you need more customizable routes than the above allows for. In this case,
you can define additional routes in the `$custom_routes` property, like this:

~~~php
<?php

namespace myapp;

class API extends \Restful {
	public $custom_routes = array (
		'GET blogpost/%d/comment/%d' => 'blogpost_comment'
	);
	
	public function blogpost_comment ($id, $comment_id) {
		// matches /myapp/api/blogpost/123/comment/456
	}
}

?>
~~~

In this way, you can have as much flexibility as needed in your RESTful routing.

## Parameters and request data

Method parameters are the extra path elements in your request URI, after the method name
has been resolved.

You can also access the `$_GET` and `$_POST` arrays separately, and PUT data can be
accessed via:

~~~php
$data = $this->get_put_data ();
~~~

Or to automatically decode JSON-formatted PUT data, use:

~~~php
$data = $this->get_put_data (true);
~~~

Similarly, if the POST data is JSON-formatted, you can return it via:

~~~php
$data = $this->get_raw_post_data (true);
~~~

### Return values

To return a data structure, simply call:

~~~php
return $data;
~~~

If `$data` is an object with property `foo` that has the value `bar`, then Restful will
wrap your output as follows:

~~~json
{"success": true, "data": {"foo": "bar"}}
~~~

You can disable the wrapping and simply return the JSON-encoded data as-is via the `$wrap` property:

~~~php
public $wrap = false;
~~~

### Error handling

To return an error, call `error()` like this:

~~~php
return $this->error ('Error message');
~~~

This will send the following JSON structure to the client:

~~~json
{"success": false, "error": "Error message"}
~~~

## Authentication

To add authentication, simply add it to the handler:

~~~php
<?php

$this->require_login ();

$this->restful (new myapp\API);

?>
~~~

The API endpoint above now requires a user to be logged in before they can access it.

Similarly, you can implement [HMAC](http://en.wikipedia.org/wiki/Hash-based_message_authentication_code)
token-based authentication using the `user\Auth\HMAC` class:

~~~php
<?php

$this->require_auth (user\Auth\HMAC::init ($this, $cache, 3600));

$this->restful (new myapp\API);

?>
~~~

To create an HMAC token and key for a user accounts, call `Api::create_token()` like this:

~~~php
<?php

list ($token, $key) = Api::create_token ($user_id);

?>
~~~

## Organizing your API

As an API grows, there are a couple things to keep in mind:

1. Try to keep your logic in your models so your API methods remain small and manageable.
2. You can break your API up into multiple classes and create multiple endpoints to access them.

As an example of the second point, say the following URLs make up part of your API:

* `GET /myapp/api/blog/123`
* `GET /myapp/api/blog/post/456`
* `GET /myapp/api/blog/tags/456`

You could move these to their own class, such as:

~~~php
<?php // apps/myapp/lib/API/Blog.php

namespace myapp\API;

class Blog extends \Restful {
	public function get__default ($id) {
	}
	
	public function get_post ($id) {
	}
	
	public function get_tags ($id) {
	}
}

?>
~~~

These could then be made available in a separate handler like this:

~~~php
<?php // apps/myapp/handlers/api/blog.php

$this->restful (new myapp\API\Blog);

?>
~~~

In this way, you can maintain a more organized codebase, and further control your URIs as well.

Next: [[:Users and access control]]
