# Modelling your data

Models in Elefant are simply PHP classes that live in your app's `models` folder.
Models are used to encapsulate your application logic and keep your handler scripts
lightweight.

Elefant also provides an [ActiveRecord](http://guides.rubyonrails.org/active_record_querying.html)-style
object-relational mapper (ORM) that is available by extending the
[Model](http://api.elefantcms.com/visor/lib/Model) class. This provides convenient ways
of storing and querying the database records associated with a model.

This page will focus on the Model class and its use.

## A basic model

For the examples below, we'll assume the following database schema:

~~~sql
create table #prefix#myapp_people (
	id int not null auto_increment primary key,
	name char(48) not null,
	age int not null,
	gender enum('m','f') not null,
	index (age),
	index (gender)
);
~~~

> Note the use of `#prefix#` in the table name. This inserts Elefant's global database
prefix into the query, so with the default prefix of `elefant_` the final table name
will be `elefant_myapp_people`.

Here is a model that reads and writes to the above table:

~~~php
<?php

namespace myapp;

class Person extends \Model {
	public $table = '#prefix#myapp_people';
}

?>
~~~

That's all that's required to define a model. Now we can use it in a handler like this:

~~~php
<?php

// create a new person with some data
$p = new myapp\Person (array (
	'name' => 'John',
	'age' => 30,
	'gender' => 'm'
));

// save the data (insert or update)
$p->put ();

// output the id from the insertion
echo $p->id;

// update a value and save the changes
$p->age = 31;
$p->put ();

// remove the item
$p->remove ();

?>
~~~

## Querying a model

The Model class defines a number of methods that can be chained together to compose
search queries. Here's an example:

~~~php
<?php

$res = myapp\Person::query ()
	->where ('age > ?', 30)
	->where ('gender', 'm')
	->order ('name', 'asc')
	->fetch (20, 0);

foreach ($res as $row) {
	// each $row is a myapp\Person object
	echo $row->name;
}

?>
~~~

A query begins with the static `::query()` method, which returns a new, blank instance
of the model. Each method in the chain after that then returns the same object with the
added search options, until the last method performs the query itself and returns the
results.

Here is a list of querying methods:

* `from($from)` - Specify an alternate FROM clause
* `group($group)` - Group the results
* `having($key, $value)` - Add a HAVING clause
* `order($by, $sorting)` - Sort the results
* `or_where($key, $value)` - Add an OR clause to the query
* `where($key, $value)` - Add a WHERE clause

The fetching method at the end of the query can be one of:

* `count($limit, $offset)` - Fetch the number of results for a query
* `fetch($limit, $offset)` - Fetch the results as an array of model objects
* `fetch_assoc($key, $value, $limit, $offset)` - Fetch the results as associative arrays
* `fetch_field($field, $limit, $offset)` - Fetch an array of a single field
* `fetch_orig($limit, $offset)` - Fetch the results as an array of plain objects
* `single()` - Fetch just a single object from the query
* `sql($limit, $offset)` - Return the SQL query without executing it

## Custom methods

Custom methods should be used to encapsulate the logic around your model operations.
For example, here is a method that will return all men or all women from our model:

~~~php
<?php

namespace myapp;

class Person extends \Model {
	public $table = '#prefix#myapp_people';
	
	public function by_gender ($gender = 'm') {
		return self::query ()
			->where ('gender', $gender)
			->fetch ();
	}
}

?>
~~~

And to use this method you could write:

~~~php
<?php

$p = new myapp\Person;

$res = $p->by_gender ('m');
if (! is_array ($res)) {
	error_log ($p->error);
	return;
}

// do something with $res

?>
~~~

## Data validation

Models support the same [input validation types](/docs/2.0/developers/input-validation)
as forms. These help prevent invalid data from being saved. To define validation rules,
set the `$verify` property like this:

~~~php
<?php

namespace myapp;

class Person extends \Model {
	public $table = '#prefix#myapp_people';
	
	public $verify = array (
		'age' => array (
			'type' => 'numeric'
		),
		'gender' => array (
			'regex' => '/^(m|f)$/'
		)
	);
}

?>
~~~

You can also store the validations in their own file, just like form validations, by
setting `$verify` to the path to your validation file:

~~~php

<?php

namespace myapp;

class Person extends \Model {
	public $table = '#prefix#myapp_people';
	
	public $verify = 'apps/myapp/forms/person.php';
}

?>
~~~

In the validation file, the same validations as above would look like this:

~~~ini
; <?php /*

[age]
type = numeric

[gender]
regex = "/^(m|f)$/"

; */ ?>
~~~

## Relations to other models

...

## Flexible schemas with ExtendedModel

...

## Direct database access

...

Next: [[:View templates]]
