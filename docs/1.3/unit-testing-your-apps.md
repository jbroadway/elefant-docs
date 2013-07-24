# Unit testing your apps

Elefant uses [PHPUnit](http://www.phpunit.de/manual/current/en/index.html) as its testing framework of choice.

> Note: For info on running Elefant's own test suite, see the [[Contributing]] page.

To create unit tests for the custom libraries in your own apps, create a `tests` folder in your app (e.g., `apps/myapp/tests`). This is where your unit tests will go.

Now, suppose you have a very simple class in `apps/myapp/lib/MyClass.php` that looks like this:

	<?php
	
	class MyClass {
		/**
		 * Double any number given. Return false on
		 * non-numeric values.
		 */
		public static function double ($num) {
			if (! is_numeric ($num)) {
				return false;
			}
			return $num * 2;
		}
	}
	
	?>

To create a unit test for this class, you would first import the autoloader into your test then create the PHPUnit tests as you normally would. In the file `apps/myapp/tests/MyClassTest.php` enter:

	<?php
	
	require_once ('lib/Autoloader.php');
	
	class MyClassTest extends PHPUnit_Framework_TestCase {
		function test_double () {
			$this->assertEquals (false, MyClass::double ('nan'));
			$this->assertEquals (4, MyClass::double (2));
			$this->assertEquals (2.4, MyClass::double (1.2));
		}
	}
	
	?>

Now you're ready to run your tests. From the command line, enter the following:

	$ cd /path/to/your/site
	$ phpunit apps/myapp/tests

## Testing handlers

Elefant 1.2+ includes a special class called `AppTest` that extends PHPUnit to make it easier to test handlers in addition to regular classes. This class initializes the environment, including creating a test database in memory based on the default Elefant schema, that handlers expect.

`AppTest` also provides a few convenience methods for testing with different user levels, as well as the `get()` method which is an alias of `Controller::run()`.

Here's how you can write tests for your handlers:

	<?php
	
	require_once ('lib/Autoloader.php');
	
	class BlogAppTest extends AppTest {
		function test_index () {
			// Test the default output with no posts
			$res = $this->get ('blog/index');
			$this->assertContains ('No posts yet', $res);
			$this->assertNotContains ('Add Blog Post', $res);
	
			// Become an admin user
			$this->userAdmin ();
	
			// Test that the add posts link is present now
			$res = $this->get ('blog/index');
			$this->assertContains ('Add Blog Post', $res);
	
			// Become anonymous user again
			$this->userAnon ();
		}
	}
	
	?>

In addition to `userAdmin()` and `userAnon()` shown above, there's also a `userMember()` method to become a non-admin member of the site.

## Automating app tests

If you run `phpunit` from the root of your site with no options, it will run through the Elefant core test suite as well as any tests found in your apps. Of course this is slower for testing individual apps, since it adds the weight of Elefant's own tests to yours, but for automation it can be easier than specifying each app separately like the examples above.