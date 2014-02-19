# Code example: Events

These pages will show different code samples to illustrate different aspects of Elefant.

## The model

Let's define a model called `Events` mapped to the database table `events` with fields `id`, `title`, and `date`. We'll add some validation rules to ensure the date is formatted correctly and the title is present. We'll also define a custom method for pulling events by most recent.

This would live in the file `apps/events/models/Event.php`.

	<?php
	
	class Events extends Model {
		public $verify = array (
			'title' => array ('not empty' => 1),
			'date' => array ('date' => 1)
		);
	
		public static function latest ($limit = 10) {
			return self::query ()
				->order ('date desc')
				->fetch ($limit);
		}
	}
	
	?>

The `$verify` rules for each field are arrays so that you can specify more than one per field.

## The handler

Here we'll make a basic query on the `Events` model above, and output it using a view template we'll define later. This example illustrates grabbing parameters by name, the URL routing, and how to call templates.

This would live in the file `apps/events/handlers/index.php` and be called via the URL `/events` or `/events/20` to fetch the 20 latest events.

	<?php
	
	// get the limit parameter for this request
	list ($limit) = count ($this->params) ? $this->params : 10;
	
	// get the results from our model
	$events = Events::latest ($limit);
	
	// output the results
	echo $tpl->render (
		'events/index',
		array (
			'events' => $events
		)
	);
	
	?>

A few things to note:

* The autoloading recognized our new `Events` model
* `$this` references the Controller object itself
* `$tpl` is a Template object available to us

## View template

The `events/index` template would live in the file `apps/events/views/index.html`. `$tpl` maps it for us to save typing.

	<ul>
	{% foreach events %}
		<li>{{ loop_value->date|I18n::short_date }} - {{ loop_value->title }}</li>
	{% end %}
	</ul>

A few things to note:

* `{% end %}` is short for `{% endforeach %}`
* `I18n::short_date` is one of the date filters provided by the I18n class
* By default, values are filtered using `Template::sanitize()` to prevent cross-site scripting (XSS) attacks

## Running the example

You'll need a database table to run the example. You can paste the following into the [DB Manager](http://github.com/jbroadway/dbman) Elefant app's SQL shell to create one and use it to add some events to it.

	create table `events` (
		`id` int not null auto_increment primary key,
		`title` char(48) not null,
		`date` date not null,
		index (`date`)
	);

## Next steps

As a next step, you could try creating an individual event page handler and linking to it from the main handler's template.

There's also a complete [Events app](https://github.com/jbroadway/events) for Elefant you can refer to for ideas, and to see how a full app is built.