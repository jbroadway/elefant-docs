# Creating editable areas

In addition to the edit buttons that are automatically included in layouts just above the page body, it's easy to setup editable areas of your layouts in Elefant. Elefant has a feature called Blocks for this. To define a block in your template, you use the following code:

~~~
{! blocks/my-block-id !}
~~~

The block ID is an arbitrary value and can be anything you'd like. Just make sure each block you define has its own unique ID and you're all set.

Once you've defined your blocks and saved your layout, visit a page on the site that uses the layout and you'll see an `Add Block` icon that looks like this when you hover over it:

![Add Block icon](http://jbroadway.github.com/elefant/wiki/add-block.png)

Click that and create your block. Each block has a title and body, and you can choose whether to display the title or not, as well as whether the block is visible to the public, members-only, or private (admin only).

Once you've created the block, whenever you're logged in as an admin you'll always see edit buttons like the following at the top of the block:

![Edit Block icons](http://jbroadway.github.com/elefant/wiki/edit-block.png)

That's all there is to it.

## Styling individual blocks

A tip for styling your blocks is to wrap them in a div and give it an ID:

    <div id=""my-block"">
    {! blocks/my-block !}
    </div>

Now you can easily style your `div#my-block` and anything inside it.

## Dynamic blocks per-page

If you want to create an editable block that changes for each page of the site, you might do it like this:

~~~
{% if id == 'about' %}
  {! blocks/about !}
{% elseif id == 'products' %}
  {! blocks/products !}
{% end %}
~~~

But that gets messy quickly. Another way would be to create separate templates for each page with hard-coded block tags. But that would needlessly clutter up your templates folder.

Elefant lets you specify sub-expressions inside your `{! !}` tags using `[]` braces. Using these, we can reduce the above to:

~~~
{! blocks/index?id=[id] !}
~~~

With this you can now show a different block of content on each page, by dynamically mapping the current page's ID value to the block's ID value.

Next: [Creating dynamic navigation](/wiki/Navigation)