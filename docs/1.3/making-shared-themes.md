# Making shared themes

> Note: Here is an example custom theme you can use to refer to or build on:

http://github.com/jbroadway/subtlesquared

You can package a shared theme for use by others as follows:

1. Create your theme template in `layouts` and a matching folder also in `layouts` named the same as your theme, like this:

~~~
layouts/themename.html
layouts/themename/
~~~

2. Put your CSS and other associated files in your `themename` folder.

3. To make your theme the default template, log into the admin area and go to the Designer app. Click the `Make default` link next to your theme name.

4. To package up your theme to share with others, simply zip up the html file and the folder and give them the following instructions:

## Installing a theme

1. Unzip the theme and move the included html file and folder into the `layouts` folder of your Elefant installation.

2. Log into the Elefant admin and go to the Designer app.

3. Click the `Make default` link next to the new theme to activate it on your site.

Next: [[Configuring facebook, twitter and google logins]]