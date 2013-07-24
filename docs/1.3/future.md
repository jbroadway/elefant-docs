# Future

## Elefant 2.0

Elefant 2.0 is now feature-complete and nearing final release. We encourage you to [try the latest beta](/download) and help us test it out.

Here is a list of improvements that are included:

* Wysiwyg editor: Make dynamic objects editable ([#21](https://github.com/jbroadway/elefant/issues/21) - Done)
* Translation editing app ([#9](https://github.com/jbroadway/elefant/issues/9) - Done)
* Install themes & apps via zip file upload ([#60](https://github.com/jbroadway/elefant/issues/60) - Done)
* Multiple file upload in file manager ([#64](https://github.com/jbroadway/elefant/issues/64) - Done)
* Quick file upload through wysiwyg editor dialogs ([#65](https://github.com/jbroadway/elefant/issues/65) - Done)
* Rate-limit login attempts with $memcache ([#67](https://github.com/jbroadway/elefant/issues/67) - Done)
* More flexible email sending based on Zend_Mail (Done)
* More complex query building in Model (Done)
* Disqus support for blog comments ([#61](https://github.com/jbroadway/elefant/issues/61) - Done)
* Show dates and times in current user's timezone (Done)
* Control of redirects for SEO (Done)
* Fast batch insertions/updates in Model (Done)
* Renamed Database class to simply DB (Done)
* Added APC as cache backend (Done)
* More customizable access control (Done)
* More photo gallery display options (Done)
* Command line DB schema importer (Done)
* Command line [[CRUD Generator]] (Done)
* View class for better view logic encapsulation (Done)
* `__('Translate me')` alias of `I18n::get()` (Done)
* Added ""show only empty fields"" option to translation editor ([#95](https://github.com/jbroadway/elefant/issues/95) - Done)
* Web-based settings form for user and blog apps ([#66](https://github.com/jbroadway/elefant/issues/66) - Done)
* Provide means of adding synching to S3 ([#31](https://github.com/jbroadway/elefant/issues/31) - Done)
* Edit text files in the file manager (Done)
* Edit images in the file manager via Aviary.com (Done)
* Create custom fields for blog posts, users, and more ([#107](https://github.com/jbroadway/elefant/issues/107) - Done)
* `./conf/elefant update` site upgrade utility ([#36](https://github.com/jbroadway/elefant/issues/36) - Done)
* Role-based access control (Done)
* More language translations (Note: [We can always use help with corrections, updates, and new translations](http://www.elefantcms.com/wiki/Translations))
  * English
  * Chinese
  * Czech
  * Dutch
  * French
  * German
  * Italian
  * Japanese
  * Russian
  * Slovenian
  * Ukrainian

We're always looking for help, so if you see something you'd like to work on, please jump in!

## Custom Apps

[Click here](/shared-apps) for a list of existing Elefant apps.

Here are some ideas for utilities and apps that could be built on Elefant:

* Blog/site importers:
  * Movable Type
  * TextPattern
  * Posthaven
  * Tumblr
  * Drupal
  * Joomla
  * Blogger/blogspot (done)
  * Wordpress (done)
* News
  * Basic
  * With Reddit/HN-style ranking
* A/B and multivariate testing
* Shopping cart
* Banners/ads
* Forum
* Polls
* Mailing lists
* Reusable UI elements:
  * Microformats
  * Ratings
* Custom access control/permissions
* Support for more cloud services