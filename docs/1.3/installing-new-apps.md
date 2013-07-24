# Installing new apps

There are several ways to install apps in Elefant.

For PHP developers, the easiest way will be to use [Composer](/wiki/Using-Composer-packages).

For most users, log into your Elefant site as an admin, then go to Tools > Designer > Install App/Theme and paste the link to the app's zip file download. Elefant will attempt to fetch, unzip, verify, and install the app for you.

To manually install a new app, the basic steps are as follows:

1. Unzip the app into your `/apps/` folder.
2. Look for a `conf/config.php` in the app and edit as needed.
3. Log into Elefant and if there's an install routine that needs to run, it should appear in purple in the Tools menu as `App Name (click to install)`

> Note: Always check for a `README` file in the app for additional steps.

From here, each app may present itself in a number of ways:

1. Apps can usually be found under the Tools menu.
2. Apps may expose new options in the [[Dynamic Objects]] dialog of the page editor.
3. The public access point of an app is likely the URL `/appname`.