# Relations

Models support several relationship types:

* `has_one` - A one-to-one relationship between two models, with the second one referencing the first.
* `has_many` - A one-to-many relationship between two models, with the second one referencing the first.
* `belongs_to` - The reverse of `has_one` or `has_many` relationships.
* `many_many` - A many-to-many relationship between two models, with a join table between them.

Below are examples of each relationship type.

## has_one

A `has_one` relationship is used when you have two database tables, with the second one referencing the first, and you only want one record in the second table for each record in the first.

For example, say we have a `gallery` table and a `cover` image table to store additional fields related to the cover image (to keep the `gallery` table nice and slim).

	create table gallery (
		id integer primary key,
		name char(32) not null
	);
	
	create table cover (
		id integer primary key,
		gallery int not null,
		image char(72) not null
	);

A gallery only needs one cover image, so we use a `has_one` relationship to say ""A gallery has_one cover"" in our models, which we can describe as follows:

	<?php
	
	class Gallery extends Model {
		public $fields = array (
			'cover' => array ('has_one' => 'Cover')
		);
	}
	
	?>

This will create a dynamic method `cover()` that will retrieve the `Cover` object associated with the current gallery. For example:

	<?php
	
	$gallery = new Gallery (1);
	$cover = $gallery->cover ();
	echo $cover->image;
	
	?>

> Note: We will define the `Cover` model in the `belongs_to` section below.

## has_many

Let's add an item table to our schema:

	create table item (
		id integer primary key,
		gallery int not null,
		name char(32) not null
	);

A gallery will have multiple items, so we can update our `Gallery` model and add a `has_many` relationship to `Item` (which we'll define in the next section):

	<?php
	
	class Gallery extends Model {
		public $fields = array (
			'cover' => array ('has_one' => 'Cover'),
			'items' => array ('has_many' => 'Item')
		);
	}
	
	?>

Here we used the plural `items`, so the dynamic method will be `items()` and can be used like this:

	<?php
	
	$gallery = new Gallery (1);
	
	$items = $gallery->items ();
	
	foreach ($items as $item) {
		printf ('%s<br />', $item->name);
	}
	
	?>

> Note: By default, models will assume the field name in the `cover` and `item` tables is the same as the `gallery` table name. To override this, add a `'field_name' => 'gallery_id'` to the field definition with the real field name:

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

## belongs_to

Now it's time to create our `Cover` and `Item` models, which will use a `belongs_to` relation, which is the reverse of the `has_one` and `has_many` relations.

	<?php
	
	class Cover extends Model {
		public $fields = array (
			'gallery' => array ('belongs_to' => 'Gallery')
		);
	}
	
	?>

And for the `Item` model:

	<?php
	
	class Item extends Model {
		public $fields = array (
			'gallery' => array ('belongs_to' => 'Gallery')
		);
	}
	
	?>

> Note: By default, models will assume the field name is the same as the method name in a `belongs_to` relation, which is the key in the `$fields` array. You can override this in the same way as before by setting a custom `field_name` value.

Now that we've described both sides of the relationship, we can fetch the `Gallery` belonging to any `Cover` or `Item` object like this:

	<?php
	
	$item = new Item (1);
	$gallery = $item->gallery ();
	echo $gallery->name;

	$cover = new Cover (1);
	$gallery = $cover->gallery ();
	echo $gallery->name;	
	
	?>

We can even chain them if we wish:

	<?php
	
	$cover = new Cover (1);
	$items = $cover->gallery ()->items ();
	
	foreach ($items as $item) {
		printf ('%s<br />', $item->name);
	}
	
	?>

## many_many

Many-to-many relationships describe tables that can have multiple records in both that reference a single record in either. They do so using an intermediate table to join them.

Here's an example using books and authors:

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

The `book_author` table references both the `book` and the `author` tables and can contain any combination of IDs from either.

Here's how we can model that with Elefant for the `Author` model:

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

And the `Book` model is the reverse of `Author`:

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

Now we can query in either direction as easy as this:

	<?php
	
	$author = new Author (1);
	$books = $author->books ();
	
	$book = new Book (1);
	$authors = $book->authors ();
	
	?>

> Note: The field names will be inferred by the names of the two main tables. If you want to override them, you can specify them like this:

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

## Sorting

Model relationships can specify an `order_by` value to specify how you want results sorted in a `has_many` or `many_many` relationship. It works like this:

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

Now whenever you call `$gallery->items ()` the results will be sorted alphabetically for you.

## A word about caching

By default, the first time one of these dynamic methods is called, the result is memoized so the next call can simply return the same value without hitting the database again and again.

This works well most of the time, since PHP requests are short-lived and avoiding repeated calls to the database can be a big performance win. But sometimes you need to get a fresh copy, in case your database was updated elsewhere in the application. To do this, simply pass a boolean true value to the dynamic method call:

	<?php
	
	$gallery = new Gallery (1);
	$items = $gallery->items ();
	
	// these results were memoized
	$items = $gallery->items ();
	
	// these are fresh from the database
	$items = $gallery->items (true);
	
	?>

This optimizes for performance first, but gives you the best of both worlds.