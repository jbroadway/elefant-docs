# Code conventions

Elefant uses the following conventions for the core libraries:

### Naming conventions

* Classes start with capitals and use camel case
* Methods, functions, and properties should be lowercase and use underscores (like Ruby and Python)

### Tabs, not spaces

Elefant code should be indented with tabs, not spaces. This way, individual developers can adjust their editor settings to the amount of indentation they prefer.

### Braces and spacing

Elefant code should use trailing braces instead of giving them their own lines. Put a space before open braces and between operators, for example:

	<?php
	
	function foo_bar ($foo = false) {
		if (! $foo) {
			// etc.
		}
	}
	
	?>

### Comments

Use JavaDoc-style commenting for describing classes and methods, and use double-slashes for inline comments.

### A complete example

For reference, here is a complete example in the recommended style:

	<?php
	
	/**
	 * Class description here.
	 */
	class FooBar {
		/**
		 * A property.
		 */
		public $name = 'Default value';

		/**
		 * A method.
		 */
		public function set_name ($new_name) {
			$this->name = $new_name;
		}
	}
	
	?>
	
> Note: PHP closing tags are generally used, but optional.
