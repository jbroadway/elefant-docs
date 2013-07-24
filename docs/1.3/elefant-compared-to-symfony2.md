# Elefant compared to Symfony2

> [See here for a performance comparison of Elefant against Symfony and several other frameworks.](http://www.elefantcms.com/wiki/Benchmarks)

I'm going to walk through building a Hello World example in both
Symfony2 and Elefant. The purpose is to highlight the fundamental
difference in how the two approaches work. Elefant promotes minimalism
and brevity, avoiding boilerplate as much as possible.

Hello World is a great example for exploring boilerplate since it
is comprised almost entirely of boilerplate code, so it works well
to illustrate the difference in how much boilerplate you're
committing to typing when you choose one framework over another.

> Note: This isn't meant to paint an either-or scenario, since Elefant is a minimalist *web* framework and not a general purpose one. Developers are always able to [include Symfony or other frameworks](https://github.com/jbroadway/elefant/wiki/Elefant-with-other-frameworks) into their Elefant apps for extra functionality. Elefant simply means to reduce boilerplate around core MVC and request/response functions.

## Hello World in Symfony

The following examples were taken from [Creating Pages in Symfony2](http://symfony.com/doc/current/book/page_creation.html).
I've excluded the explanations found there for the sake of brevity.
This is simply meant to illustrate the code necessary to implement
a Hello World example in both frameworks.

### Step 1: Create the Route

Define the route in `app/config/routing.yml`.

	MyappHelloBundle:
	  resource: ""@MyappHelloBundle/Resources/config/routing.yml""
	  prefix: /

Now define your route in `src/Myapp/HelloBundle/Resources/config/routing.yml`.

	hello:
	  pattern: /hello/{name}
	  defaults: { _controller: MyappHelloBundle:Hello:index }

### Step 2: Create the Controller

	<?php
	
	// src/Myapp/HelloBundle/Controller/HelloController.php
	namespace MyappHelloBundleController;
	
	use SymfonyComponentHttpFoundationResponse;
	
	class HelloController {
		public function indexAction ($name) {
			return new Response ('<p>Hello ' . $name . '</p>');
		}
	}
	
	?>

You can now call `/app_dev.php/hello/World` and see the output:

	Hello World

## Hello World in Elefant

### Step 1: Create your app

From the command line, create your app with the following command from your site root:

	php conf/make.php myapp

This will create an app with the folder structure described in the [[Folder layout]] page.

Alternately, if you don't use the command line, you can simply create a new folder for your app handlers:

	apps/myapp/handlers

> Note: A handler is to Elefant what a controller is to Symfony.

### Step 2: Create your handler

In the file `apps/myapp/handlers/hello.php` add:

	<?php
	
	echo '<p>Hello ' . $this->params[0] . '</p>';
	
	?>

You can now see your handler in action at `/myapp/hello/World`. Notice that
the output is also sent to the default layout in `layouts/default.html` for
you, so you can easily style your site as desired.

> To learn more about handlers in Elefant, see [[Page routing and handler basics]].

## Bonus Step: Templating our output

### Using Elefant

First, let's create a template for our output in `apps/myapp/views/hello.html`
with the following code:

	<p>Hello {{ name }}}</p>

Now we can modify our original handler to look like this:

	<?php
	
	echo $tpl->render ('myapp/hello', array (
		'name' => $this->params[0]
	));
	
	?>

The output will be exactly the same, but there's one added benefit: Template
parameters are filtered for XSS prevention by default, so this easy change
adds a level of security.

### The same changes in Symfony

Let's compare this to an updated Symfony2 example with template rendering.
First, the template file (using Twig templates from the Symfony2 page).

	{# src/Myapp/HelloBundle/Resources/views/Hello/index.html.twig #}
	{% extends '::base.html.twig' %}
	
	{% block body %}
		<p>Hello {{ name }}</p>
	{% endblock %}

Now we can modify our controller to call the template:

	<?php
	
	// src/Myapp/HelloBundle/Controller/HelloController.php
	namespace MyappHelloBundleController;
	
	use SymfonyComponentHttpFoundationResponse;
	
	class HelloController {
		public function indexAction ($name) {
			return $this->render ('MyappHelloBundle:Hello:index.html.twig', array (
				'name' => $name
			));
		}
	}
	
	?>

If the conciseness of Elefant wasn't clear enough, let's do a quick character
count comparison of the two:

* Symfony2: 535 characters (with all comment lines removed)
* Elefant: 108 characters

That's 80% less code required to accomplish the same thing.

For another example to reference, here is a [""Quick Start""](http://packages.zendframework.com/docs/latest/manual/en/zend.mvc.quick-start.html) on using the Zend Framework v2's new MVC classes.