# Custom user authentication

Elefant supports pluggable authentication schemes through the Controller's `require_auth()` method. It also provides a few built-in schemes for easier use in building RESTful APIs, including HTTP Basic and HMAC.

### Basics

To implement the HMAC built-in handler, use:

	<?php
	
	$this->require_auth (userAuthHMAC::init (
		$this,		// Controller
		$memcache,	// Memcache
		3600		// Timeout
	));
	
	// User has been authorized via HMAC, let's continue
	$this->restful (new MyRestfulClass ());
	
	?>

### Custom handlers

To implement custom authentication in a handler, here's the most basic structure:

	<?php
	
	$this->require_auth (
		function ($user, $pass) {
			// verify the username and password here
			// and return true or false, for example:
			
			if ($user === 'steve' && $pass === 'secret') {
				return true;
			}
			return false;
		},
		function ($callback) {
			// here you communicate with the client
			// for example, HTTP Basic works like this:
			
			if (! isset ($_SERVER['PHP_AUTH_USER']) || ! call_user_func ($callback, $_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {
				header ('WWW-Authenticate: Basic realm=""This Website""');
				header ('HTTP/1.0 401 Unauthorized');
				return false;
			}
			return true;
		}
	);
	
	// carry on with your authenticated handler
	
	?>

These two callback functions are used in the following manner:

### verifier(user, pass) -> bool

This function takes a username/password combo and checks if it's valid. Where it determines that info is completely up to you.

### method(callback) -> bool

This function takes the verifier function as a callback. Its job is to provide the method or protocol support.

In HTTP Basic, that means checking for the `$_SERVER['PHP_AUTH_USER']` and `$_SERVER['PHP_AUTH_PW']` values, passing them to the verifier, and on failure returning the necessary HTTP headers.

In the case of cookie-based authentication, it initializes the session, passes the username/password values from `$_POST` to the verifier if those are set, and if not then it verifies the session cookie if present.

`require_auth()` takes these functions and combines them like this:

    return call_user_func ($method, $verifier);

How you call the verifier from your method function is up to you. For examples on implementing your own custom authentication, see `apps/user/models/User.php` which implements both of these methods, and the classes in `apps/user/lib/Auth` as well.

As you can see, implementing your own authentication scheme using this technique is powerful, but straightforward and easy.