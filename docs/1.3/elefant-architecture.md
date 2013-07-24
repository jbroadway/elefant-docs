# Elefant architecture

Elefant, like most server-side frameworks, employs the [Model2](http://en.wikipedia.org/wiki/Model_2) pattern, but everyone usually calls it MVC, so to avoid confusion we will too.

## Model2 differences from traditional MVC

Model2 separates your application into models, views, and controllers, but unlike traditional MVC, there's no way for models to notify views of updates like there is in desktop MVC implementations, or Javascript MVC frameworks like [Backbone.js](http://documentcloud.github.com/backbone/).

Instead, a controller takes the request and performs any logic necessary to obtain the correct content for the user. That usually means querying the model. From there, the controller passes the data to the view (a template) to be rendered and returns it to the user.

## Controllers

Where Elefant differs from most frameworks is that controllers in Elefant are ordinary PHP scripts instead of objects. At first, this seems like a step back in terms of code organization, but in practice it has no negative impact, and eliminates needless boilerplate code every time you define a controller.

For example, most frameworks implement controllers something like this:

	<?php
	
	namespace MyappHelloBundleController;
	
	use SymfonyComponentHttpFoundationResponse;
	
	class HelloController {
	    public function indexAction ($name) {
	        return new Response ('<p>Hello ' . $name . '</p>');
	    }
	}
	
	?>

In Elefant, we reduce that to:

	<?php
	
	echo '<p>Hello ' . $this->params[0] . '</p>';
	
	?>

There are people in the PHP community that claim this is bad practice and leads to spaghetti code. The truth is, the above examples both achieve the exact same thing. Elefant still enforces an organizational structure for developers just like any framework, through its directory structure, and separation of logic and presentation, among other features. We simply focus more on getting things done, and minimize developer overhead wherever we can, so long as it doesn't sacrifice maintainability.

The example above is implemented simply by routing the URL to the right file, then requiring it in the controller object's `handle()` method. The output is captured and returned using output buffering, so instead of writing to a response object, you can simply echo it like any ordinary PHP script.

## Routes

Routes in many frameworks need to be specifically defined somewhere to map URLs to controllers. In Elefant, this is done automatically using a simple and consistent convention to map URLs to controller files, called handlers. For example:

	/example/page

Maps to

	apps/example/handlers/page.php

And this:

	/blog/post/1/first-post

Maps to:

	apps/blog/handlers/post.php

And the array `$this->params` contains two elements: `[1, 'first post']`. The first part of the URL maps to the name of an app, and the remaining parts map to the name of a handler. If there was a file `apps/blog/handlers/post/1.php` then it would have mapped to that, but instead it cascades down until it finds a matching file, finally calling the blog app's `index.php` handler if no other match is found, or if only the app is specified, e.g., the URL `/blog`.

For more details, see [[Page routing and handler basics]].

This is a simple URL scheme that is easy to understand, eliminates needless extra code, and still offers full control over URLs to developers.

> Note: Since routes are not passed to functions or methods, URL parameters are not named, but you can achieve the same thing by adding a line like this to the top of your handlers:

	list ($id, $title) = $this->params;

> You can now refer to `$this->params[0]` as `$id` and `$this->params[1]` as `$title` in your handler. This is the only boilerplate required for controllers, should you wish to name your parameters.