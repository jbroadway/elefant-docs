# Changelog

## Elefant 1.3.x Beta

Elefant 1.3.x is the beta series that will lead up to Elefant 2.0. For info on our goals and progress, see the [[Future]] page.

**General improvements**

* Support for Japanese, Dutch, French, Italian, Chinese, and more (and an app to help translators edit and manage multilingual sites)
* Install apps or themes via zip file or GitHub repository
* Multi-file and drag & drop uploads in the file manager
* Disqus support for blog comments
* Rate-limited logins and other security improvements
* Dates/times appear in current user's timezone
* Better redirect control for SEO
* Much improved WYSIWYG editor ([Redactor](http://imperavi.com/redactor/))
* Better integration the WYSIWYG editor and the CMS (files, links, dynamic content)
* Add custom fields to blog posts, users with zero coding
* More customizable access control
* More photo gallery display options
* More social plugin options
* Cleaner, simpler user interface

**Framework improvements**

* New Mailer class wraps Zend_Mail to improve email sending
* Support for more complex queries in models
* Support for relationships between models
* Fast batch insertions/updates in models
* Standard API for localizing dates
* Caching now supports Memcache, Redis, APC and files
* AppTest class extends PHPUnit to support user interface testing
* New APIs: FileManager, Link, Image, Validator
* New [[JavaScript and Client Side Helpers]]
* Improved multilingual options
* [Ridiculously easy form API](/wiki/Code-example:-Ridiculously-easy-forms)
* More tests and numerous minor improvements

### 1.3.5 Beta - April 21, 2013

* Better error message when `ZipInstaller` fails
* Designer app remembers the tab you were on last
* Designer app should recognize CSS files in subfolders of themes
* Added `session_domain` setting so sessions can work across subdomains
* Added `session_duration` setting to control session expiry length
* Fixed fatal error in translator add handler
* File browser option to select multiple files at once
* Fixed jQuery filedrop plugin in IE9
* Refactored Appconf from `Controller::handle()` into its own class
* Config cascade now includes `conf/config.php` when `ELEFANT_ENV` is set
* Added `navigation_json` setting so the file path isn't hard-coded
* Added `filemanager_path` setting so upload folder can be configured
* Updated SimplePie to fix deprecated warnings
* Improved file selection in `$.filebrowser()` and multi-file/image helpers
* Standardized handler overriding via new `Controller::override()` method
* Handler overriding can also be used to enable/disable features
* Links to `/index` now simply point to `/` for better SEO control
* Added role-based access control with fine-grained access to individual apps
* Access control is now as easy as `$this->require_acl('admin', 'myapp');`

### 1.3.4 Beta - April 8, 2013

* Reverted undo/redo to Redactor 8 API
* Prevent default action on button click (dynamic objects)
* Sanity checks in case of empty directories (file manager)
* Added error check to `MongoManager::get_database()`
* Improved error handling on Mongo connection failure
* Controller tests now use `conf/test.php`
* Added apps to PHPUnit config
* Added default handlers to Restful API for more flexible routing
* `Controller::hook()` returns output instead of dropping it
* `Page::render()` calls `page/render` hook for post-processing
* Removed PHP notice in web installer when `$_GET['step']` isn't set
* Updated Redactor to 8.2.5
* `Image::resize()` catches exception if image file is corrupted
* Added printer-friendly styles to default layout
* Updated Colorbox to 1.4.6
* Apps can now appear in page list in the Navigation app
* Added `include_in_nav` to blog app
* Blog app sets its page ID for site navigation
* Shell arguments now escaping properly when passed to handlers
* Disabled Redactor's convertDivs setting
* Regex is now case-insensitive (file manager)
* Made the /admin login redirect a setting in the admin app config
* Default layout selection in stylesheet editor should come from config
* Fixed prefix issue in `./elefant import-db` command
* Fixed Mongo test suite when Mongo is unavailable
* Embedded gallery photo captions now editable from front-end
* Fixed `I18n::export()` with single string parameter
* `Validator::validate()` shouldn't evaluate '0' as empty

### 1.3.3 Beta - March 20, 2013

* Patched jQuery filedrop for IE10 support
* Improved PHPUnit test suite configuration
* Added `FileManager` class separate from REST API
* Added `navigation/languages` language switcher
* Added `Link::base_domain()` for removing subdomain
* 960.gs stylesheets are compiled/compressed in default layout
* Image resizing preserves transparency in PNG and GIF output
* Image resizing has style options (cover, stretch, and contain)
* Added `User::current()` to get currently active user
* Added preview of images on hover in file manager
* Added Link class for generating correct URLs
* Elefant's autoloader now checks for subsequent autoloaders
* Added initial unit tests for navigation handlers
* Updated deprecated references to `db_*()` and `i18n_*()`
* Added `i18n()`, `page()`, `cache()`, and `template()` getter/setters to Controller
* Changed object references in Controller for easier injection
* I18n strings for individual apps are auto-loaded on first app access
* Added `./elefant bundle-translations` command to bundle app strings
* Translation editor now shows all sources of a string
* Removed uploadify/multi-uploader since the main one now supports multiple files
* Added edit buttons to front-end of blog posts
* Added user chooser to blog author field
* Fixed blog RSS caching
* Changed dynamic objects icon to a cog
* Fixed translation editor handling apostrophes
* If custom fields are required, the section defaults to being open
* Refreshed default theme for Elefant 2
* New admin UI theme for Elefant 2
* Added multilingual mode for dynamic navigation handlers
* Added support for nested URLs (e.g., `/about/careers/how-to-apply`)
* Improved `I18n::negotation()` when `negotiation_method=url`
* Added support for dynamic drop downs as custom fields
* Inline edit buttons are now a single sprite image
* Added ability to specify multiple user types for a single access level
* Migrated photo galleries from Fancybox to Colorbox
* Added `filemanager/util/multi-image` helper
* Added `filemanager/util/multi-file` helper
* Updated jQuery UI to 1.10.0
* Added `$.i18n()` helper and `I18n::export()` for translatable strings in JavaScript
* Added `admin/util/notifier` helper
* Added `user/util/userchooser` helper
* Drag & drop upload support in file browser helper
* Drag & drop to move files/folders in file manager
* Drag & drop upload support in file manager
* Added Italian translation
* Added thumbnail image selection mode to filebrowser helper
* Added `filemanager/util/browser` helper
* Improved CRUD app generator
* Updated Chinese and Russian translations
* Fixed autoloader issue with Zend packages
* Added German translation
* Updated jQuery to 1.8.3
* Fixed htaccess Godaddy compatibility
* Added Redactor plugins for internal links, images and files
* Added Redactor plugin for dynamic object embedding
* Replaced jWYSIWYG editor with Redactor
* Delete pages, blog posts, etc. now use POST
* Added `$.confirm_and_post()` helper for quick POST via links
* Cleaned up navigation API
* Redesigned navigation admin page
* New CLI update script for applying Elefant updates
* Improved file/folder validation
* Custom fields can be re-ordered via drag & drop
* `ExtendedModel::orig()` now returns extended fields
* Added custom fields to blog posts and users
* Blocks can now be per-page with fallbacks
* Template sub-expressions now more flexible
* Added `admin/util/extended` helper for building extendable models
* Added Font Awesome as `admin/util/fontawesome` helper
* Added breadcrumb navigation to dynamic objects list
* Added display_errors toggle setting
* Made dynamic objects dialog available via `admin/util/dynamicobjects` helper
* Redesigned dynamic objects dialog
* Dynamic objects can be clicked to be edited in wysiwyg editor
* Added `fetch_url()` function which abstracts curl/fsockopen differences
* Text file and image editing (via Aviary) in the file manager
* Replaced SimpleModal in `$.open_dialog()`, now supports sub-modals
* Improved dynamic objects display in the wysiwyg editor
* Added prefix for APC keys
* Google +1 button uses div instead of invalid `g:plusone` tag
* Fixed warnings in strict mode (PHP 5.4)
* Autoloader fails are caught when debugging is enabled
* Added `admin/util/extended` helper
* Fixed `Ini::write()` for array values
* Added `Model::table()` and `Model::key()`
* Added user settings form
* Removed broken auto-post to Twitter
* Updated slideshow to support multiple instances
* Added social buttons on/off to blog settings
* Added blog settings form
* Added configurable database table name prefix
* Updated Facebook Login to allow for same email

### 1.3.2 Beta - September 13, 2012

* Added URLify to lib/vendor for transliteration in friendly URLs
* Updated translations (Chinese, Czech, Russian, Ukrainian)
* Can enable/disable specific social services in blog
* Improvements to query building in Model
* Translations app manages localized date/time formats
* File manager allows HTML5-based multiple file upload
* Improved language negotiation with Safari
* Better error handling in Restful APIs
* Redirects now use absolute URIs
* Added View class to provide better encapsulation of view logic
* Added `__()` as alias of `I18n::get()` and `I18n::getf()`
* Fixed missing dynamic embeds in `blog/index`
* Added hooks for `filemanager/add`, `filemanager/rename`, and `filemanager/delete`
* Added `elefant crud-app` command to generate CRUD app scaffolding
* Template includes can now span multiple lines for clarity
* Improvements to the modal dialog behaviour
* Renamed and improved dynamic embeds for the blog app
* Added `admin/util/wysiwyg` handler to more easily use a WYSIWYG editor
* Refactored input validation into a Validator class
* Added numbered pagers to make it easier to browse long lists
* More flexible template syntax for looping and conditions
* Added `$.confirm_and_post(a, msg)` to POST from a link with `data-id` attribute
* Moved command line tool to site root as `./elefant`
* Added ability for apps to extend the CLI command list
* Added `beginTransaction()`, `commit()` and `rollback()` to DB
* Renamed `$memcache` to just `$cache`
* Added custom app configurations in main `conf/` folder to avoid editing original source files
* Added sample `robots.txt` with Elefant defaults
* Numerous other minor fixes and improvements

### 1.3.1 Beta - May 1, 2012

* Fixed MySQL schema error
* Added new social plugin options
* Improved Dynamic Objects menu formatting

## Elefant 1.2 Stable - March 20, 2012

Elefant 1.2 is now stable and includes many improvements:

**Performance improvements**

* Added automatic caching to handlers
* Added support for chunked transfer encoding
* Wrapped navigation in caching for improved performance
* Automatically cache public pages without dynamic includes
* Caching to filesystem if Memcache is unavailable
* Lazy loading of database connections

**Improvements for designers**

* Admin UI is easily rebrandable
* Browser detection, and mobile version of default layout

**User interface improvements**

* Wysiwyg editor: Dynamic object to embed arbitrary HTML
* Software update notices in the admin toolbar
* Link dialog can now browse uploaded files
* Dynamic objects includes embedding mp3, mp4, and flash
* New 'All Pages' screen to offer another way of editing pages
* New 'Website' link in toolbar makes navigation of CMS clearer
* Blog importers from Blogger.com and Wordpress
* Improved multilingual support

**Framework improvements**

* MongoDB support via MongoModel class
* Environment switching (development, staging, production)
* `./conf/elefant export-db` command
* `./conf/elefant backup` command
* New Restful class makes creating REST APIs much easier/cleaner
* Support for the PHP 5.4 built-in web server
* Support for PostgreSQL as a database
* Added bootstrap.php for global configurations
* Added [Pimple](http://pimple.sensiolabs.org/) dependency injection container to `lib/vendor`
* Added [Analog](https://github.com/jbroadway/analog) logging package to `lib/vendor`
* Moved `ActiveResource` class to `lib/vendor`
* Added subfolder support ([via alternate front controller](http://www.elefantcms.com/forum/discussion/26/subfolder-installation-support/p1))
* [Even less boilerplate](/wiki/Code-example:-Ridiculously-easy-forms) for building custom forms
* Lots of other minor improvements and fixes

### 1.2.2 Stable - September 13, 2012

* Fixed security issue with layout and css previews

### 1.2.1 Stable - September 11, 2012

* Fixed broken Lock tests
* Fixed admin user edit not updating type
* Fixes to dynamic objects dialog
* Updated hard-coded references to User for proper inheritance
* Improved language negotiation with Safari
* Better error handling in Restful APIs
* Redirects now use absolute URIs
* Added View class to provide better encapsulation of view logic
* Added `__()` as alias of `I18n::get()` and `I18n::getf()`
* Fixed escaping on special characters in database passwords
* Fixed OpenID truncation issue
* Fixed XSS vulnerability in `admin/versions`
* Fixed missing `run_includes()` in `blog/index`
* Fixed numerous other bugs

## Older Releases

### 1.1.5 Beta

* Fixed a potential XSS security hole in page add/edit previews
* Secured lib/Model from a possible source of SQL injection

### 1.1.4 Beta

* Fixed a typo in the MySQL schema

### 1.1.3 Beta

* Improved translation builder coverage
* Install folder no longer has to be writeable
* Themes can now be self-contained in subfolders of `layouts`
* Better error handling in MongoManager
* Web installer can now be translated
* WYSIWYG editor is now translated as well
* Language now determined by `Accept-Language` header by default
* Password hashing now uses Blowfish by default
* ExtendedModel for arbitrary properties now used on User and blogPost models
* Fixes to blog importers

### 1.1.2 Beta

* Improved Cache API for non-Memcache sites
* Improved mobile/tablet user agent detection
* Several fixes for better i18n support
* PostgreSQL now supported in site backup utility
* Wordpress and CSV blog post importers
* User API has been improved, along with new unit tests
* Form API now features an ultra-concise closure-based handling technique
* Improved the Designer app to maximize screen space for editing layouts and stylesheets
* New/improved unit tests
* Fixed numerous other bugs

### 1.1.1 Beta

* Fixed a conflict between PHP 5.4 built-in server support and the file manager
* Fixed a conflict between the MySQL and PostgreSQL connection info in the web installer
* Updated file manager to use the new RESTful API

## 1.0 Branch

### 1.0.2 Stable

* Fixed a potential XSS security hole in page add/edit previews
* Secured lib/Model from a possible source of SQL injection

### 1.0.1 Stable

* Added mobile support to default layouts
* Added browser detection via a new `detect()` function
* Added quotes filter to blog, block, and user edit forms
* Stopped filtering `title` and `window_title` on default template.
* Stopped filtering `title` and `window_title` on index template.
* Stopped filtering window_title on admin template.
* Added `|quotes` filter to templates to convert double-quotes to `&quot;` for form input values, and changed page titles to use it instead of `Template::sanitize()`
* Fixed warning in database test
* Updated wiki links in README
* Added check for bootstrap.php to front controller so developers can load custom framework-wide initializations
* Added missing charset meta tags to default layouts
* Improved security by increasing file restrictions in sub-folders
* Moved jQuery UI code from Google CDN to local copies
* Added space between file upload and submit button