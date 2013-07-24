# RESTful APIs

In Elefant 1.1+, there's a new `Restful` class that you can use to build incredibly clean and easy RESTful APIs for your apps. Here's how it works:

## 1. Extend Restful to create your API

	<?php
	
	namespace myapp;
	
	class API extends Restful {
	}
	
	?>

### Method naming

Method names are based on the request method (GET, POST, PUT, and DELETE), and the first extra parameter in the request URI. For example, if your handler is accessible at `/myapp/api` and you made a GET request to `/myapp/api/article/123`, that would map to the following method:

	<?php
	
	namespace myapp;
	
	class API extends Restful {
		function get_article ($id) {
		}
	}
	
	?>

Method parameters are always the extra path elements in your request URI, after the method name has been resolved. You can access the `$_GET` and `$_POST` arrays separately, and PUT data can be accessed via:

	$data = $this->get_put_data ();

Or to automatically decode JSON-formatted PUT data, use:

	$data = $this->get_put_data (true);

Similarly, if the POST data is JSON-formatted, you can return it via:

	$data = $this->get_raw_post_data (true);

### Return values

To return a data structure, simply call:

	return $data;

If `$data` is an object with property `foo` that has the value `bar`, then Elefant will wrap your output as follows:

	{""success"": true, ""data"": {""foo"": ""bar""}}

You can disable the wrapping and simply return the JSON encoded data as-is via the `$wrap` property:

	public $wrap = false;

### Error handling

To return an error, call `error()` like this:

	return $this->error ('Error message');

This will cause Elefant to send the following JSON structure:

	{""success"": false, ""error"": ""Error message""}

## 2. Connecting your class

To notify the controller about your new `Restful` class, use the `restful()` method in your handler. In `apps/myapp/handlers/api.php` add the following code:

	<?php
	
	$this->restful (new myappAPI);
	
	?>

That's all it takes to serve REST requests from your app. You can use your handler to add things like authentication to your new API.