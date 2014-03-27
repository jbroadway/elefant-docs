# Writing dynamic custom fields

Elefant makes it easy to add dynamic data to your [[user manual / custom fields]]
by defining a class with a callback method that supplies the dynamic data to a
field.

A `conf/fields.php` file in your app tells Elefant that your app defines new field
types that should be available in the Custom Fields forms.

Here is what a custom field type looks like in PHP:

~~~php
<?php // apps/myapp/lib/Category.php

namespace myapp;

class Category {
	public static function fetch_list ($class, $id = null) {
		// replace with a dynamic database call
		return array (
			'general' => 'General',
			'health' => 'Health'
		);
	}
}

?>
~~~

This example just returns a hard-coded array, but you can replace that with a database
call or another external data source. You can also use the `$class` and `$id` values
to filter the data. Note that the `$id` will be null when a form is adding content
instead of editing existing content.

To link this to the Custom Fields forms, enter the following in your `conf/fields.php`:

~~~php
; <?php /*

[myapp_categories]

name = "MyAPP: Categories"
type = select
callback = "myapp\Category::fetch_list"

; */ ?>
~~~

When you visit one of the Custom Fields forms in the Elefant admin, you should see your
new field type in the type list.

Next: [[:PHPUnit and testing]]
