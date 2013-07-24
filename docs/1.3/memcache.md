# Memcache

Elefant handlers have access to a `$cache` object that you can use to add caching to your custom code. This object uses the [Memcache API](http://www.php.net/manual/en/class.memcache.php), but provides a choice of several backends: APC, Filesystem, Memcache, Redis, and XCache. It defaults to caching files in the filesystem.

Here's an example of how easy it is to add caching to a handler in Elefant:

	<?php
	
	$res = $cache->get ('my_list');
	if (! $res) {
		$res = DB::fetch ('select * from foo');
		$cache->set ('my_list', $res, 3600); // 1 hour
	}
	
	?>

Alternately, you can implement it via a callback function like this:

	<?php
	
	$cache->cache ('my_list', 3600, function () {
		return DB::fetch ('select * from foo');
	});
	
	?>

The returned data will automatically be cached, and the function will only be called if the data isn't already in the cache.

## Handler caching

Elefant also supports automatic caching of a handler's output with a simple one-liner. To cache a handler indefinitely, use:

	<?php
	
	$this->cache = true;
	
	?>

To cache for 5 minutes, use:

	<?php
	
	$this->cache = 300;
	
	?>

Should you need to reset the cache for a handler (from another handler, since the original is being cached), you can delete the cache for any handler via:

	<?php
	
	$cache->delete ('_c_myapp_somehandler');
	
	?>

The key name takes the form `_c_myapp_somehandler` where the `_c_` has been added and slashes have been converted to underscores.

Note that there are some limitations to handler caching, namely that any headers or scripts that have been added via `header()` or `$this->add_script()` will not be added again, so make sure to only use this on handlers that don't use these.