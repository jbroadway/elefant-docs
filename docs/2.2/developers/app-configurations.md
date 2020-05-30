# App configurations

App configurations live in the `conf` folder inside your app. There are a number of configuration files for the various ways an app can integrate into the Elefant system, which are [documented here](/docs/2.2/developers/making-your-own-apps#configuration-files).

This page will focus on the `config.php` file, where your custom configurations should live.

Aside from the `[Admin]` section, you are free to name your sections anything you'd like, and create any settings you need within those sections. Most Elefant apps use the app name or `[General]` for the main settings, for example:

~~~
[Blog]

; This is the title of your blog index page (/blog).
title = Blog

; This is the layout to use for blog listing pages.
layout = default
~~~

These can be accessed anywhere in your code via `Appconf::get ('blog', 'Blog', 'title')` or the shorthand `Appconf::blog ('Blog', 'title')`.

## The `[Admin]` section

The `[Admin]` section of `config.php` is reserved for instructions on how Elefant should integrate your app into the Tools menu and a few other things. A typical `[Admin]` section will look like this:

~~~
[Admin]

handler = blog/admin
name = Blog Posts
install = blog/upgrade
upgrade = blog/upgrade
version = 1.1.3-stable
sitemap = "blog\Post::sitemap"
~~~

The settings are as follows:

* `handler` - The handler to link to from the Tools menu
* `install` - The handler to link to to perform the app installation
* `name` - The name to show in the Tools menu
* `platform` - A comma-separated list of platforms supported by the app's admin interface. This can be used to hide unsupported apps from appearing on touch devices, for example.
* `sitemap` - A method call that provides a list of URLs for the Google sitemap
* `upgrade` - The handler to link to to perform app upgrades
* `version` - The app's version number, used to determine if an upgrade is needed

## User editable configurations

Users should not need to edit the `config.php` file directly. Instead, we recommend developers provide a settings form in the app itself for users to change specific settings.

See [[Developers / Sharing your apps / User configurable app settings]] for more info and examples.

Back: [Configuration files](/docs/2.2/developers/making-your-own-apps#configuration-files)