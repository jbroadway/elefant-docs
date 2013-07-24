# Models

In Elefant, the main way you'll likely be interfacing with the database is by creating custom models to encapsulate your application logic. This helps keep your custom logic well-organized, and keeps it from bleeding into your handler scripts, which you should try to limit to marshalling requests to the appropriate Model methods and passing onto the appropriate view (see [[Templates]]).

For the examples below, we'll assume the following database schema:

	create table mytable (
		id int not null auto_increment primary key,
		name char(48) not null,
		age int not null,
		gender enum('m','f') not null,
		index (age),
		index (gender)
	);

Now we need to make a class for our custom model. In the `myapp` app created from [[Page routing and handler basics]], create a file called `apps/myapp/models/Mytable.php` and add the following code:

	<?php
	
	class Mytable extends Model {}
	
	?>

That's all that is required to define a model. We can now use it in a handler like this:

	<?php
	
	// create a new object with some data
	$m = new Mytable (array (
		'name' => 'John',
		'age' => 30,
		'gender' => 'm'
	));
	
	// save the data (insert or update)
	$m->put ();
	
	// output the id from the insertion
	echo $m->id;
	
	// update a value
	$m->age = 31;
	$m->put ();
	
	// remove the item
	$m->remove ();
	
	?>

This gives us a base object with very little code that handles all our CRUD operations for us in a consistent manner. We can also do custom queries like this:

	<?php
	
	$res = Mytable::query ()
		->where ('age > 30')
		->where ('gender', 'm')
		->order ('name asc')
		->fetch (20, 0);
	
	foreach ($res as $row) {
		// each $row is a Mytable object
		echo $row->name;
	}
	
	?>

If you're using this from an existing object, make sure not to forget the `query()` method at the start of the query to make sure the initial query state has been reset:

	<?php
	
	$res = Mytable::query ()
		->where ('age > 30')
		->where ('gender', 'm')
		->order ('name asc')
		->fetch (20, 0);
	
	foreach ($res as $row) {
		// each $row is a Mytable object
		echo $row->name;
	}
	
	?>

Let's use this to extend our model with a couple custom methods:

	<?php
	
	class Mytable extends Model {
		public function by_age ($age) {
			return self::query ()->where ('age', $age)->fetch ();
		}
	
		public function by_gender ($gender) {
			return self::query ()->where ('gender', $gender)->fetch ();
		}
	}
	
	?>

Now we can say things like `$res = Mytable::by_age ($age)` and `$res = Mytable::by_gender ($gender)`. Using this technique, we can encapsulate our model logic and help keep ourselves organized and our handlers short and sweet.

### Referencing other tables

Elefant's models provide powerful relationship modelling, including one-to-many, many-to-many, one-to-one, and belongs-to.

[Read more about modelling relationships in Elefant here](/wiki/Relations).

### Data validation

Models support the same data validation types as forms. You can define validation rules like this:

	<?php
	
	class Mytable extends Model {
		public $verify = array (
			'email' => array (
				'email' => 1,
				'contains' => '@ourdomain.com'
			),
			'name' => array (
				'not empty' => 1
			)
		);
	}
	
	?>

Alternately, you can define your validations in a separate INI-formatted file and reference it like this:

	<?php
	
	class Mytable extends Model {
		public $verify = 'apps/myapp/forms/mytable.php';
	}
	
	?>

For more info on input validation, see [[Forms and input validation]].