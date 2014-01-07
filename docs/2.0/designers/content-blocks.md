# Content blocks

Content blocks are editable areas of your template that can be linked to one or more pages of your site. When you add a block to your template, Elefant automatically includes its inline editing buttons so your editors can manage that content.

The simplest way of including a block is as follows:

~~~
{! blocks/my-block-id !}
~~~

The block ID is an arbitrary value and you can set it to anything name you like, although it should contain only lowercase letters, numbers, and dashes. Blocks also need to have unique IDs from each other.

Once you've defined a block and saved your template, the first time you visit a page that uses that template you will see an `Add Block` icon that looks like this when you hover over it:

![Add Block icon](/apps/docs/docs/2.0/pix/content-blocks-add.png)

Click the icon to create your block. Each block has a title and body, and you can specify whether to display the title or not, as well as whether the block is visible to the public, members-only, or private (admin only).

Once you've created the block, the add button will be replaced by a series of edit buttons that look like this:

![Edit Block icons](/apps/docs/docs/2.0/pix/content-blocks-edit.png)

## Block options

If you want to change the block ID based on the current page ID, change the block tag used to this:

~~~
{! blocks/index?id=[id]-block !}
~~~

The page ID is passed in as a sub-expression (`[id]`) so when you visit the `about` page, Elefant will replace `[id]` with `about` and look for the block with the `about-block` ID.

The trouble here is with dynamic pages that don't have an ID set. In this case, it would look for a block with the ID `-block`. Instead, why not give it a specific block ID to fall back on?

~~~
{! blocks/index?id=[id]-block&fallback=fallback-block !}
~~~

Now if it doesn't find a match based on the `id` value, it will fetch the block with ID `fallback-block` and use that.

One last option you may want is to specify a different heading level for the block title. By default, block titles are wrapped in an `<h3>` tag, but you can set a custom level like this:

~~~
{! blocks/my-block-id?level=h2 !}
~~~

This will now use an `<h2>` tag for your block title. Similarly, with more block options:

~~~
{! blocks/index?id=[id]-block&fallback=fallback-block&level=h2 !}
~~~

As you can see, blocks are an easy and flexible way to add editable content to your sites.

## Block groups

Sometimes you want to grab a series of blocks in a row. For these cases, Elefant offers the `blocks/group` handler, which will fetch a series of blocks in a single database query and render each one in turn.

The simplest form of this is as follows:

~~~
{! blocks/group/block-one/block-two/block-three !}
~~~

This will fetch blocks `block-one`, `block-two`, and `block-three` and render them one after another.

To make this more readable, we can use the `id` parameter and spread the tag over multiple lines like this:

~~~
{! blocks/group
	?id[]=block-one
	&id[]=block-two
	&id[]=block-three !}
~~~

Often you'll want to style your blocks to appear separate from one another, instead of as a series of continuous content, for example into multiple columns or highlighting one to draw visitors to it first. For this, we have the `divs` attribute:

~~~
{! blocks/group
	?id[]=sidebar-promo
	&id[]=sidebar-support
	&divs=on !}
~~~

This will wrap each block in its own `<div class="block">` tag, with the `id` attribute set to `block-{$id}`. For example, the last example will produce the following HTML:

~~~
<div class="block" id="block-sidebar-promo">
	<h3>Block title</h3>
	<p>Block contents...</p>
</div>
<div class="block" id="block-sidebar-support">
	<h3>Block title</h3>
	<p>Block contents...</p>
</div>
~~~

Block groups also support the `level` parameter, allowing you to specify the heading level to use for the block titles.

## Styling your blocks

A single block tag does not include a wrapping `<div>`, so to style them it is best to wrap them in a `<div>` with an ID attribute:

~~~
<div id="my-block-id">
	{! blocks/my-block-id !}
</div>
~~~

This lets you easily style your `div#my-block-id` any way you need. For example:

~~~
div#my-block-id {
	/* block styles here */
}
~~~

### Styling block groups

To make a block group easily styled, first make sure to add the `divs=on` parameter, then style your blocks together and individually like this:

~~~
div.block {
	/* shared block styles */
}

	div#block-sidebar-promo {
		/* block one styles */
	}

	div#block-sidebar-support {
		/* block two styles */
	}
~~~

Next: [[:Including dynamic content]]