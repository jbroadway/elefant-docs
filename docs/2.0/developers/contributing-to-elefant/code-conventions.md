# Code conventions

Elefant uses the following conventions for all core libraries and apps:

### Naming conventions

* Classes start with capitals and use camel case
* Methods, functions, and properties should be lowercase and use underscores (like Ruby and Python)

### Tabs, not spaces

Elefant code should be indented with tabs, not spaces. This way, individual developers can adjust their editor settings to the amount of indentation they prefer.

### Braces and spacing

Elefant code should use trailing braces instead of putting them on their own lines. Put a space before open braces and between operators, for example:

	<?php
	
	function foo_bar ($foo = false) {
		if (! $foo) {
			// etc.
		}
	}
	

### Comments

Use JavaDoc-style commenting for describing classes and methods, and use double-slashes for inline comments.

Comments describing classes, methods, and properties should use the [Markdown](https://daringfireball.net/projects/markdown/syntax) format for formatting text.

### A complete example

For reference, here is a complete example class in the recommended style:

	<?php
	
	namespace myapp;
	
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
	
	
> Note: PHP closing tags should not be included and files should end with a blank line.

Back: [[Developers / Contributing to Elefant]]
