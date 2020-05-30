# Caching

Elefant provides a caching layer that mimics the
[Memcache API](http://www.php.net/manual/en/class.memcache.php)
with some additional conveniences, and provides the following storage options:

* [APC](http://php.net/apc) or [APCu](http://pecl.php.net/package/APCu)
* [Filesystem](https://www.elefantcms.com/visor/lib/Cache)
* [Memcache](http://php.net/memcache)
* [Redis](https://github.com/nicolasff/phpredis)
* [XCache](http://xcache.lighttpd.net/)

The filesystem is the default storage engine.

## Usage patterns

The cache is available to handlers via the `$cache` object which is provided by the
Controller when it calls your handler script.

Here is the most common usage pattern:

~~~php
<?php

$res = $cache->get ('my_list');
if (! $res) {
	$res = DB::fetch ('select * from foo');
	$cache->set ('my_list', $res, 3600); // 1 hour
}

?>
~~~

Alternately, you can implement caching via a callback function, which can help
separate your caching logic from your application logic:

~~~php
<?php

$res = $cache->cache ('my_list', 3600, function () {
	return DB::fetch ('select * from foo');
});

?>
~~~

The returned data will be cached for you, and the function will only be called
when the data isn't found in the cache, or the cached data has expired.

## Caching handlers

Elefant supports automatic caching of a handler's output with a simple one-liner.
To cache the output indefinitely:

~~~php
<?php

$this->cache = true;

?>
~~~

To cache for 5 minutes:

~~~php
<?php

$this->cache = 300;

?>
~~~

Handlers are cached with a key of the form `_c_myapp_somehandler` where `_c_` is
added as a prefix, and slashes in the handler path are converted to underscores.

You can use this to delete a cache entry for an indefinitely cached handler like
this:

~~~php
<?php

$cache->delete ('_c_myapp_somehandler');

?>
~~~

It's important to note the limitations of handler caching, namely that any headers
or scripts that have been added via `$this->header()` or `$this->add_script()` will
not be cached, so make sure to only cache handlers that don't make use of these.

## Clearing the cache folder

Elefant provides a command line option to clear your cache folder of not just its cache
data but also its compiled templates and site navigation:

~~~bash
./elefant clear-cache
~~~

This is a safer alternative to `rm -rf cache/*` since it is careful not to erase
additional data other apps may be storing in the cache folder, such as image
thumbnails.

Next: [[:Logging]]
