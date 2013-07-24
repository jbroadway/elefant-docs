# Creating dynamic navigation

See the [[Navigation]] page for the steps to manage your dynamic site navigation tree.

## Adding navigation to a block

To add a dynamic navigation element to an editable area of your site, click the edit button for the block you want to add it to. In the body field, click the Dynamic Objects button on the far right of the WYSIWYG editor:

![Dynamic Objects button](/files/docs/dynamic-objects-icon.png)

This will open the Dynamic Objects dialog:

![Dynamic Objects dialog](/files/docs/dynamic-objects-dialog.png)

In the dialog, find the Navigation objects. Click the paging buttons (""1, 2, 3"") at the bottom of the list to move through the list of objects. Let's choose the ""Navigation: Contextual"" object and embed it:

![Navigation Contextual embedded](/files/docs/navigation-contextual-embedded.png)

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


Next: [[Page elements for layouts]]