# Autoloading and namespaces

You'll notice in the documentation and in the code there isn't much use of `require()`. That's because Elefant uses autoloading for anything in its core `lib` folder as well as anything in `apps/*/models` and `apps/*/lib`. Just make sure your class and file names match and it will be included automatically upon first reference.

In this way, you can create a custom model in `apps/myapp/models/Mytable.php` then refer to it immediately in any handler just by:

	<?php
	
	$obj = new Mytable ($_GET['id']);
	
	?>

### PSR-0 Compatibility

For compatibility with other general-purpose frameworks, Elefant's autoloading falls back on the [PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md) specification. To use any PSR-0 compatible framework, simply drop it into `lib/vendors/` and use it as expected.

See also: [[Using Composer packages]]

## Namespaces in your apps

As mentioned above, Elefant does not use namespaces for its core classes (see below for our rationale), however as with PSR-0 support, it does play nice if you use them in yours. Here's an example use of namespaces in your custom code that takes advantage of the autoloading:

	<?php // apps/test/lib/Form.php
	
	namespace test;
	
	class Form {
	    var $name = 'default';
	}
	
	?>

In the above example, I created a class with a clear naming conflict with one of the core classes (had we not put it in its own namespace and then tried using the core class). Next, let's look at a handler that uses both our custom `Form` class and the core `Form` class in the same script:

	<?php // apps/test/handlers/index.php
	
	// To use our new form, we simply instantiate.
	// The autoloader will know to look in our app
	// based on the namespace.
	$form = new testForm;
	
	// Now let's create a form object from the core
	// Form class, to show we can.
	$f = new Form;
	
	?>

No conflict yet. Now let's modify that so we can refer to our own `testForm` class as simply `Form` and the core `Form` class as `CoreForm`.

	<?php // apps/test/handlers/index.php
	
	use Form as CoreForm;
	use testForm as Form;
	
	// Now we can create a new testForm object while
	// omitting the namespace.
	$form = new Form;
	
	// And we can create a Form object from the core
	// class with the new CoreForm alias.
	$cform = new CoreForm;
	
	?>

As you can see, there's plenty of flexibility in this technique.

## Core class list

Here is the full list of classes defined by the Elefant core:

* Acl
* AppTest
* ActiveResource
* Cache
* Controller
* DB
* Debugger
* ExtendedModel
* Form
* I18n
* Ini
* Mailer
* MemcacheAPC
* MemcacheExt
* MemcacheRedis
* MemcacheXCache
* Model
* MongoManager
* MongoModel
* Page
* Product
* Restful
* Template
* User
* Validator
* View
* Webpage

### Rationale

The reason we've kept the core classes in the global namespace to save typing and keep things simple. Since there are numerous functions in the core as well, and you can't simply say `from foo import *` but rather have to type the namespace prefix before them every time anyway, namespaces quickly become cumbersome for these. The above example shows how you can easily avoid conflicts, and how Elefant plays nicely with other PHP libraries whether they use PSR-0, their own namespace naming system, or none.

We chose not to follow PSR-0 for core classes since they are not a general purpose library separate from the CMS itself. If they were, we would certainly use namespaces to ensure a general purpose library can interoperate with other libraries in any system. Above is a complete list of core class names and examples of how to avoid naming conflicts should you import a third party library that does not use namespaces itself and whose name conflicts with one of these.

Elefant's core libraries are few and specific to itself, and this choice saves a lot of repetitive boilerplate code at the start of each custom model and handler script. Since this doesn't sacrifice maintainability in any way, this was a good trade-off that keeps in line with the [[Elefant design principles]].