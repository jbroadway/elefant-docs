# Flexible schemas with ExtendedModel

`ExtendedModel` offers the ability to assign one field in your schema to store any data you want in a serialized JSON array. This lets you add any number of additional properties to a model without altering its schema. An example of this is the `User` model defined in the `user` app (see [[Custom user properties]]) or the `blogPost` model in the `blog` app.

## Creating an ExtendedModel

To create an ""extended model"" simply inherit from `ExtendedModel` instead of `Model` and define your JSON field in the `$_extended_field` property like this:

	<?php
	
	class MyModel extends ExtendedModel {
		public $_extended_field = 'extra';
	}
	
	?>

Here's a sample schema for the above model:

	create table mymodel (
		id int not null auto_increment primary key,
		extra text not null
	);

## Validating extended properties

In addition, you can also specify validation rules for pre-defined extended properties, as long as you also mark them as extended. This is done in the `$verify` array that's used to add input validation to a model:

	<?php
	
	class MyModel extends ExtendedModel {
		public $_extended_field = 'extra';
		
		public $verify = array (
			'favorite_food' => array (
				'extended' => 1
			),
			'favorite_color' => array (
				'extended' => 1,
				'regex' => '/^(red|green|blue|etc)$/'
			)
		);
	}
	
	?>

## Setting extended properties

There are three ways of accessing the extended properties:

First, you can simply grab a copy of the extended field and add items to it like this:

	<?php
	
	// fetch an object
	$obj = new MyModel (1);
	
	// get the extra field and add to it
	$extra = $obj->extra;
	$extra['photo'] = 'example.jpg';

	// now update the object and save it
	$obj->extra = $extra;
	$obj->put ();
	
	?>

The second way is through the `ext()` method, which eliminates the need to grab a copy of the extended field (which ordinarily is required because accessing individual array elements won't trigger PHP's magic __get/__set methods). This lets us rewrite the above as:

	<?php
	
	// fetch an object
	$obj = new MyModel (1);
	
	// set an extra field and save it
	$obj->ext ('photo', 'example.jpg');
	$obj->put ();
	
	?>

You can also get values through the same method:

	<?php
	
	// fetch an object
	$obj = new MyModel (1);
	
	echo $obj->ext ('photo');
	
	?>

Or you can retrieve the full list of extended properties by calling `ext()` with no arguments:

	<?php
	
	// fetch an object
	$obj = new MyModel (1);

	// these two lines do the same thing
	$extra = $obj->extra;
	$extra = $obj->ext ();
	
	?>

The third way requires that you pre-define your extended properties like we did in the `$verify` array above. This isn't always something you can do, but when you can, the magic __get/__set methods will let you access individual extended properties just like they were normal properties of the object, like this:

	<?php
	
	// fetch an object
	$obj = new MyModel (1);
	
	// can't do this because it's not in $verify
	echo $obj->photo;

	// but we can do this because it is
	echo $obj->favorite_color;
	
	// and we can also say
	$obj->favorite_color = 'foobar';
	
	// but remember the input validation? well, this will
	// fail because 'foobar' isn't a real color
	$obj->put ();
	
	?>
