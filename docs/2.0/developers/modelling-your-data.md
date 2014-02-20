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

class Person extens \Model {
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

...

## Custom methods

...

## Relations to other models

...

## Data validation

...

## Flexible schemas with ExtendedModel

...

## Direct database access

...

Next: [[:View templates]]
