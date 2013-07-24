# Code example: Paging a data set

Elefant 1.1+ includes a built-in pager handler that can be used to simplify the displaying of paged data sets in your apps.

## 1. Calculating the values

First we need to set up a basic handler. Let's name it `apps/myapp/handlers/example.php` and we'll use a fictional `MyModel` model class to fetch data from.

	<?php
	
	// Set the limit and offset. Offset is calculated based on a page
	// number in the URL, e.g., /myapp/example/3
	$limit = 20;
	$num = isset ($this->params[0]) ? $this->params[0] : 1;
	$offset = ($num - 1) * $limit;
	
	// Now we query our model
	$items = MyModel::query ()->fetch ($limit, $offset);
	$total = MyModel::query ()->count ();
	
	// The data we need to pass to the view
	$data = array (
		'limit' => $limit,
		'total' => $total,
		'items' => $items,
		'count' => count ($items),
		'url' => '/myapp/example/%d'
	);

	// Render the view
	echo $tpl->render ('myapp/example', $data);
	
	?>

The limit is hard-coded, and the offset is calculated based on a page number specified in the URL of the request. Our requests will take the form `/myapp/example/3`. These help us retrieve the right records from our model.

In addition to these, the pager is going to need to know the format of the URL, as well as the limit, total, and count. The count is simply the number of records shown in the current page. We then pass these in the data structure to the view template. This is everything the pager handler needs from us.

## 2. Including the pager in our view

In your view template (`apps/myapp/views/example.html`) enter the following line:

	{! navigation/pager?style=text&url=[url]&total=[total]&count=[count]&limit=[limit] !}

This line includes the `navigation/pager` handler with the values calculated in our PHP code above. It will render a text-based pager that looks like this:

	« Newer results			 Older results »

Alternately we can render a number-based pager like this:

	{! navigation/pager?style=numbers&url=[url]&total=[total]&count=[count]&limit=[limit] !}

This will show:

	« 1 2 3 4 »

## Styling the pager elements

All elements can be styled with CSS classes. The structure of HTML output for the two pager styles is as follows:

Text-based pager:

	<div class=""pager"">
		<div class=""pager-text"">
			<span class=""pager-previous"">
				<a href=""{{ prev_link }}"">&laquo; Newer results</a>
			</span>
			<span class=""pager-next"">
				<a href=""{{ next_link }}"">Older results &raquo;</a>
			</span>
		</div>
	</div>

Number-based pager:

	<div class=""pager"">
		<div class=""pager-numbers"">
			<span class=""pager-number pager-first"">
				<a href=""{{ first_link }}"">&laquo;</a>
			</span>
			<span class=""pager-number"">
				<a href=""{{ num_link }}"">1</a>
			</span>
			<span class=""pager-number pager-current"">
				2
			</span>
			<span class=""pager-number"">
				<a href=""{{ num_link }}"">3</a>
			</span>
			<span class=""pager-number pager-last"">
				<a href=""{{ last_link }}"">&raquo;</a>
			</span>
		</div>
	</div>

Note that there are already built-in styles for these in the admin layout, but you will have to style them yourself if you use pagers in public-facing areas of your website.
