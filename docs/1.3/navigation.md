# Navigation

Elefant features a Navigation tool under the Tools menu that you can use to build dynamic navigation on your website. Once you've created your pages, go to Tools > Navigation to add them to the site menus.

Elefant's dynamic navigation tree is separate from the page list itself for two reasons:

1. Your site tree is hard to manage when it's managed on a page-by-page basis
2. Just because you add a page somewhere doesn't mean you want it to affect your menus automatically (this can lead to broken looking menus and mistakes)

That's why we keep the two separate and keep things simple and *predictable* for Elefant site editors.

## Navigation tool

The Navigation tool uses a two-column layout, with the site tree on the left, and pages not yet included in the site tree on the right.

![Navigation tool](http://jbroadway.github.com/elefant/wiki/navigation-01.png)

To include a page in the site tree, drag it from the right column into the site tree on the left. Here's the same screenshot after the Consulting page has been added under Services in the site tree:

![Navigation tool - page added](http://jbroadway.github.com/elefant/wiki/navigation-02.png)

To re-order pages, simply drag and drop them around the site tree. This screen gives you full control of your site navigation, and changes are automatically saved behind-the-scenes.

## Adding navigation to a block

To add a dynamic navigation element to an editable area of your site, click the edit button for the block you want to add it to. In the body field, click the Dynamic Objects button on the far right of the WYSIWYG editor:

![Dynamic Objects button](http://jbroadway.github.com/elefant/wiki/dynamic-objects-button.png)

This will open the Dynamic Objects dialog:

![Dynamic Objects dialog](http://jbroadway.github.com/elefant/wiki/dynamic-objects-dialog.png)

In the dialog, find the Navigation objects. Click the paging buttons (""1, 2, 3"") at the bottom of the list to move through the list of objects. Let's choose the ""Navigation: Contextual"" object and embed it:

![Navigation Contextual embedded](http://jbroadway.github.com/elefant/wiki/navigation-contextual-embedded.png)

Now you can save the changes and you'll see the contextual navigation dynamically inserted into your page where the block appears. There are several types of built-in navigation to choose from:

* Top-level links - shows only top-level pages
* Section links - shows pages under a specific page
* Site map - shows the full site tree
* Contextual - shows top-level pages, and expands the tree when on a page in a certain section

## Styling your contextual menu

All of the navigation objects simply generate a standard unordered list in HTML. However, the current page's `<li>` is given a `class=""current""` and parents of it in the contextual menu are given a `class=""parent""`. With these, we can create a series of custom styles for each aspect of the contextual menu as follows:

~~~
/* Top-level links */
#sidebar ul li a {
       font-weight: bold;
       color: #666;
}

/* Sub-level links */
#sidebar li li a {
       font-weight: normal;
}

/* Parent links of current page */
#sidebar .parent>a {
       color: #E4426B;
}

/* Current page link */
#sidebar .current>a {
       font-weight: bold;
       font-style: italic;
       color: #E4426B;
}
~~~

Next: [[Duplicate pages in your nav]]
