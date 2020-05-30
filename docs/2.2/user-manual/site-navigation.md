# Site navigation

Elefant features a Navigation app under the Tools menu that you can use to build dynamic navigation on your website. Once you've created your pages, go to Tools > Navigation to add them to your site's navigation.

## The site tree

The Navigation app uses a two-column layout, with the site tree on the left, and pages not yet included in the site tree on the right.

![Navigation app](/apps/docs/docs/2.2/pix/navigation-01.png)

To include a page in the site tree, drag it from the right column into the site tree on the left. Here's the same screenshot after the Consulting page has been added under Services in the site tree:

![Navigation app - page added](/apps/docs/docs/2.2/pix/navigation-02.png)

To re-order pages, simply drag and drop them around the site tree. This screen gives you full control of your site navigation, and changes are automatically saved behind-the-scenes.

## Adding navigation to your site

The Navigation app includes a number of built-in handlers that you can embed into your design templates or include in pages via the [[:Dynamic Objects]] menu. Here are some of the ones you can choose from:

* Top-level links - shows only top-level pages
* Section links - shows pages under a specific page
* Site map - shows the full site tree
* Contextual - shows top-level pages, and expands the tree when on a page in a certain section
* Breadcrumb - shows a breadcrumb trail to the current page

## Styling your menus

All of the navigation objects simply generate a standard unordered list in HTML. However, the current page's `<li>` is given a `class="current"` and parents of it in the contextual menu are given a `class="parent"`. With these, we can create a series of custom styles for each aspect of your menus as follows:

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

Note that `#sidebar` is the ID of the sidebar `<div>` element in Elefant's default layout, and may vary depending on the layout in use on your site.

## Duplicate pages in your site tree

If you want a page to appear in more than one place in your site tree, here's how you do it:

1. Create a duplicate page with the same title and a new page ID
2. In the WYSIWYG editor, click on the `Dynamic Objects` icon
3. Select `Pages: Redirect Link` and enter the link to the original page (e.g., `/original-page-id`)
4. Save this page, then go to Tools > Navigation
5. Add the new page to the secondary location in the site tree

In this way, you maintain more control over your pages and your site tree than maintaining virtual aliases within the navigation tool.

Next: [[:Users and roles]]