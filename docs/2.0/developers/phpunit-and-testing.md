# PHPUnit and testing

Elefant's unit tests are written using [PHPUnit](http://www.phpunit.de/manual/current/en/index.html),
and some additional help is provided for app developers writing tests for their own apps as well.

To create unit tests for your app, create a `tests` folder in your app (e.g., `apps/myapp/tests`).
This is where your unit tests will live.

## A basic unit test

Suppose you have a very simple class defined in `apps/myapp/lib/MyClass.php` that looks like this:

~~~php
<?php

namespace myapp;

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
~~~

To create a unit test for this class, create a file named `apps/myapp/tests/MyClassTest.php`
like the following:

~~~php
<?php

namespace myapp;

class MyClassTest extends \PHPUnit_Framework_TestCase {
    public function test_double () {
        $this->assertEquals (false, MyClass::double ('nan'));
        $this->assertEquals (4, MyClass::double (2));
        $this->assertEquals (2.4, MyClass::double (1.2));
    }
}

?>
~~~

To run your tests, use the following command:

~~~bash
$ phpunit apps/myapp/tests
~~~

You can also specify an individual test to run alone:

~~~bash
$ phpunit apps/myapp/tests/MyClassTest.php
~~~

## Testing handlers

Elefant includes a special class called [AppTest](https://www.elefantcms.com/visor/lib/AppTest)
that extends PHPUnit to make it easier to test handlers in addition to regular PHP classes.
This class initializes the Elefant environment, including creating a test database in memory
based on the default Elefant schema, that handlers may expect to be present.

AppTest also provides a few convenience methods for testing with different user levels, as
well as a `get()` method which is an alias of `Controller::run()`.

Here's an example unit test for the `blog/index` handler:

~~~php
<?php

class BlogAppTest extends AppTest {
	public function test_index () {
		// Test the default output with no posts
		$res = $this->get ('blog/index');
		$this->assertContains ('No posts yet', $res);
		$this->assertNotContains ('Add Blog Post', $res);
		
		// Become an admin user
		$this->userAdmin ();
		
		// Test that the add posts link is now present
		$res = $this->get ('blog/index');
		$this->assertContains ('Add Blog Post', $res);
		
		// Become an anonymous user again
		$this->userAnon ();
	}
}

?>
~~~

In addition to `userAdmin()` and `userAnon()` in the above example, there's also a `userMember()`
method to become a non-admin member of the site.

## Automating app tests

If you run `phpunit` from the root of your site with no options, it will run through the
core test suite as well as any tests found in your apps. Of course this is slower for
testing individual apps, since it adds the weight of the core tests to each test run,
but for automation it can be easier than specifying each app separately like the
examples above.

Next: [[Developers / Using Composer and Packagist]]
