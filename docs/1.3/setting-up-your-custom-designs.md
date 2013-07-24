# Setting up your custom designs

Once you've installed Elefant, log into `/admin` and go to the Designer tool under the Tools menu in the top right.

In the Designer tool, you'll see 2 tabs: Layouts and Stylesheets. Layouts are your design templates, and stylesheets are your CSS files.

## Create the layout

Click `New Layout` under the Layouts tab to create a new layout template. The layout editor looks like this:

![Layout editor](http://jbroadway.github.com/elefant/wiki/layout-editor.png)

You can see a row of links to insert common template tags, a syntax-highlighted HTML editor, and a live preview window underneath.

When you create a new layout, Elefant will provide a default HTML structure that includes all of the necessary template tags. Simply modify the HTML and move the tags to their desired location in your own markup, and use the live preview to verify your changes.

> Tip: Here are a few helpful tags for your layouts:

    <!-- insert top-level navigation menu -->
    {! navigation/top !}
    
    <!-- insert a sub-section menu of pages under ""page-id"" -->
    {! navigation/section?section=page-id !}
    
    <!-- insert a contextual menu that opens up as you browse -->
    {! navigation/contextual !}
    
    <!-- insert an editable area and give it the ID ""block-id"" -->
    {! blocks/block-id !}

> We'll explore those tags further in subsequent tutorials.

One last step before saving your layout: Make sure you add a link to a custom CSS file that we'll create next:

    <link rel=""stylesheet"" href=""/css/custom-stylesheet.css"" />

## Create the stylesheet

Now that we've created a layout, let's give it some style. Under the Stylesheets tab, click `New Stylesheet`. The stylesheet editor looks just like the layout editor, minus the tag links, and with the added ability to choose a layout to preview the stylesheet with.

In this case, make sure you give your stylesheet the correct name, and select the layout created in the previous step.

> Tip: You can upload images through the Files tool and refer to them in your CSS like this:

~~~
body {
    background: url(/files/image-name.jpg);
}
~~~

Once you've got your CSS looking the way you want, save it and go back to the Layouts. Your new layout will appear as an option in the page editor, and to make it the default layout used on the site, click the `Make default` link next to it in the Layouts list.

That's all there is to setting up your custom designs in Elefant.

Next: [[Building a layout file from scratch]]