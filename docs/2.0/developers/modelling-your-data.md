# Modelling your data

Models in Elefant are simply PHP classes that live in your app's `models` folder.
Models are used to encapsulate your application logic and keep your handler scripts
lightweight.

Elefant also provides an [ActiveRecord](http://guides.rubyonrails.org/active_record_querying.html)-style
object-relational mapper (ORM) that is available by extending the
[Model](https://www.elefantcms.com/visor/lib/Model) class. This provides convenient ways
of storing and querying the database records associated with a model.

This page will focus primarily on the Model class and its use.

## Contents

* [A basic model](#a-basic-model)
* [Querying a model](#querying-a-model)
* [Custom methods](#custom-methods)
* [Data validation](#data-validation)
* [Flexible schemas with ExtendedModel](#flexible-schemas-with-extendedmodel)
* [Relations between models](#relations-between-models)
* [Direct database access](#direct-database-access)

## A basic model {#a-basic-model}

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

## Querying a model {#querying-a-model}

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

Here is an example of a more complex query using closures:

~~~php
<?php

$res = myapp\Person::query ()
	->where (function ($q) {
		$q->where ('age < ?', 18);
		$q->or_where ('age >= ?', 65);
	})
	->where ('gender', 'm')
	->order ('name', 'asc')
	->fetch (20, 0);

?>
~~~

The generated SQL query (with parameters inlined) would look like this:

~~~sql
SELECT *
FROM #prefix#myapp_people
WHERE (age < 18 or age >= 65)
AND gender = 'm'
ORDER BY name asc
LIMIT 20
OFFSET 0
~~~

## Custom methods {#custom-methods}

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

## Data validation {#data-validation}

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
			'type' => 'numeric',
			'range' => '1-150'
		),
		'gender' => array (
			'regex' => '/^(m|f)$/'
		)
	);
}

?>
~~~

Now whenever you execute a `put()` call on your models, if validation fails then it
will return false, set the `$error` property to `Validation failed for: fieldname` and
set the `$failed` property to a list of the fields that failed the validation.

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
range = 1-150

[gender]
regex = "/^(m|f)$/"

; */ ?>
~~~

## Flexible schemas with ExtendedModel {#flexible-schemas-with-extendedmodel}

[ExtendedModel](https://www.elefantcms.com/visor/lib/ExtendedModel) is a class that extends
Model to include a single field that can contain any JSON data, which will be encoded
and decoded for you automatically. This enables you to extend your models with any number
of additional properties without needing to change your schema.

Note that these values are not indexable directly, so they are better suited to fields
that don't form part of your search queries.

You define extended models by extending from `ExtendedModel` instead of `Model`, and
setting the `$_extended_field` property to the name of the column that will store the
JSON data:

~~~php
<?php

namespace myapp;

class Person extends \ExtendedModel {
	public $table = '#prefix#myapp_people';
	
	public $_extended_field = 'extra';
}

?>
~~~

The extended field will also have to be added to the database schema:

~~~sql
create table #prefix#myapp_people (
	id int not null auto_increment primary key,
	name char(48) not null,
	age int not null,
	gender enum('m','f') not null,
	extra text not null,
	index (age),
	index (gender)
);
~~~

Now you can access the extended values in a couple ways:

~~~php
<?php

// fetch an item
$p = new myapp\Person (1);

// update the extended field directly
$extra = $p->extra;
$extra['favorite_food'] = 'pizza';
$extra['favorite_color'] = 'green';
$p->extra = $extra;
$p->put ();

// update the extended field via the ext() method
$extra = $p->ext (); // same as $extra = $p->extra;
$p->ext ('favorite_food', 'pizza');
$p->ext ('favorite_color', 'green');
$p->put ();

// retrieve individual values from the extended field
echo $p->ext ('favorite_food');

?>
~~~

You can also define specific extended fields as well as validation rules for them in the
`$verify` array like this:

~~~php
<?php

namespace myapp;

class Person extends \ExtendedModel {
	public $table = '#prefix#myapp_people';
	
	public $_extended_field = 'extra';
	
	public $verify = array (
		'favorite_food' => array (
			'extended' => true
		),
		'favorite_color' => array (
			'extended' => true,
			'regex' => '/^(red|green|blue|yellow|orange|purple|pink|brown)$/i'
		)
	);
}

?>
~~~

The extended fields defined in `$verify` also become accessible as regular properties of
your model object, for example:

~~~php
<?php

$p = new myapp\Person (1);

echo $p->favorite_food;

$p->favorite_color = 'black';
if (! $p->put ()) {
	// this will fail because of the input validation on favorite_color
	echo $p->error;
}

?>
~~~

## Relations between models {#relations-between-models}

Model supports several types of relationships:

* `has_one` - A one-to-one relationship between two models, with the second one referencing the first.
* `has_many` - A one-to-many relationship between two models, with the objects in the second one referencing the first.
* `belongs_to` - The reverse of `has_one` or `has_many` relationships.
* `many_many` - A many-to-many relationship between two models, with a join table between them.

### has_one

A `has_one` relationship is used when you have two database tables, with the second one referencing the first, and you only want one record in the second table for each record in the first.

For example, say we have a `gallery` table and a `cover` image table to store additional fields related to the cover image (to keep the `gallery` table nice and slim).

~~~sql
create table gallery (
	id integer primary key,
	name char(32) not null
);

create table cover (
	id integer primary key,
	gallery int not null,
	image char(72) not null
);
~~~

A gallery only needs one cover image, so we use a `has_one` relationship to say ""A gallery has_one cover"" in our models, which we can describe as follows:

~~~php
<?php

class Gallery extends Model {
	public $fields = array (
		'cover' => array ('has_one' => 'Cover')
	);
}

?>
~~~

This will create a dynamic method `cover()` that will retrieve the `Cover` object associated with the current gallery. For example:

~~~php
<?php

$gallery = new Gallery (1);
$cover = $gallery->cover ();
echo $cover->image;

?>
~~~

> Note: We will define the `Cover` model in the `belongs_to` section below.

### has_many

Let's add an item table to our schema:

~~~sql
create table item (
	id integer primary key,
	gallery int not null,
	name char(32) not null
);
~~~

A gallery will have multiple items, so we can update our `Gallery` model and add a `has_many` relationship to `Item` (which we'll define in the next section):

~~~php
<?php

class Gallery extends Model {
	public $fields = array (
		'cover' => array ('has_one' => 'Cover'),
		'items' => array ('has_many' => 'Item')
	);
}

?>
~~~

Here we used the plural `items`, so the dynamic method will be `items()` and can be used like this:

~~~php
<?php

$gallery = new Gallery (1);

$items = $gallery->items ();

foreach ($items as $item) {
	printf ('%s<br />', $item->name);
}

?>
~~~

> Note: By default, models will assume the field name in the `cover` and `item` tables is the same as the `gallery` table name. To override this, add a `'field_name' => 'gallery_id'` to the field definition with the real field name:

~~~php
<?php

class Gallery extends Model {
	public $fields = array (
		'cover' => array (
			'has_one' => 'Cover',
			'field_name' => 'gallery_id'
		),
		'items' => array (
			'has_many' => 'Item',
			'field_name' => 'gallery_id'
		)
	);
}

?>
~~~

### belongs_to

Now it's time to create our `Cover` and `Item` models, which will use a `belongs_to` relation, which is the reverse of the `has_one` and `has_many` relations.

~~~php
<?php

class Cover extends Model {
	public $fields = array (
		'gallery' => array ('belongs_to' => 'Gallery')
	);
}

?>
~~~

And for the `Item` model:

~~~php
<?php

class Item extends Model {
	public $fields = array (
		'gallery' => array ('belongs_to' => 'Gallery')
	);
}

?>
~~~

> Note: By default, models will assume the field name is the same as the method name in a `belongs_to` relation, which is the key in the `$fields` array. You can override this in the same way as before by setting a custom `field_name` value.

Now that we've described both sides of the relationship, we can fetch the `Gallery` belonging to any `Cover` or `Item` object like this:

~~~php
<?php

$item = new Item (1);
$gallery = $item->gallery ();
echo $gallery->name;

$cover = new Cover (1);
$gallery = $cover->gallery ();
echo $gallery->name;	

?>
~~~

We can even chain them if we wish:

~~~php
<?php

$cover = new Cover (1);
$items = $cover->gallery ()->items ();

foreach ($items as $item) {
	printf ('%s<br />', $item->name);
}

?>
~~~

### many_many

Many-to-many relationships describe tables that can have multiple records in both that reference a single record in either. They do so using an intermediate table to join them.

Here's an example using books and authors:

~~~sql
create table author (
	id integer primary key,
	name char(32)
);

create table book (
	id integer primary key,
	name char(32)
);

create table book_author (
	book int not null,
	author int not null
);
~~~

The `book_author` table references both the `book` and the `author` tables and can contain any combination of IDs from either.

Here's how we can model that with Elefant for the `Author` model:

~~~php
<?php

class Author extends Model {
	public $fields = array (
		'books' => array (
			'many_many' => 'Book',
			'join_table' => 'book_author'
		)
	);
}

?>
~~~

And the `Book` model is the reverse of `Author`:

~~~php
<?php

class Book extends Model {
	public $fields = array (
		'authors' => array (
			'many_many' => 'Author',
			'join_table' => 'book_author'
		)
	);
}

?>
~~~

Now we can query in either direction as easy as this:

~~~php
<?php

$author = new Author (1);
$books = $author->books ();

$book = new Book (1);
$authors = $book->authors ();

?>
~~~

> Note: The field names will be inferred by the names of the two main tables. If you want to override them, you can specify them like this:

~~~php
<?php

class Author extends Model {
	public $fields = array (
		'books' => array (
			'many_many' => 'Book',
			'join_table' => 'book_author',
			'this_field' => 'author_id',
			'that_field' => 'book_id'
		)
	);
}

?>
~~~

### Sorting

Model relationships can specify an `order_by` value to specify how you want results sorted in a `has_many` or `many_many` relationship. It works like this:

~~~php
<?php

class Gallery extends Model {
	public $fields = array (
		'items' => array (
			'has_many' => 'Item',
			'order_by' => array ('name', 'asc')
		)
	);
}

?>
~~~

Now whenever you call `$gallery->items ()` the results will be sorted alphabetically for you.

### A word about caching

By default, the first time one of these dynamic methods is called, the result is memoized so the next call can simply return the same value without hitting the database again and again.

This works well most of the time, since PHP requests are short-lived and avoiding repeated calls to the database can be a big performance win. But sometimes you need to get a fresh copy, in case your database was updated elsewhere in the application. To do this, simply pass a boolean true value to the dynamic method call:

~~~php
<?php

$gallery = new Gallery (1);
$items = $gallery->items ();

// these results were memoized
$items = $gallery->items ();

// these are fresh from the database
$items = $gallery->items (true);

?>
~~~

This optimizes for performance first, but gives you the best of both worlds.

## Direct database access {#direct-database-access}

Elefant's database abstraction layer is based on PDO, and offers a number of benefits:

* Concise and consistent syntax
* Lazy-loading of connections
* Master/slave marshalling for read/write requests
* Transparent replication support
* Convenience methods to reduce code

### Connections

A connection is established automatically the first time you request database access,
based on the settings in `conf/config.php`. To get the underlying PDO connection, use:

~~~php
<?php

$conn = DB::get_connection ();

?>
~~~

To fetch the master connection for writes, use:

~~~php
<?php

$conn = DB::get_connection (1);

?>
~~~

In practice, this is rarely needed except when integrating with third party database
libraries. The PDO connection has two attributes set as well:

~~~
PDO::ATTR_ERRORMODE = PDO::ERRMODE_EXCEPTION
PDO::ATTR_DEFAULT_FETCH_MODE = PDO::FETCH_OBJ
~~~

If you use the PDO connection directly, be aware of those settings.

### Replication

Elefant knows to send writes to the master and reads are distributed randomly across
slaves automatically, with no extra code required.

A request will die on connection failure only if all connections fail, or the master
connection fails (since master is required for write commands). However, it will
continue serving from the available connections if one or more of the slaves becomes
unavailable.

### Convenience methods

#### `DB::execute ($sql, $params)`

Executes an SQL query and returns true or false if it succeeded or failed. Use `DB::error()`
to retrieve the error message upon failure. The example shows the different ways you can
pass parameters:

~~~php
<?php

$res = DB::execute ('insert into foo values (?, ?)', $name, $other);

// or

$res = DB::execute (
	'insert into foo values (?, ?)',
	array ('name' => $name, 'other' => $other)
);

// or

$obj = new StdClass;
$obj->name = $name;
$obj->other = $other;

$res = DB::execute ('insert into foo values (?, ?)', $obj);

?>
~~~

> Note: `DB::execute()` automatically sends writes to the master for you, so you don't
> need to worry about replicated databases when you write your apps, and Model does
> this automatically too.

#### `DB::fetch ($sql, $params)`

Executes an SQL query and returns the results as an array of objects. Returns false
on error.

~~~php
<?php

foreach (DB::fetch ('select * from foo') as $row) {
	echo $row->name;
}

?>
~~~

#### `DB::single ($sql, $params)`

Executes an SQL query and returns the first result as an object. Returns false on error.

~~~php
<?php

$row = DB::single ('select * from foo where id = ?', $id);
echo $row->name;

?>
~~~

#### `DB::shift ($sql, $params)`

Executes an SQL query and returns the first column from the first object. Returns false
on error.

~~~php
<?php

$name = DB::shift ('select name from foo where id = ?', $id);
echo $name;

?>
~~~

#### `DB::shift_array ($sql, $params)`

Executes an SQL query and returns the first column of the results as an array. Returns false
on error.

~~~php
<?php

foreach (DB::shift_array ('select name from foo') as $name) {
	echo $name;
}

?>
~~~

#### `DB::pairs ($sql, $params)`

Executes an SQL query and returns the first two columns as an associative array. Returns false
on error.

~~~php
<?php

foreach (DB::pairs ('select id, name from foo') as $id => $name) {
	echo $id . ' - ' . $name;
}

?>
~~~

#### `DB::last_id ()`

Returns the last inserted ID value from the last database query.

~~~php
<?php

if (DB::execute ('insert into bar (id, name) values (null, ?)', $name)) {
	echo DB::last_id ();
}

?>
~~~

#### `DB::error ()`

Returns the last error message from the last database query, or false if there was no error.

~~~php
<?php

if (! DB::execute ('insert into bar (id, name) values (null, ?, ?)', $name)) {
	echo DB::error ();
}

?>
~~~

#### Transactions

`DB::beginTransaction()`, `DB::rollback()` and `DB::commit()` provide database transaction
support.

~~~php
<?php

DB::beginTransaction ();

$names = array ('Joe', 'John', 'Jim');

foreach ($names as $name) {
	if (! DB::execute ('insert into bar (name) values (?)', $name)) {
		DB::rollback ();
		die ('The sky is falling!'); // too melodramatic?
	}
}

DB::commit ();

?>
~~~

#### `DB::get_connection ($master = 0)`

Fetches a database connection (PDO object). If `$master` is set to `1`, it will return the
master connection. If `$master` is set to `-1`, it will return a random connection from
only the slaves. If `$master` is set to `0`, it will return a random connection which
could be any of the slaves or the master.

~~~php
<?php

// get any connection
$pdo = DB::get_connection ();

// get the master connection
$master = DB::get_connection (1);

// get a slave connection
$slave = DB::get_connection (-1);

?>
~~~

Next: [[:Creating RESTful APIs]]