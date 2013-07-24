# Database convenience functions

Elefant's database abstraction layer provides a handful of methods that wrap around the PDO connection management to provide easier access to the database for direct SQL queries. For more advanced data modelling, see [[Models]].

### `DB::execute($sql, $params)`

This executes an SQL query and returns true or false if it succeeded or failed. Use `DB::error()` to retrieve the error upon failure. The following example also illustrates the different ways you can pass parameters to each of these functions.

	<?php
	
	$res = DB::execute ('insert into foo (id, name, other) values (null, ?, ?)', $name, $other);
	
	// or
	
	$res = DB::execute (
		'insert into foo (id, name, other) values (null, ?, ?)',
		array ('name' => $name, 'other' => $other)
	);
	
	// or
	
	$obj = new StdClass;
	$obj->name = $name;
	$obj->other = $other;
	
	$res = DB::execute ('insert into foo (id, name, other) values (null, ?, ?)', $obj);
	
	?>

> Note: `DB::execute()` sends writes to the master for you, so you don't need to worry about replicated databases when you write your apps, and Model does this automatically too.

### `DB::fetch($sql, $params)`

This executes an SQL query and returns the results as an array of objects. Will return false on error.

	<?php
	
	foreach (DB::fetch ('select * from foo') as $row) {
		echo $row->name;
	}
	
	?>

### `DB::single($sql, $params)`

This executes an SQL query and returns the first result as an object. Will return false on error.

	<?php
	
	$row = DB::single ('select * from foo where id = ?', $id);
	echo $row->name;
	
	?>

### `DB::shift($sql, $params)`

This executes an SQL query and returns the first column from the first object. Will return false on error.

	<?php
	
	$name = DB::shift ('select name from foo where id = ?', $id);
	echo $name;
	
	?>

### `DB::shift_array($sql, $params)`

This executes an SQL query and returns the first column of the results as an array. Will return false on error.

	<?php
	
	foreach (DB::shift_array ('select name from foo') as $name) {
		echo $name;
	}
	
	?>

### `DB::pairs($sql, $params)`

This executes an SQL query and returns the first column of the results as an array. Will return false on error.

	<?php
	
	foreach (DB::pairs ('select id, name from foo') as $id, $name) {
		echo $id . ' - ' . $name;
	}
	
	?>

### `DB::last_id()`

This returns the last inserted id value from the last database query.

### `DB::error()`

This returns the last error message, or false if there was no error, from the last database query.