# Chunked transfer encoding

Elefant's handlers can do chunked transfer encoding through the Controller's `flush()` method. Here's an example of how to use it:

	<?php
	
	$list = array ('Item one', 'Item two', 'Item three', 'Item four');
	
	echo '<ul>';
	foreach ($list as $item) {
		printf ('<li>%s</li>', $item);
		$this->flush ();
	}
	echo '</ul>';
	
	?>

This will result in the following server output (some headers omitted for brevity):

	HTTP/1.1 200 OK
	Transfer-Encoding: chunked
	Content-Type: text/html
	
	15
	<ul><li>Item one</li>
	11
	<li>Item two</li>
	13
	<li>Item three</li>
	12
	<li>Item four</li>
	5
	</ul>
	0
	

Note that once you call `flush()`, the remaining output at the end of your handler will not be cached through the Controller's automatic caching, and it will not be returned to the front controller for layout rendering, but will instead be flushed automatically and exit.

Also note that the `Transfer-Encoding: chunked` header will be sent automatically on the first call to `flush()`.