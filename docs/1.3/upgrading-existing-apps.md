# Upgrading existing apps

The steps to upgrade an Elefant app are usually as follows:

1. Always back up your site first.
2. Look for a `conf/config.php` in the app and note any custom settings.
3. Unzip the new app version into your `/apps/` folder (replacing the old version).
4. Update the new `conf/config.php` with your custom settings.
5. Log into Elefant and if there's an update routine that needs to run, it should appear in purple in the Tools menu as `App Name (click to upgrade)`

Always check for a `README` file in the app for additional steps.